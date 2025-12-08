<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // GET: semua user
    public function index()
    {
        return response()->json(User::all());
    }

    // POST: tambah user
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'in:admin,pengguna'
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role ?? 'pengguna'
        ]);

        return response()->json($user, 201);
    }

    // GET: detail user
    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }

    // PUT/PATCH: update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'string',
            'email' => 'email|unique:users,email,' . $id,
            'role'  => 'in:admin,pengguna'
        ]);

        if ($request->has('password')) {
            $request->validate(['password' => 'min:6']);
            $user->password = Hash::make($request->password);
        }

        $user->update($request->except('password'));

        return response()->json($user);
    }

    // DELETE: hapus user
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['message' => 'User deleted']);
    }
}
