<?php

namespace App\Routes;

use App\Https\Controllers\LoginController as Login;
use App\Https\Controllers\BookController as Book;
use App\Https\Controllers\CategoriesController as Categorie;
use App\Https\Controllers\UserController as user;
use App\Https\Controllers\PinjamController as pinjam;

use App\Services\Upload_img as upload_img;

/**
 * =====================================
 * 
 * 
 * Membuat sebuah router sederhana untuk pemerosesan website.
 * sebagai jalur penghubung frontend dan backend
 * 
 * 
 * =====================================
 */

$request = $_GET['proses'] ?? null;
switch ($request) {
        /**  Start Router Login Controllers **/
    case "login":
        $user = $_POST['email'];
        $pass = $_POST['password'];
        $remember = isset($_POST['rememberMe']) ? true : false;

        $login = new Login();
        $login->login($user, $pass, $remember);
        break;

    case "log-out":
        $login = new Login();
        $login->logout();
        break;

    case "sign-up":

        $username = $_POST['email'];
        $full_name = $_POST['name'];
        $contact = $_POST['contact'];
        $password = $_POST['password'];

        $login = new Login();
        $login->sign_up($username, $password, $full_name, $contact);
        break;
        /** End Router Login Controllers **/
}



use App\Https\Middleware\Session as session;

if ((new session())->get('id') && $request) {
    switch ($request) {
            /** Start Router From Controllers **/
        case "tambah-kategori":
            $judul = $_POST['nama'];
            $deskripsi = $_POST['deskripsi'] ?? "-";

            $categories = new Categorie();
            $categories->create_categorie($judul, $deskripsi);
            break;

        case "edit-kategori":
            $id = $_GET['id'];
            $judul = $_POST['nama'];
            $deskripsi = $_POST['deskripsi'] ?? "-";

            $categories = new Categorie();
            $categories->update_categorie($id, $judul, $deskripsi);
            break;

        case "hapus-category":
            $id = $_GET['id'];

            $categories = new Categorie();
            $categories->delete_categorie($id);
            break;

        case "tambah-buku":
            $judul = $_POST['judul'];
            $nama_penulis = $_POST['nama_penulis'];
            $isbn = $_POST['isbn'];
            $jumlah = $_POST['jumlah'];
            $tahun_terbit = $_POST['tahun_terbit'];
            $kategori = $_POST['kategori'];
            $cover_book = $_FILES['cover_book'] ?? null;

            if (isset($_FILES['cover_book']) && $_FILES['cover_book']['error'] == 0) {
                $judul_buku = (new upload_img('./Storage/app/public/image/'))->handleUpload($cover_book);
                if (strpos($judul_buku, 'Sorry') !== false) {
                    echo '<script>alert("' . $judul_buku . '"); window.location.href = "../?views=Data-buku";</script>';
                } else {
                    $books = new Book();
                    $books->create_book($judul, $nama_penulis, $isbn, $jumlah, $tahun_terbit, $kategori, $judul_buku);
                }
            }
            break;

        case "edit-buku":
            $id = $_GET['id'];
            $judul = $_POST['judul'];
            $nama_penulis = $_POST['nama_penulis'];
            $isbn = $_POST['isbn'];
            $jumlah = $_POST['jumlah'];
            $tahun_terbit = $_POST['tahun_terbit'];
            $kategori = $_POST['kategori'];
            $cover_book = $_FILES['cover_book'] ?? null;
            $old_cover_book = $_POST['old_cover_book'];

            $books = new Book();
            $uploadDir = './Storage/app/public/image/';
            $service_buku = new Upload_img($uploadDir);

            if ($cover_book && $cover_book['error'] == 0) {
                $deleteResult = $service_buku->deleteImage($old_cover_book);

                if (strpos($deleteResult, 'Error') === false) {
                    $new_cover_book = $service_buku->handleUpload($cover_book);

                    if (strpos($new_cover_book, 'Sorry') === false) {
                        $books->update_book($id, $judul, $nama_penulis, $isbn, $jumlah, $tahun_terbit, $kategori, $new_cover_book);
                    } else {
                        echo '<script>alert("' . $new_cover_book . '"); window.location.href = "../?views=Data-buku";</script>';
                    }
                } else {
                    echo '<script>alert("' . $deleteResult . '"); window.location.href = "../?views=Data-buku";</script>';
                }
            } else {
                $books->update_book($id, $judul, $nama_penulis, $isbn, $jumlah, $tahun_terbit, $kategori, $old_cover_book);
            }
            break;

        case "hapus-buku":
            $id = $_GET['id'];

            $cover_book = (new \App\Models\Books())->read($id);

            $books = new Book();
            $uploadDir = './Storage/app/public/image/';
            $service_buku = new Upload_img($uploadDir);

            $deleteResult = $service_buku->deleteImage($cover_book['cover_image']);

            if (strpos($deleteResult, 'Error') === false) {
                $books->delete_book($id);
            } else {
                echo '<script>alert("' . $deleteResult . '"); window.location.href = "../?views=Data-buku";</script>';
            }
            break;

        case 'edit-user':
            $id_user = $_GET['id'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $full_name = $_POST['full_name'];
            $contact = $_POST['contact'];
            $role = $_POST['role'];

            $users = new user();
            $user = $users->update_user($id_user, $username, $password, $full_name, $contact, $role);
            break;

        case 'hapus-user':
            $id_user = $_GET['id'];

            $users = new user();
            $user = $users->delete_user($id_user);
            break;

            /** End Router From Controllers **/


            /**  **/

        case 'from-pinjam':
            $data = json_decode(file_get_contents('php://input'), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                http_response_code(400);
                echo "<script>alert('Data yang diterima bukan JSON yang valid'); window.location.href = '../?views=List-buku';</script>";
                exit;
            }

            $id_buku = $data['id_book'];
            $id_user = $data['id_user'];

            $pinjam = new pinjam();
            echo json_encode($pinjam->infromation(null, $id_buku, $id_user));

            break;

        case 'pinjam':
            $id_buku = $_POST['id_buku'];
            $id_user = $_POST['id_user'];
            $jumlah = $_POST['jumlah_buku'];
            $loan_date = $_POST['tanggal_pinjam'];
            $return_date = $_POST['tanggal_pengembalian'];

            $pinjam = new pinjam();
            $pinjam->pinjam($id_buku, $id_user, $jumlah, $loan_date, $return_date);

            break;


        case 'from-stor-buku':
            $data = json_decode(file_get_contents('php://input'), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                http_response_code(400);
                echo "<script>alert('Data yang diterima bukan JSON yang valid'); window.location.href = '../?views=List-buku';</script>";
                exit;
            }

            $id_history = $data['id_history'];
            $id_buku = $data['id_book'];
            $id_user = $data['id_user'];

            $pinjam = new pinjam();
            echo json_encode($pinjam->infromation(
                $id_history,
                $id_buku,
                $id_user
            ));

            break;

        case 'stor-buku':
            $id_history = $_POST['id_history'];
            $id_book = $_POST['id_buku'];
            $quantity = $_POST['jumlah_buku'];
            $sisa = $_POST['sisa'];

            /**
             * value 2 untuk jumlah pengembalian yang kurang atau belum lunas
             * value 3 untuk jumlah pengembalian yang pas atau lunas
             * @return int | null $returned
             */
            $returned = (int)$quantity < (int)$sisa ? 2 : 3;

            $pinjam = new pinjam();
            $pinjam->stor($id_history, $id_book, $returned, $quantity);

            break;

            /**  **/
    }
}
