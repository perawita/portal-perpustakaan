<?php

namespace App\Https\Controllers;

class UserController extends Controller
{
    private $count_role_super_admin = 0;
    public function update_user($id_user, $username, $password, $full_name, $contact, $role)
    {
        try {
            $check_roles = $this->users->read($id_user);

            if ($check_roles['role'] === 'super admin' && $check_roles['role'] !== $role) {
                $all_roles = $this->users->read();
                foreach ($all_roles as $item) {
                    if ($item['role'] === 'super admin') {
                        $this->count_role_super_admin++;
                    }
                }

                if ($this->count_role_super_admin === 1) {
                    echo "<script>alert('User gagal di update! Minimal harus ada setidak nya satu role Super Admin.'); window.location.href = '../?views=Data-user';</script>";
                    exit();
                }
            }


            $upload = $this->users->update($id_user, $username, $password, $full_name, $contact, $role);
            if ($upload) {
                echo "<script>alert('User berhasil di update!'); window.location.href = '../?views=Data-user';</script>";
            } else {
                echo "<script>alert('User gagal di update!'); window.location.href = '../?views=Data-user';</script>";
            }
        } catch (\Exception $e) {
            echo "<script>alert('Update User gagal: " . $e->getMessage() . "'); window.location.href = '../?views=Data-user';</script>";
        }
    }

    public function delete_user($id)
    {
        try {
            $upload = $this->users->delete($id);
            if ($upload) {
                echo "<script>alert('User berhasil di delete!'); window.location.href = '../?views=Data-user';</script>";
            } else {
                echo "<script>alert('User gagal di delete!'); window.location.href = '../?views=Data-user';</script>";
            }
        } catch (\Exception $e) {
            echo "<script>alert('Delete User gagal: " . $e->getMessage() . "'); window.location.href = '../?views=Data-user';</script>";
        }
    }
}
