<?php

namespace App\Https\Controllers;


class CategoriesController extends Controller
{
    public function create_categorie($name, $description)
    {
        try {
            $upload = $this->categories->create($name, $description);
            if ($upload) {
                echo "<script>alert('Kategori berhasil di tambah!'); window.location.href = '../?views=Data-kategori';</script>";
            } else {
                echo "<script>alert('Kategori gagal di tambah!'); window.location.href = '../?views=Data-kategori';</script>";
            }
        } catch (\Exception $e) {
            echo "<script>alert('Penambahan Kategori gagal: " . $e->getMessage() . "'); window.location.href = '../?views=Data-kategori';</script>";
        }
    }


    public function update_categorie($id, $name, $description)
    {
        try {
            $upload = $this->categories->update($id, $name, $description);
            if ($upload) {
                echo "<script>alert('Kategori berhasil di update!'); window.location.href = '../?views=Data-kategori';</script>";
            } else {
                echo "<script>alert('Kategori gagal di update!'); window.location.href = '../?views=Data-kategori';</script>";
            }
        } catch (\Exception $e) {
            echo "<script>alert('Penambahan Kategori gagal: " . $e->getMessage() . "'); window.location.href = '../?views=Data-kategori';</script>";
        }
    }


    public function delete_categorie($id)
    {
        try {
            $upload = $this->categories->delete($id);
            if ($upload) {
                echo "<script>alert('Kategori berhasil di delete!'); window.location.href = '../?views=Data-kategori';</script>";
            } else {
                echo "<script>alert('Kategori gagal di delete!'); window.location.href = '../?views=Data-kategori';</script>";
            }
        } catch (\Exception $e) {
            echo "<script>alert('Delete Kategori gagal: " . $e->getMessage() . "'); window.location.href = '../?views=Data-kategori';</script>";
        }
    }
}
