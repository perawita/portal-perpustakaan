<?php

namespace App\Models;

use App\Database\Connection;

class Loans extends Connection
{
    public function create($user_id, $book_id, $loan_date, $return_date, $quantity)
    {
        $stmt = $this->conn->prepare("INSERT INTO loans (user_id, book_id, loan_date, return_date, quantity) VALUES (?, ?, ?, ?, ?)");
        if ($stmt === false) {
            throw new \Exception('Prepare failed: ' . $this->conn->error);
        }

        $bind = $stmt->bind_param("iissi", $user_id, $book_id, $loan_date, $return_date, $quantity);
        if ($bind === false) {
            throw new \Exception('Bind param failed: ' . $stmt->error);
        }

        $execute = $stmt->execute();
        if ($execute === false) {
            throw new \Exception('Execute failed: ' . $stmt->error);
        }

        $stmt->close();
        return true;
    }

    public function read($id = null, $user_id = null)
    {
        if ($id !== null && $user_id === null) {
            $stmt = $this->conn->prepare(
                "SELECT loans.*, loans.created_at AS tanggal_pinjam, loans.quantity AS jumlah_pinjam, loans.id AS history_id, SUM(loans.quantity) OVER() AS total_buku_di_pinjam, books.*, categories.*, user.full_name, user.id_user
                FROM loans
                LEFT JOIN books ON books.id = loans.book_id
                LEFT JOIN user ON user.id_user = loans.user_id
                LEFT JOIN categories ON categories.id = books.category_id 
                WHERE loans.id = ? 
                ORDER BY loans.id DESC"
            );
            $stmt->bind_param("i", $id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        } elseif ($user_id !== null && $id === null) {
            $stmt = $this->conn->prepare(
                "SELECT loans.*, loans.created_at AS tanggal_pinjam, loans.quantity AS jumlah_pinjam, loans.id AS history_id, SUM(loans.quantity) OVER() AS total_buku_di_pinjam, books.*, categories.*, user.full_name, user.id_user, user.contact
                FROM loans
                LEFT JOIN books ON books.id = loans.book_id
                LEFT JOIN user ON user.id_user = loans.user_id
                LEFT JOIN categories ON categories.id = books.category_id 
                WHERE loans.user_id = ? 
                ORDER BY loans.id DESC"
            );
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } else {
            $result = $this->conn->query(
                "SELECT loans.*, loans.created_at AS tanggal_pinjam, loans.quantity AS jumlah_pinjam, loans.id AS history_id, books.*, categories.*, user.*
                FROM loans
                LEFT JOIN books ON books.id = loans.book_id
                LEFT JOIN user ON user.id_user = loans.user_id
                LEFT JOIN categories ON categories.id = books.category_id
                ORDER BY loans.id DESC"
            );
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }


    public function update($id, $user_id, $book_id, $loan_date, $return_date, $returned, $quantity)
    {
        $stmt = $this->conn->prepare("UPDATE loans SET user_id = ?, book_id = ?, loan_date = ?, return_date = ?, returned = ?, quantity = ? WHERE id = ?");
        $stmt->bind_param("iissiii", $user_id, $book_id, $loan_date, $return_date, $returned, $quantity, $id);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM loans WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }


    public function stor_books($id, $returned, $quantity)
    {
        $stmt = $this->conn->prepare("UPDATE loans SET returned = ?, quantity = quantity - ? WHERE id = ?");
        $stmt->bind_param("iii", $returned, $quantity, $id);
        return $stmt->execute();
    }


    public function books_populers()
    {
        try {
            $sql = "SELECT books.*, books.quantity AS jumlah_buku , loans.*, sum(loans.quantity) AS jumlah_pinjam
                FROM loans
                LEFT JOIN books ON loans.book_id = books.id
                WHERE loans.returned IN (0, 2)
                GROUP BY books.id";

            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                return $result->fetch_all(MYSQLI_ASSOC);
            } else {
                return false;
            }
        } catch (\Exception $e) {
            throw new \Exception('Error retrieving popular books: ' . $e->getMessage());
        }
    }
}
