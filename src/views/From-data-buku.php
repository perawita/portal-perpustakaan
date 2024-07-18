<?php
$books = isset($_GET['id_books']) ? (new \App\Models\Books)->read($_GET['id_books']) : null;
?>
<div class="card">
    <div class="table-responsive">
        <div class="p-4">
            <form action="./app/init.php?proses=<?= isset($_GET['id_books']) ? 'edit-buku&id=' . $_GET['id_books'] : 'tambah-buku' ?>" method="POST" enctype="multipart/form-data">
                <div class="input-group input-group-outline mb-4">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" name="judul" class="form-control" value="<?= $books['title'] ?? '' ?>" required>
                </div>

                <div class="input-group input-group-outline mb-4">
                    <label class="form-label">Nama Penulis</label>
                    <input type="text" name="nama_penulis" class="form-control" value="<?= $books['author'] ?? '' ?>" required>
                </div>

                <div class="input-group input-group-outline mb-4">
                    <label class="form-label">ISBN</label>
                    <input type="text" name="isbn" class="form-control" value="<?= $books['isbn'] ?? '' ?>" required>
                </div>

                <div class="input-group input-group-outline my-3">
                    <label class="form-label">Jumlah Buku</label>
                    <input type="number" name="jumlah" class="form-control" value="<?= $books['quantity'] ?? '' ?>" required>
                </div>

                <div class="input-group input-group-static my-3">
                    <label>Tahun Terbit Buku</label>
                    <input type="month" id="yearInput" class="form-control" value="<?= $books['publication_year'] ? $books['publication_year'] . '-01' : '' ?>" required>
                    <input type="hidden" id="year" name="tahun_terbit" class="form-control" value="<?= $books['publication_year'] ?? '' ?>" required>
                </div>

                <div class="input-group input-group-static mb-4">
                    <label for="exampleFormControlSelect1" class="ms-0">Kategori Buku</label>
                    <select class="form-control" name="kategori" id="exampleFormControlSelect1" required>
                        <?php
                        try {
                            $categories = new \App\Models\Categories();
                            $category_rows = $categories->read();

                            if (!empty($category_rows)) {
                                foreach ($category_rows as $row) {
                                    $selected = $books && $books['category_id'] == $row['id'] ? 'selected' : '';
                                    echo "<option value='{$row['id']}' {$selected}>{$row['name']}</option>";
                                }
                            } else {
                                echo "<option value=''>Tidak ada kategori ditemukan</option>";
                            }
                        } catch (\Exception $e) {
                            echo "<option value=''>Error: " . $e->getMessage() . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="input-group input-group-static my-3">
                    <label for="cover_book">Foto Buku</label>
                    <input type="file" name="cover_book" id="cover_book" class="form-control">
                    <?php if (!$books) : ?>
                        <small class="text-danger">File foto buku harus diunggah.</small>
                    <?php endif; ?>
                    <?php if ($books && !empty($books['cover_image'])) : ?>
                        <img src="./app/Storage/app/public/image/<?= $books['cover_image'] ?>" alt="Cover Image" height="100">
                        <input type="hidden" name="old_cover_book" id="old_cover_book" value="<?= $books['cover_image'] ?>" class="form-control">
                    <?php endif; ?>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-info w-100 my-4 mb-2">Simpan</button>
                            </div>
                        </div>
                        <?php if (isset($_GET['id_books'])) : ?>
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
                                <p>Jika anda menghapus data ini maka data akan hilang secata permanen. Apakah anda yakin menghapus data ini?</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="./app/init.php?proses=hapus-buku&id=<?= $_GET['id_books'] ?>" class="btn btn-white">Iya, Hapus</a>
                            <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    const yearInput = document.getElementById('yearInput');
    const hiddenYearInput = document.getElementById('year');

    yearInput.addEventListener('change', function() {
        const selectedYear = this.value;
        const year = selectedYear.split('-')[0];
        hiddenYearInput.value = year;
    });
</script>