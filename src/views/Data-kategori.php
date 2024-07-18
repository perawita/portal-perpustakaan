<div class="card">
    <div class="table-responsive">
        <table id="table" class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deskripsi</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Upload</th>
                    <th class="text-secondary opacity-7"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $categories = new \App\Models\Categories();
                    $category_rows = $categories->read();

                    if (!empty($category_rows)) {
                        foreach ($category_rows as $row) {
                ?>
                            <tr>
                                <td>
                                    <p class="text-xs text-secondary mb-0"><?= $row['name'] ?></p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-secondary text-xs font-weight-normal"><?= (strlen($row['description']) > 1 ? substr($row['description'], 0, 10) . '...' : '----------') ?></span>
                                </td>

                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-normal"><?= $row['created_at'] ?></span>
                                </td>
                                <td class="align-middle">
                                    <a href="?views=From-data-kategori&id_category=<?= $row['id'] ?>" class="text-secondary font-weight-normal text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                <?php
                        }
                    } else {
                        echo " <td> <span>Tidak ada kategori ditemukan</span> </td>";
                    }
                } catch (\Exception $e) {
                    echo "<td><span>Error: " . $e->getMessage() . "</span> </td>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>