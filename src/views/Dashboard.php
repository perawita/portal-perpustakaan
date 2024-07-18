<?php $permission = isset($_COOKIE['remember_me']) ? (new \App\Https\Controllers\LoginController)->remember((int)$_COOKIE['remember_me']) : null; ?>
<div class="row">
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">book</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Jumlah Buku</p>
                    <?php
                    try {
                        $books = new \App\Models\Books();
                        $book_rows = $books->read();
                        $total_buku = 0;

                        if (!empty($book_rows)) {
                            foreach ($book_rows as $row) {
                                $total_buku += (int)$row['quantity'];
                            }

                    ?>
                            <h4 class="mb-0"><?= $total_buku ?></h4>
                    <?php
                        } else {
                            echo "<h4 class='mb-0'>0</h4>";
                        }
                    } catch (\Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    ?>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                <!-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+5% </span>than yesterday</p> -->
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">assignment</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Sedang Dipinjam</p>
                    <?php
                    try {
                        $books = new \App\Models\Loans();
                        $book_rows;
                        if ($permission['role'] !== 'guest') {
                            $book_rows = $books->read();
                        } else {
                            $book_rows = $books->read(null, (int)$_COOKIE['remember_me']);
                        }
                        $total_buku_di_pinjam = 0;

                        if (!empty($book_rows)) {
                            foreach ($book_rows as $book) {
                                if ($book['returned'] !== "3") {
                                    $total_buku_di_pinjam += (int)$book['jumlah_pinjam'];
                                }
                            }
                    ?>
                            <h4 class="mb-0"><?= $total_buku_di_pinjam ?></h4>
                    <?php
                        } else {
                            echo "<h4 class='mb-0'>0</h4>";
                        }
                    } catch (\Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    ?>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                <!-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+3% </span>than last month</p> -->
            </div>
        </div>
    </div>
    <?php if ($permission['role'] !== 'guest') : ?>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">weekend</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Katagori Untuk Buku</p>
                        <?php
                        try {
                            $books = new \App\Models\Categories();
                            $book_rows = $books->read();
                            $count = 0;

                            if (!empty($book_rows)) {
                                foreach ($book_rows as $row) {
                                    $count++;
                                }
                        ?>
                                <h4 class="mb-0"><?= $count ?></h4>
                        <?php
                            } else {
                                echo "<h4 class='mb-0'>0</h4>";
                            }
                        } catch (\Exception $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        ?>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <!-- <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">-2%</span> than yesterday</p> -->
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Total Pengguna</p>
                        <?php
                        try {
                            $users = new \App\Models\Users();
                            $user_rows = $users->read();
                            $count = 0;

                            if (!empty($user_rows)) {
                                foreach ($user_rows as $row) {
                                    if ($row['role'] === 'guest') {
                                        $count++;
                                    }
                                }
                        ?>
                                <h4 class="mb-0"><?= $count ?></h4>
                        <?php


                            } else {
                                echo "<h4 class='mb-0'>0</h4>";
                            }
                        } catch (\Exception $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        ?>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <!-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55% </span>than last week</p> -->
                </div>
            </div>
        </div>
</div>
<br>
<div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">person</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Total Petugas</p>
                    <?php
                    try {
                        $users = new \App\Models\Users();
                        $user_rows = $users->read();
                        $count = 0;

                        if (!empty($user_rows)) {
                            foreach ($user_rows as $row) {
                                if ($row['role'] !== 'guest') {
                                    $count++;
                                }
                            }
                    ?>
                            <h4 class="mb-0"><?= $count ?></h4>
                    <?php

                        } else {
                            echo "<h4 class='mb-0'>0</h4>";
                        }
                    } catch (\Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    ?>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                <!-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55% </span>than last week</p> -->
            </div>
        </div>
    </div>
<?php endif ?>
</div>

<br>


<div class="row mb-4">
    <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-lg-6 col-7">
                        <h6>Buku paling banyak di pinjam</h6>
                        <p class="text-sm mb-0">
                        </p>
                    </div>
                    <div class="col-lg-6 col-5 my-auto text-end">
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Informasi Buku</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ISBN</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tahun Terbit</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah Dipinjam Daritotal Buku</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $loans = new \App\Models\Loans();
                                $loan_rows = $loans->books_populers();

                                if (!empty($loan_rows)) {
                                    foreach ($loan_rows as $row) {
                                        if ($row['jumlah_buku'] > 0) {
                                            $persentase_peminjaman = ($row['jumlah_pinjam'] / ((int)$row['jumlah_pinjam'] + (int)$row['jumlah_buku'])) * 100;
                                        } else {
                                            $persentase_peminjaman = 100;
                                        }

                            ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="./app/Storage/app/public/image/<?= $row['cover_image'] ?>" class="avatar avatar-sm me-3">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-xs"><?= $row['title'] ?></h6>
                                                        <p class="text-xs text-secondary mb-0"><?= $row['author'] ?></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-xs font-weight-bold"><?= $row['isbn'] ?></span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold"><?= $row['publication_year'] ?></span>
                                            </td>
                                            <td class="align-middle">
                                                <div class="progress-wrapper w-75 mx-auto">
                                                    <div class="progress-info">
                                                        <div class="progress-percentage">
                                                            <span class="text-xs font-weight-bold"><?= number_format($persentase_peminjaman) ?>%</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-gradient-info" style="width: <?= number_format($persentase_peminjaman) ?>%;" role="progressbar" aria-valuenow="<?= number_format($persentase_peminjaman) ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                            <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='5'><span>Tidak ada buku yang di pinjam</span></td></tr>";
                                }
                            } catch (\Exception $e) {
                                echo "<tr><td colspan='4'><span>Error: " . htmlspecialchars($e->getMessage()) . "</span></td></tr>";
                            }
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card h-100">
            <div class="card-header pb-0">
                <h6>Aktivitas <?= date('l, j F Y') ?></h6>
            </div>
            <div class="card-body p-3">
                <div class="timeline timeline-one-side">
                    <?php
                    try {
                        $notif = new \App\Models\Loans();
                        $notif_rows;
                        if ($permission['role'] !== 'guest') {
                            $notif_rows = $notif->read(null, null);
                        } else {
                            $notif_rows = $notif->read(null, (int)$_COOKIE['remember_me']);
                        }

                        if (!empty($notif_rows)) :
                            foreach ($notif_rows as $row) :
                                $today = date('Y-m-d');
                                $rowDate = date('Y-m-d', strtotime($row['tanggal_pinjam']));

                                if ($rowDate === $today) :

                    ?>
                                    <div class="timeline-block mb-3">
                                        <span class="timeline-step">
                                            <i class="material-icons text-success text-gradient">notifications</i>
                                        </span>
                                        <div class="timeline-content">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0">
                                                <?php
                                                switch ($row['returned']) {
                                                    case '0':
                                                        echo $row['full_name'] . ' Meminjam buku ' . $row['title'];
                                                        break;

                                                    case '2':
                                                        echo $row['full_name'] . ' Mengembalikan beberapa (belum lunas) buku ' . $row['title'];
                                                        break;

                                                    case '3':
                                                        echo $row['full_name'] . ' Melunasi buku ' . $row['title'];
                                                        break;
                                                }
                                                ?>
                                            </h6>
                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0"><?= date('d M Y, H:i', strtotime($row['created_at'])) ?></p>
                                        </div>
                                    </div>
                    <?php
                                endif;
                            endforeach;
                        else :
                            echo "<span>Tidak ada notifikasi hari ini</span>";
                        endif;
                    } catch (\Exception $e) {
                        echo "<span>Error: " . htmlspecialchars($e->getMessage()) . "</span>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>