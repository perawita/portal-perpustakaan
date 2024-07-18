<?php

namespace App\Https\Controllers;

use App\Services\PlaceOrder as orders;

class PinjamController extends Controller
{
    private $placeOrderService = null;

    public function infromation($id_history, $id_buku, $id_user)
    {
        if ($id_history === null) {
            $book = $this->books->read((int)$id_buku);
            $user = $this->users->read((int)$id_user);

            return array(
                'book' => $book,
                'user' => $user['full_name']
            );
        } else {
            $history = $this->loans->read((int)$id_history);

            return array(
                'history' => $history
            );
        }
        exit;
    }

    public function pinjam($id_buku, $id_user, $jumlah, $loan_date, $return_date)
    {
        // Lazy initialization
        if ($this->placeOrderService === null) {
            $this->placeOrderService = new orders();
        }

        $success = $this->placeOrderService->placeOrder($id_buku, $id_user, $jumlah, $loan_date, $return_date);

        if ($success) {
            echo "<script>alert('Peminjaman berhasil!'); window.location.href = '../?views=List-buku';</script>";
        } else {
            echo "<script>alert('Stok buku tidak mencukupi!'); window.location.href = '../?views=List-buku';</script>";
        }
    }

    public function stor($id_history, $id_book, $returned, $quantity)
    {
        $input = $this->loans->stor_books($id_history, $returned, $quantity);

        if ($input) {
            $row = $this->books->read_quantity($id_book);

            if ($row && $row['quantity']) {
                $newStock = (int)$row['quantity'] + (int)$quantity;
                $update_buku = $this->books->change_quantity($id_book, $newStock);
                if ($update_buku) {
                    echo "<script>alert('Pengembalian berhasil!'); window.location.href = '../?views=History';</script>";
                }
            }
        } else {
            echo "<script>alert('Pengembalian gagal!'); window.location.href = '../?views=History';</script>";
        }
    }
}
