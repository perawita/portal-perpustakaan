<?php
$category = isset($_GET['id_category']) ? (new \App\Models\Categories)->read($_GET['id_category']) : null;
?>
<div class="card">
    <div class="table-responsive">
        <div class="p-4">
            <form action="./app/init.php?proses=<?= isset($_GET['id_category']) ? 'edit-kategori&id=' . $_GET['id_category'] : 'tambah-kategori' ?>" method="POST">
                <div class="input-group input-group-outline mb-4">
                    <label class="form-label">Judul Kategori</label>
                    <input type="text" name="nama" class="form-control" value="<?= $category['name'] ?? '' ?>" required>
                </div>

                <div class="input-group input-group-dynamic mb-4">
                    <textarea class="form-control" rows="5" name="deskripsi" placeholder="Masukkan deskripsi singkat tentang kategori ini." spellcheck="false"><?= $category['description'] ?? '' ?></textarea>
                </div>


                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-info w-100 my-4 mb-2">Simpan</button>
                            </div>
                        </div>
                        <?php if (isset($_GET['id_category'])) : ?>
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
                            <a href="./app/init.php?proses=hapus-category&id=<?= $_GET['id_category'] ?>" class="btn btn-white">Iya, Hapus</a>
                            <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>