<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TransactionItem;

class CleanupOrphanedTransactionItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:orphaned-transaction-items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghapus transaction_items yang produknya sudah dihapus';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai cleanup transaction_items yang produknya sudah dihapus...');

        // Cari transaction_items yang product_id-nya tidak ada di tabel products
        // Menggunakan left join untuk menemukan orphaned records
        $orphanedItems = TransactionItem::leftJoin('products', 'transaction_items.product_id', '=', 'products.id')
            ->whereNull('products.id')
            ->select('transaction_items.*')
            ->get();

        $count = $orphanedItems->count();

        if ($count === 0) {
            $this->info('Tidak ada transaction_items yang perlu dihapus.');
            return Command::SUCCESS;
        }

        $this->warn("Ditemukan {$count} transaction_items yang akan dihapus.");

        // Tampilkan detail
        $this->table(
            ['ID', 'Transaction ID', 'Product ID', 'Qty', 'Price'],
            $orphanedItems->map(function ($item) {
                return [
                    $item->id,
                    $item->transaction_id,
                    $item->product_id,
                    $item->qty,
                    $item->price,
                ];
            })->toArray()
        );

        if ($this->confirm('Apakah Anda yakin ingin menghapus data tersebut?', true)) {
            $ids = $orphanedItems->pluck('id')->toArray();
            $deleted = TransactionItem::whereIn('id', $ids)->delete();
            $this->info("Berhasil menghapus {$deleted} transaction_items.");
            return Command::SUCCESS;
        }

        $this->info('Cleanup dibatalkan.');
        return Command::SUCCESS;
    }
}
