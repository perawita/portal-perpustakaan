<?php $permission = isset($_COOKIE['remember_me']) ? (new \App\Https\Controllers\LoginController)->remember($_COOKIE['remember_me']) : null; ?>
<?php
try {
    $users = new \App\Models\Users();
    $user_rows = $users->read($_GET['id']);

    if (!empty($user_rows)) {
?>
        <div class="page-header min-height-300 border-radius-xl" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
            <span class="mask  bg-gradient-primary  opacity-6"></span>
        </div>
        <div class="card card-body mx-3 mx-md-4 mt-n6">
            <div class="row gx-4 mb-2">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/1024px-User_icon_2.svg.png" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            <?= $user_rows['full_name'] ?>
                        </h5>
                        <p class="mb-0 font-weight-normal text-sm">
                            <?= $user_rows['role'] ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <div class="p-4">
                        <form action="./app/init.php?proses=edit-user&id=<?= $_GET['id'] ?>" method="POST">

                            <div class="input-group input-group-static mb-4">
                                <label>Full Name</label>
                                <input type="text" name="full_name" value="<?= $user_rows['full_name'] ?>" class="form-control" <?= (int)$user_rows['id_user'] !== (int)$_COOKIE['remember_me'] ? "readonly" : "" ?>>
                            </div>

                            <div class="input-group input-group-static mb-4">
                                <label>Username</label>
                                <input type="text" name="username" value="<?= $user_rows['username'] ?>" class="form-control" <?= (int)$user_rows['id_user'] !== (int)$_COOKIE['remember_me'] ? "readonly" : "" ?>>
                            </div>

                            <div class="input-group input-group-static mb-4">
                                <label>Contact</label>
                                <input type="text" name="contact" value="<?= $user_rows['contact'] ?>" class="form-control" <?= (int)$user_rows['id_user'] !== (int)$_COOKIE['remember_me'] ? "readonly" : "" ?>>
                            </div>

                            <div class="input-group input-group-static mb-4">
                                <label for="exampleFormControlSelect1" class="ms-0">Roles</label>
                                <select class="form-control" name="role" id="exampleFormControlSelect1">
                                    <?php if ($permission['role'] === "super admin") : ?>
                                        <option value="super admin" <?= $user_rows['role'] === "super admin" ? "selected" : "" ?>>Super Admin</option>
                                        <option value="admin" <?= $user_rows['role'] === "admin" ? "selected" : "" ?>>Admin</option>
                                        <option value="guest" <?= $user_rows['role'] === "guest" ? "selected" : "" ?>>Guest</option>
                                    <?php elseif ($permission['role'] === "admin") : ?>
                                        <option value="admin" <?= $user_rows['role'] === "admin" ? "selected" : "" ?>>Admin</option>
                                        <option value="guest" <?= $user_rows['role'] === "guest" ? "selected" : "" ?>>Guest</option>
                                    <?php else : ?>
                                        <option value="guest"><?= $user_rows['role'] ?></option>
                                    <?php endif ?>
                                </select>
                            </div>

                            <div class="input-group input-group-static mb-4">
                                <label>Password</label>
                                <input type="password" name="password" value="<?= $user_rows['password'] ?>" class="form-control" <?= (int)$user_rows['id_user'] !== (int)$_COOKIE['remember_me'] ? "readonly" : "" ?>>
                            </div>


                            <div class="container">
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-info w-100 my-4 mb-2">Simpan</button>
                                        </div>
                                    </div>
                                    <?php if ($permission['role'] === "super admin") : ?>
                                        <div class="col-sm">
                                            <div class="text-center">
                                                <button type="button" class="btn btn-danger w-100 my-4 mb-2" data-bs-toggle="modal" data-bs-target="#modal-notification">Hapus</button>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <!-- tampilan modal notifikasi untuk confirmati hapus data -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                            <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title font-weight-normal" id="modal-title-notification">Your attention is required</h6>
                                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="py-3 text-center">
                                            <h4 class="text-gradient text-danger mt-4">Peringatan!</h4>
                                            <?php if ($_COOKIE['remember_me'] === $_GET['id']) : ?>
                                                <p>
                                                    Anda tidak dapat menghapus akun anda sendiri lakukan permintaan terhadap petugas dengan roles Super Admin untuk menghapus akun anda
                                                    atau gunakan akun dengan role Super Admin lain untuk menghapus akun anda!
                                                </p>
                                            <?php else : ?>
                                                <p>Jika anda menghapus data ini maka data akan hilang secata permanen. Apakah anda yakin menghapus data ini?</p>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <?php if ($_COOKIE['remember_me'] !== $_GET['id']) : ?>
                                            <a href="./app/init.php?proses=hapus-user&id=<?= $_GET['id'] ?>" class="btn btn-white">Iya, Hapus</a>
                                        <?php endif ?>
                                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    } else {
        echo "Tidak ada user ditemukan";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>