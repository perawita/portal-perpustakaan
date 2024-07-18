<?php

namespace App\Https\Controllers;

class LoginController extends Controller
{
    public function sign_up($username, $password, $full_name, $contact)
    {
        $user = $this->users->create($username, $password, $full_name, $contact, 'guest');
        if ($user) {
            echo "<script>alert('Akun berhasil dibuat !'); window.location.href = '../';</script>";
        } else {
            echo "<script>alert('Akun gagal dibuat!'); window.location.href = '?views=sign-up';</script>";
        }
        exit;
    }


    public function login($username, $password, $remember)
    {
        $user = $this->users->login($username, $password);
        if ($user) {
            if ($remember) {
                setcookie('remember_me', $user['id_user'], time() + (30 * 24 * 60 * 60), "/");
            }
            $this->session->set('id', $user['id_user']);

            echo "<script>alert('Login berhasil!'); window.location.href = '../?views=Dashboard';</script>";
        } else {
            echo "<script>alert('Login gagal! Username atau password salah.'); window.location.href = '../';</script>";
        }
        exit;
    }

    public function remember($id_user)
    {
        return $this->users->read($id_user);
    }

    public function logout()
    {
        $this->session->delete('id');
        $this->session->destroy();
        echo "<script>alert('Log out berhasil!'); window.location.href = '../';</script>";
    }
}
