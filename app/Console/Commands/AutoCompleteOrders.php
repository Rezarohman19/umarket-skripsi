<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use Carbon\Carbon;

class AutoCompleteOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:auto-complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically complete orders after 3 days of shipping without buyer confirmation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting auto-completion check...');

        $threshold = Carbon::now()->subDays(3);

        // Find transactions that are 'shipping' (or 'sent') and updated_at < 3 days ago
        // Adjust the status check based on what your application uses for "Order Sent"
        $transactions = Transaction::whereIn('status', ['shipping', 'sent'])
            ->where('updated_at', '<', $threshold)
            ->get();

        $count = 0;
        foreach ($transactions as $transaction) {
            // Update to 'delivered' as per the logic in mark-delivered route
            $transaction->status = 'delivered';
            $transaction->save();
            $count++;
            $this->info("Transaction ID {$transaction->id} marked as delivered (auto-completed).");
        }

        $this->info("Completed {$count} orders.");
    }
}
