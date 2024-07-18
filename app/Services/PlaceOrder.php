<?php

namespace App\Services;

class PlaceOrder extends Service
{
    function placeOrder($productId, $id_user, $quantity, $loan_date, $return_date): bool
    {
        // Mulai transaksi
        $this->connection->begin_transaction();

        // Ambil stok yang tersedia dengan penguncian untuk menghindari race condition
        $row = $this->books->read_quantity($productId);

        // Jika stok mencukupi
        if ($row && $row['quantity'] >= $quantity && $row['quantity'] >= 1) {
            // Kurangi stok
            $newStock = $row['quantity'] - $quantity;
            $books = $this->books->change_quantity($productId, $newStock);

            if ($books) {
                // Masukkan ke tabel pesanan
                $loans = $this->loans->create($id_user, $productId, $loan_date, $return_date, $quantity);

                if ($loans) {
                    $this->connection->commit();
                    return true;
                }
            }
        } else {
            return false;
        }
    }
}
