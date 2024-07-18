<div class="card">
    <div class="table-responsive">
        <table id="table" class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Information</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Categori</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tahun Publis</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ISBN</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Upload</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah</th>
                    <th class="text-secondary opacity-7"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $books = new \App\Models\Books();
                    $book_rows = $books->read();

                    if (!empty($book_rows)) {
                        foreach ($book_rows as $row) {
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
                                    <p class="text-xs text-secondary mb-0"><?= $row['category_name'] ?></p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-secondary text-xs font-weight-normal"><?= $row['publication_year'] ?></span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-normal"><?= $row['isbn'] ?></span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-normal"><?= $row['created_at'] ?></span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-normal"><?= $row['quantity'] ?></span>
                                </td>
                                <td class="align-middle">
                                    <button type="button" onclick="from_pinjam_buku(<?= $row['id'] ?>)" class="btn bg-gradient-success btn-block mb-3" data-bs-toggle="modal" data-bs-target="#exampleModalMessage">Pinjam</button>
                                </td>
                            </tr>
                <?php
                        }
                    } else {
                        echo " <td> <span>Tidak ada buku ditemukan</span> </td>";
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
                            <form action="./app/init.php?proses=pinjam" method="POST">
                                <div class="input-group input-group-static mb-4">
                                    <label>Nama User</label>
                                    <input type="text" id="nama_user" class="form-control" readonly>
                                    <input type="hidden" name="id_user" id="id_user" value="<?= $_COOKIE['remember_me'] ?>" class="form-control">
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
                                    <input type="date" name="tanggal_pinjam" value="<?= htmlspecialchars(date('Y-m-d')) ?>" class="form-control" readonly>
                                    <input type="hidden" value="<?= htmlspecialchars(date('Y-m-d')) ?>" class="form-control">
                                </div>
                                <div class="input-group input-group-static my-3">
                                    <label>Tanggal Pengembalian</label>
                                    <input type="date" name="tanggal_pengembalian" class="form-control" required>
                                </div>
                                <div class="input-group input-group-static mb-4">
                                    <label>Jumlah</label>
                                    <input type="number" id="jumlah_buku" name="jumlah_buku" min="0" class="form-control" required>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn bg-gradient-primary">Pinjam</button>
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
    function from_pinjam_buku(id_buku) {
        fetch('./app/init.php?proses=from-pinjam', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id_book: id_buku,
                    id_user: parseInt("<?= $_COOKIE['remember_me'] ?>")
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('nama_user').value = data['user'];
                document.getElementById('isbn').value = data['book']['isbn'];
                document.getElementById('nama_buku').value = data['book']['title'];
                document.getElementById('id_buku').value = data['book']['id'];
                document.getElementById('jumlah_buku').setAttribute('max', data['book']['quantity']);
            })
            .catch(error => {
                alert('Error:', error);
            });

    }
</script>