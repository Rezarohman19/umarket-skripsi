<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
            'profile' => $request->user()->profile
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'        => 'nullable|string|max:255',
            'email'       => 'nullable|email|unique:users,email,' . ($request->user()->id ?? 'NULL'),
            'password'    => 'nullable|min:6',
            'description' => 'nullable|string',
            'address'     => 'nullable|string',
            'phone'       => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'remove_photo'=> 'nullable',
        ]);

        try {
            $user = $request->user();

            // Update user fields
            $userData = [];
            if ($request->filled('name')) $userData['name'] = $request->name;
            if ($request->filled('email')) $userData['email'] = $request->email;
            if ($request->filled('description')) $userData['description'] = $request->description;
            if ($request->filled('phone')) $userData['phone'] = $request->phone;
            if ($request->filled('address')) $userData['address'] = $request->address;
            if ($request->filled('password')) $userData['password'] = Hash::make($request->password);
            
            if (!empty($userData)) {
                $user->update($userData);
            }

            // Ensure profile exists
            $profile = $user->profile ?? $user->profile()->create([]);

            // Handle photo upload / removal
            if ($request->hasFile('photo')) {
                // Delete old photo if exists
                if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                    Storage::disk('public')->delete($user->photo);
                }

                $file = $request->file('photo');
                $photoPath = $file->store('profiles', 'public');
                $user->photo = $photoPath;
                $user->save();
            } elseif ($request->filled('remove_photo')) {
                // Remove photo
                if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                    Storage::disk('public')->delete($user->photo);
                }
                $user->photo = null;
                $user->save();
            }

            // Refresh user data
            $user = $user->fresh();
            
            // Add photo_url field untuk frontend
            $userArray = $user->toArray();
            $userArray['photo_url'] = $user->photo ? Storage::url($user->photo) : null;
            
            return response()->json([
                'message' => 'Profile updated successfully',
                'user' => $userArray,
                'profile' => $profile
            ]);
        } catch (\Throwable $e) {
            report($e);
            $msg = config('app.debug') ? $e->getMessage() : 'Gagal memperbarui profil';
            return response()->json(['message' => $msg], 500);
        }
    }

    public function listUsers()
    {
        return response()->json(\App\Models\User::all());
    }

    public function getBanks(Request $request)
    {
        try {
            $userId = Auth::id();
            Log::info('getBanks attempt', ['user_id' => $userId, 'session_id' => session()->getId()]);
            if (!$userId) {
                Log::warning('getBanks: User unauthenticated');
                return response()->json(['message' => 'Unauthenticated'], 401);
            }
            $banks = \App\Models\BankAccount::where('user_id', $userId)
                ->where('is_active', true)
                ->get();
            return response()->json($banks);
        } catch (\Exception $e) {
            Log::error('getBanks Error: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function addBank(Request $request)
    {
        try {
            $userId = Auth::id();
            Log::info('addBank attempt', ['user_id' => $userId, 'session_id' => session()->getId(), 'payload' => $request->all()]);
            if (!$userId) {
                Log::warning('addBank: User unauthenticated');
                return response()->json(['message' => 'Unauthenticated'], 401);
            }

            $validated = $request->validate([
                'bank_name' => 'required|string',
                'account_number' => 'required|string',
                'account_holder' => 'required|string',
            ]);

            $bank = \App\Models\BankAccount::create([
                'user_id' => $userId,
                'bank_name' => $validated['bank_name'],
                'account_number' => $validated['account_number'],
                'account_holder' => $validated['account_holder'],
                'is_active' => true,
            ]);

            return response()->json($bank, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('addBank Error: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menambah rekening'], 500);
        }
    }

    public function deleteBank(Request $request, $id)
    {
        $bank = \App\Models\BankAccount::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();
        
        $bank->update(['is_active' => false]);
        return response()->json(['message' => 'Success']);
    }

    public function getWithdrawals(Request $request)
    {
        $withdrawals = \App\Models\Withdrawal::with('bankAccount')
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($withdrawals);
    }

    public function getBalance(Request $request)
    {
        $user = $request->user();
        
        $totalSold = \App\Models\Transaction::where('user_id', '!=', $user->id)
            ->whereHas('items', function($query) use ($user) {
                $query->whereHas('product', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            })
            ->whereIn('status', ['delivered', 'completed'])
            ->sum('total_price');

        $totalWithdrawn = \App\Models\Withdrawal::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('amount');

        $balance = max(0, $totalSold - $totalWithdrawn);

        return response()->json([
            'balance' => $balance,
            'total_sold' => $totalSold,
            'total_withdrawn' => $totalWithdrawn,
        ]);
    }

    public function withdraw(Request $request)
    {
        $user = $request->user();
        $amount = $request->input('amount');
        $bankAccountId = $request->input('bank_account_id');

        if (!$amount || $amount < 50000) {
            return response()->json(['message' => 'Minimum Rp 50.000'], 422);
        }

        // Re-calculate balance for security
        $totalSold = \App\Models\Transaction::where('user_id', '!=', $user->id)
            ->whereHas('items', function($query) use ($user) {
                $query->whereHas('product', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            })
            ->whereIn('status', ['delivered', 'completed'])
            ->sum('total_price');
        $totalWithdrawn = \App\Models\Withdrawal::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('amount');
        $balance = max(0, $totalSold - $totalWithdrawn);

        if ($amount > $balance) {
            return response()->json(['message' => 'Saldo tidak cukup'], 422);
        }

        $withdrawal = \App\Models\Withdrawal::create([
            'user_id' => $user->id,
            'bank_account_id' => $bankAccountId,
            'amount' => $amount,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Success', 'withdrawal' => $withdrawal], 201);
    }
}
