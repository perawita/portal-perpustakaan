<?php $permission = isset($_COOKIE['remember_me']) ? (new \App\Https\Controllers\LoginController)->remember($_COOKIE['remember_me']) : null; ?>
<div class="card">
    <div class="table-responsive">
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Data Buku</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">User</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Pinjam</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Pengembalian</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Dikembalikan</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah</th>
                    <?php if ($permission['role'] === "guest") : ?>
                        <th class="text-secondary opacity-7"></th>
                    <?php endif ?>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $loans = new \App\Models\Loans();
                    $loan_rows = [];
                    if ($permission['role'] === "guest") {
                        $loan_rows = $loans->read(null, (int)$permission['id_user']);
                    } else {
                        $loan_rows = $loans->read();
                    }

                    if (!empty($loan_rows)) {
                        foreach ($loan_rows as $row) {
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
                                    <p class="text-xs font-weight-bold mb-0"><?= $row['full_name'] ?></p>
                                    <p class="text-xs text-secondary mb-0"><?= $row['contact'] ?></p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-secondary text-xs font-weight-normal"><?= $row['loan_date'] ?></span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-normal">
                                        <?php
                                        switch ($row['returned']) {
                                            case '0':
                                                echo 'Belum di kembalikan';
                                                break;
                                            case '2':
                                                echo 'Pengembalian belum semua';
                                                break;
                                            case '3':
                                                echo 'Lunas';
                                                break;
                                        }
                                        ?></span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-normal"><?= $row['return_date'] ?></span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-normal"><?= $row['returned'] !== '3' ? $row['jumlah_pinjam'] : "0" ?></span>
                                </td>
                                <?php if ($permission['role'] === "guest") :
                                ?>
                                    <td class="align-middle">
                                        <button type="button" onclick="from_stor_buku(<?= $row['history_id'] ?>, <?= $row['book_id'] ?>, <?= $row['user_id'] ?>)" class="btn bg-gradient-success btn-block mb-3" data-bs-toggle="modal" data-bs-target="#exampleModalMessage" <?= $row['returned'] !== 3 ? "> Setor" : "disabled>Lunas" ?></button>
                                    </td>
                                <?php endif
                                ?>
                            </tr>
                <?php
                        }
                    } else {
                        echo " <td> <span>Tidak ada histori ditemukan</span> </td>";
                    }
                } catch (\Exception $e) {
                    echo "<td><span>Error: " . $e->getMessage() . "</span> </td>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="row">
        <div class="col-md-4">
            <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title font-weight-normal" id="exampleModalLabel">Formulir Peminjaman</h6>
                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="./app/init.php?proses=stor-buku" method="POST">
                                <div class="input-group input-group-static mb-4">
                                    <label>Nama User</label>
                                    <input type="text" id="nama_user" class="form-control" readonly>
                                    <input type="hidden" name="id_user" id="id_user" class="form-control">
                                </div>
                                <div class="input-group input-group-static mb-4">
                                    <label>ISBN</label>
                                    <input type="text" id="isbn" class="form-control" readonly>
                                </div>
                                <div class="input-group input-group-static mb-4">
                                    <label>Nama Buku</label>
                                    <input type="text" id="nama_buku" class="form-control" readonly>
                                    <input type="hidden" name="id_buku" id="id_buku" class="form-control">
                                </div>
                                <div class="input-group input-group-static my-3">
                                    <label>Tanggal Pinjam</label>
                                    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control" readonly>
                                </div>
                                <div class="input-group input-group-static my-3">
                                    <label>Tanggal Pengembalian</label>
                                    <input type="date" name="tanggal_pengembalian" id="tanggal_pengembalian" class="form-control" readonly>
                                </div>
                                <div class="input-group input-group-static mb-4">
                                    <label>Jumlah</label>
                                    <input type="number" id="jumlah_buku" name="jumlah_buku" min="0" class="form-control" required>
                                    <input type="hidden" id="sisa" name="sisa" class="form-control" required>
                                    <input type="hidden" id="id_history" name="id_history" class="form-control" required>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn bg-gradient-primary">Setor</button>
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    function from_stor_buku(id_history, id_buku, id_user) {
        fetch('./app/init.php?proses=from-stor-buku', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id_history: id_history,
                    id_book: id_buku,
                    id_user: id_user
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('nama_user').value = data['history']['full_name'];
                document.getElementById('id_user').value = data['history']['id_user'];
                document.getElementById('isbn').value = data['history']['isbn'];
                document.getElementById('nama_buku').value = data['history']['title'];
                document.getElementById('id_buku').value = data['history']['book_id'];
                document.getElementById('tanggal_pinjam').value = data['history']['loan_date'];
                document.getElementById('tanggal_pengembalian').value = data['history']['return_date'];
                document.getElementById('jumlah_buku').setAttribute('max', data['history']['total_buku_di_pinjam']);
                document.getElementById('sisa').value = data['history']['total_buku_di_pinjam'];
                document.getElementById('id_history').value = data['history']['history_id'];

            })
            .catch(error => {
                alert('Error:', error);
            });

    }
</script>