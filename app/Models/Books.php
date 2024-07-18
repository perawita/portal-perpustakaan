<?php

namespace App\Models;

use App\Database\Connection;

class Books extends Connection
{

    public function create($category_id, $title, $author, $publication_year, $isbn, $cover_image, $quantity)
    {
        $stmt = $this->conn->prepare("INSERT INTO books (category_id, title, author, publication_year, isbn, cover_image, quantity) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            throw new \Exception('Prepare failed: ' . $this->conn->error);
        }

        $bind = $stmt->bind_param("isssssi", $category_id, $title, $author, $publication_year, $isbn, $cover_image, $quantity);
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

    public function read($id = null)
    {
        if ($id) {
            $stmt = $this->conn->prepare(
                "SELECT books.*, categories.name AS category_name, categories.description AS category_description 
                 FROM books 
                 LEFT JOIN categories ON categories.id = books.category_id
                 WHERE books.id = ?"
            );
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            } else {
                return null;
            }
        } else {
            $result = $this->conn->query(
                "SELECT books.*, categories.name AS category_name, categories.description AS category_description 
                 FROM books 
                 LEFT JOIN categories ON categories.id = books.category_id"
            );
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }


    public function update($id, $category_id, $title, $author, $publication_year, $isbn, $cover_image, $quantity)
    {
        $stmt = $this->conn->prepare("UPDATE books SET category_id = ?, title = ?, author = ?, publication_year = ?, isbn = ?, cover_image = ?, quantity = ? WHERE id = ?");
        $stmt->bind_param("isssssii", $category_id, $title, $author, $publication_year, $isbn, $cover_image, $quantity, $id);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM books WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function read_quantity($id)
    {
        $stmt = $this->conn->prepare("SELECT quantity FROM books WHERE id = ? FOR UPDATE");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function change_quantity($id, $newStock)
    {
        $stmt = $this->conn->prepare("UPDATE books SET quantity = ? WHERE id = ?");
        $stmt->bind_param("ii", $newStock, $id);
        $stmt->execute();
        return true;
    }
}
