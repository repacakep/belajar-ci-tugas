<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<h3>History Transaksi Pembelian <strong><?= $username ?></strong></h3>
<hr>
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ID Pembelian</th>
                <th scope="col">Waktu Pembelian</th>
                <th scope="col">Total Bayar</th>
                <th scope="col">Alamat</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($buy)) : ?>
                <?php foreach ($buy as $index => $item) : ?>
                    <tr>
                        <th scope="row"><?= $index + 1 ?></th>
                        <td><?= $item['id'] ?></td>
                        <td>
                            <?php 
                            $utcTime = $item['created_at']; 
                            $date = new DateTime($utcTime, new DateTimeZone('UTC'));
                            $date->setTimeZone(new DateTimeZone('Asia/Jakarta'));
                            $indonesianTime = $date->format('Y-M-d, D H:i:s');
                            echo $indonesianTime;
                            ?>
                        </td>
                        <td><?= number_to_currency($item['total_harga'], 'IDR') ?></td>
                        <td><?= $item['alamat'] ?></td>
                        <td><?= ($item['status'] == "1") ? "Sudah Selesai" : "Belum Selesai" ?></td>
                        <td>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#detailModal-<?= $item['id'] ?>">
                                Detail
                            </button>
                        </td>
                    </tr>
                    <!-- Detail Modal Begin -->
                    <div class="modal fade" id="detailModal-<?= $item['id'] ?>" tabindex="-1" aria-labelledby="detailModalLabel-<?= $item['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detailModalLabel-<?= $item['id'] ?>">Detail Data #<?= $item['id'] ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php if (isset($product[$item['id']])) : ?>
                                        <?php foreach ($product[$item['id']] as $index2 => $item2) : ?>
                                            <div class="mb-3">
                                                <p><strong><?= ($index2 + 1) ?>. <?= $item2['nama'] ?></strong></p>
                                                <?php if (!empty($item2['foto']) && file_exists("img/" . $item2['foto'])) : ?>
                                                    <img src="<?= base_url("img/" . $item2['foto']) ?>" width="100px" alt="<?= $item2['nama'] ?>">
                                                <?php endif; ?>
                                                <p><?= number_to_currency($item2['harga'], 'IDR') ?></p>
                                                <?= "(" . $item2['jumlah'] . " pcs)" ?><br>
                                                <?= number_to_currency($item2['subtotal_harga'], 'IDR') ?>
                                            </div>
                                        <?php endforeach; ?>
                                        <div class="mb-3">
                                            <p>Ongkir <?= number_to_currency($item['ongkir'], 'IDR') ?></p>
                                        </div>
                                    <?php else : ?>
                                        <p>No data available for this item.</p>
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Detail Modal End -->
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
