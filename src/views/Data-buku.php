<div class="card">
    <div class="table-responsive">
        <table id="table" class="table table-striped align-items-center mb-0" style="width:100%">
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
                                    <a href="?views=From-data-buku&id_books=<?= $row['id'] ?>" class="text-secondary font-weight-normal text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                        Edit
                                    </a>
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
</div>