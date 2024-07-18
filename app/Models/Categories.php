<?php

namespace App\Models;

use App\Database\Connection;

class Categories extends Connection
{
    public function create($name, $description)
    {
        $stmt = $this->conn->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
        if ($stmt === false) {
            throw new \Exception('Prepare failed: ' . $this->conn->error);
        }

        $bind = $stmt->bind_param("ss", $name, $description);
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
            $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id = ?");
            if ($stmt === false) {
                throw new \Exception('Prepare failed: ' . $this->conn->error);
            }

            $bind = $stmt->bind_param("i", $id);
            if ($bind === false) {
                throw new \Exception('Bind param failed: ' . $stmt->error);
            }

            $execute = $stmt->execute();
            if ($execute === false) {
                throw new \Exception('Execute failed: ' . $stmt->error);
            }

            $result = $stmt->get_result();
            if ($result === false) {
                throw new \Exception('Get result failed: ' . $stmt->error);
            }

            $data = $result->fetch_assoc();
            $stmt->close();
            return $data;
        } else {
            $result = $this->conn->query("SELECT * FROM categories");
            if ($result === false) {
                throw new \Exception('Query failed: ' . $this->conn->error);
            }

            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function update($id, $name, $description)
    {
        $stmt = $this->conn->prepare("UPDATE categories SET name = ?, description = ? WHERE id = ?");
        if ($stmt === false) {
            throw new \Exception('Prepare failed: ' . $this->conn->error);
        }

        $bind = $stmt->bind_param("ssi", $name, $description, $id);
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

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE id = ?");
        if ($stmt === false) {
            throw new \Exception('Prepare failed: ' . $this->conn->error);
        }

        $bind = $stmt->bind_param("i", $id);
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
}
