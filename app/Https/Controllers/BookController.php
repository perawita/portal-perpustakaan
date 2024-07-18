<?php

namespace App\Https\Controllers;

class BookController extends Controller
{
    public function create_book($judul, $nama_penulis, $isbn, $jumlah, $tahun_terbit, $kategori, $judul_buku)
    {
        try {
            $upload = $this->books->create($kategori, $judul, $nama_penulis, $tahun_terbit, $isbn, $judul_buku, $jumlah);
            if ($upload) {
                echo "<script>alert('Penambahan buku berhasil!'); window.location.href = '../?views=Data-buku';</script>";
            } else {
                echo "<script>alert('Penambahan buku gagal!'); window.location.href = '../?views=Data-buku';</script>";
            }
        } catch (\Exception $e) {
            echo "<script>alert('Penambahan buku gagal: " . $e->getMessage() . "'); window.location.href = '../?views=Data-buku';</script>";
        }
    }


    public function update_book($id, $judul, $nama_penulis, $isbn, $jumlah, $tahun_terbit, $kategori, $judul_buku)
    {
        try {
            $upload = $this->books->update($id, $kategori, $judul, $nama_penulis, $tahun_terbit, $isbn, $judul_buku, $jumlah);
            if ($upload) {
                echo "<script>alert('Update buku berhasil!'); window.location.href = '../?views=Data-buku';</script>";
            } else {
                echo "<script>alert('Update buku gagal!'); window.location.href = '../?views=Data-buku';</script>";
            }
        } catch (\Exception $e) {
            echo "<script>alert('Update buku gagal: " . $e->getMessage() . "'); window.location.href = '../?views=Data-buku';</script>";
        }
    }


    public function delete_book($id)
    {
        try {
            $upload = $this->books->delete($id);
            if ($upload) {
                echo "<script>alert('Delete buku berhasil!'); window.location.href = '../?views=Data-buku';</script>";
            } else {
                echo "<script>alert('Delete buku gagal!'); window.location.href = '../?views=Data-buku';</script>";
            }
        } catch (\Exception $e) {
            echo "<script>alert('Delete buku gagal: " . $e->getMessage() . "'); window.location.href = '../?views=Data-buku';</script>";
        }
    }
}
