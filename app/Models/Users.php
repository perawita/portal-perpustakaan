<?php

namespace App\Models;

use App\Database\Connection as koneksi;

class Users extends koneksi
{
    public function login($username, $password)
    {
        if ($username && $password) {
            $stmt = $this->conn->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($this->conn->error));
            }

            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        } else {
            return false;
        }
    }

    public function create($username, $password, $full_name, $contact, $role)
    {
        $stmt = $this->conn->prepare("INSERT INTO user (username, password, full_name, contact, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $password, $full_name, $contact, $role);
        return $stmt->execute();
    }

    public function read($id_user = null)
    {
        if ($id_user) {
            $stmt = $this->conn->prepare("SELECT * FROM user WHERE id_user = ?");
            $stmt->bind_param("i", $id_user);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        } else {
            $result = $this->conn->query("SELECT * FROM user");
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function update($id_user, $username, $password, $full_name, $contact, $role)
    {
        $stmt = $this->conn->prepare("UPDATE user SET username = ?, password = ?, full_name = ?, contact = ?, role = ? WHERE id_user = ?");
        if ($stmt === false) {
            throw new \Exception('Prepare failed: ' . $this->conn->error);
        }

        $bind = $stmt->bind_param("sssssi", $username, $password, $full_name, $contact, $role, $id_user);
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

    public function delete($id_user)
    {
        $stmt = $this->conn->prepare("DELETE FROM user WHERE id_user = ?");
        $stmt->bind_param("i", $id_user);
        return $stmt->execute();
    }
}
