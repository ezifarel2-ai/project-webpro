<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm border-0 rounded-4 p-4 text-dark">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold m-0">
            <i class="fas fa-history me-2 text-info"></i>Riwayat Transaksi Lab
        </h4>
        <div>
            <a href="<?= base_url('peminjaman') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold me-2">
                <i class="fas fa-plus me-1"></i> Tambah Pinjam
            </a>
            <a href="<?= base_url('transaksi/export') ?>" class="btn btn-info text-white rounded-pill px-4 shadow-sm fw-bold">
                <i class="fas fa-file-export me-1"></i> Export Data
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th class="py-3">No</th>
                    <th class="py-3">NIM</th> 
                    <th class="py-3">Nama Peminjam</th>
                    <th class="py-3">Alat Lab</th>
                    <th class="py-3 text-center">Qty</th> 
                    <th class="py-3">Tgl Pinjam</th>
                    <th class="py-3">Tgl Kembali</th> 
                    <th class="py-3 text-center">Status</th>
                    <th class="py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach($semua_riwayat as $r): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td class="text-muted"><?= $r['nim'] ?></td> 
                    <td class="fw-bold"><?= $r['peminjam'] ?></td>
                    <td><?= $r['barang'] ?></td>
                    <td class="text-center">
                        <span class="badge bg-light text-dark border"><?= $r['jumlah'] ?></span>
                    </td> 
                    <td><?= date('d/m/Y', strtotime($r['tanggal_peminjaman'])) ?></td>
                    <td class="<?= ($r['status'] == 'Dipinjam') ? 'text-danger' : 'text-success' ?> fw-bold">
                        <?= $r['tanggal_pengembalian'] ? date('d/m/Y', strtotime($r['tanggal_pengembalian'])) : '-' ?>
                    </td>
                    <td class="text-center">
                        <?php if($r['status'] == 'Dipinjam'): ?>
                            <span class="badge bg-info text-white rounded-pill px-3 shadow-sm">
                                <i class="fas fa-clock me-1"></i> Dipinjam
                            </span>
                        <?php else: ?>
                            <span class="badge bg-success text-white rounded-pill px-3 shadow-sm">
                                <i class="fas fa-check-circle me-1"></i> Dikembalikan
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <?php if($r['status'] == 'Dipinjam'): ?>
                            <?php if(session()->get('role') == 'admin'): ?>
                                <a href="<?= base_url('transaksi/kembalikan/' . $r['id']) ?>" 
                                   class="btn btn-sm btn-success rounded-pill px-4 shadow-sm fw-bold"
                                   onclick="return confirm('Konfirmasi: Apakah alat laboratorium ini sudah diterima kembali dalam kondisi baik?')">
                                    <i class="fas fa-undo-alt me-1"></i> Kembalikan
                                </a>
                            <?php else: ?>
                                <span class="text-muted small italic">Belum Kembali <i class="fas fa-clock text-warning"></i></span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="text-muted small italic">Selesai <i class="fas fa-check text-success"></i></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                
                <?php if(empty($semua_riwayat)): ?>
                <tr>
                    <td colspan="9" class="text-center text-muted py-5">
                        <i class="fas fa-folder-open d-block mb-2 fa-2x"></i>
                        Belum ada riwayat transaksi yang tercatat.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>