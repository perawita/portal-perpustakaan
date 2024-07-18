<?php $permission = isset($_COOKIE['remember_me']) ? (new \App\Https\Controllers\LoginController)->remember($_COOKIE['remember_me']) : null; ?>
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-center ps-3">Akun anda</h6>
                </div>
            </div>
            <div class="card card-body px-0 pb-2">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Information</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Full Name</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Password</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Roles</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $users = new \App\Models\Users();
                                $user_rows = $users->read($_COOKIE['remember_me']);

                                if (!empty($user_rows)) {
                            ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-xs"><?= $user_rows['username'] ?></h6>
                                                    <p class="text-xs text-secondary mb-0"><?= $user_rows['contact'] ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0"><?= $user_rows['full_name'] ?></p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-normal"><?= md5($user_rows['password']); ?></span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-normal"><?= $user_rows['role'] ?></span>
                                        </td>
                                        <td class="align-middle">
                                            <a href="?views=Profile&id=<?= $user_rows['id_user'] ?>" class="text-secondary font-weight-normal text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                                Open
                                            </a>
                                        </td>
                                    </tr>
                            <?php
                                } else {
                                    echo " <td> <span>Tidak ada user ditemukan</span> </td>";
                                }
                            } catch (\Exception $e) {
                                echo "<td><span>Error: " . $e->getMessage() . "</span> </td>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($permission['role'] === "super admin" || $permission['role'] === "admin") : ?>
    <div class="row">
        <div class="col-12">
            <div class="card my-4">

                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-center ps-3">Semua akun pengguna</h6>
                    </div>
                </div>
                <div class="card card-body px-0 pb-2">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Information</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Full Name</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Password</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Roles</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                try {
                                    $users = new \App\Models\Users();
                                    $user_rows = $users->read();

                                    if (!empty($user_rows)) {
                                        foreach ($user_rows as $row) {
                                ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-xs"><?= $row['username'] ?></h6>
                                                            <p class="text-xs text-secondary mb-0"><?= $row['contact'] ?></p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs text-secondary mb-0"><?= $row['full_name'] ?></p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-normal"><?= md5($row['password']); ?></span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-normal"><?= $row['role'] ?></span>
                                                </td>
                                                <td class="align-middle">
                                                    <a href="?views=Profile&id=<?= $row['id_user'] ?>" class="text-secondary font-weight-normal text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                                        Edit
                                                    </a>
                                                </td>
                                            </tr>
                                <?php
                                        }
                                    } else {
                                        echo " <td> <span>Tidak ada user ditemukan</span> </td>";
                                    }
                                } catch (\Exception $e) {
                                    echo "<td><span>Error: " . $e->getMessage() . "</span> </td>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>