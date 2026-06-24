<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
    /* Styling tambahan agar serasi dengan Dashboard */
    .glass-card {
        background: rgba(255, 255, 255, 0.8) !important;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.6) !important;
        border-radius: 24px !important;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05) !important;
    }
    .form-control {
        border-radius: 12px;
        padding: 10px 15px;
    }
</style>

<div class="container py-4">
    <div class="card glass-card p-4">
        <h4 class="fw-bold mb-1"><i class="fas fa-exchange-alt me-2 text-primary"></i>Form Transaksi Peminjaman</h4>
        
        <form action="<?= base_url('transaksi/simpan') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Nama Peminjam</label>
                    <input type="text" class="form-control" name="nama_peminjam" placeholder="Masukkan nama lengkap" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">NIM / ID User</label>
                    <input type="text" class="form-control" name="nim" placeholder="Contoh: 15240425" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Pilih Barang yang Dipinjam</label>
                    <select class="form-control" name="id_barang" required>
                        <option value="">-- Pilih Alat Laboratorium --</option>
                        <?php if(!empty($list_barang)): ?>
                            <?php foreach($list_barang as $barang): ?>
                                <option value="<?= $barang['id'] ?>">
                                    <?= $barang['nama_alat'] ?> (Stok: <?= $barang['jumlah'] ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">Tidak ada alat tersedia</option>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Jumlah Pinjam</label>
                    <input type="number" class="form-control" name="jumlah" min="1" value="1" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Tanggal Peminjaman</label>
                    <input type="datetime-local" class="form-control bg-light" name="tanggal_peminjaman" value="<?= date('Y-m-d\TH:i') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="fw-bold text-danger">Estimasi Tanggal Pengembalian</label>
                    <input type="datetime-local" class="form-control" name="tanggal_pengembalian" required>
                    <small class="text-muted">* Tentukan kapan barang harus dikembalikan</small>
                </div>

                <div class="col-12 mb-3">
                    <label class="fw-bold">Keperluan / Alasan Pinjam</label>
                    <textarea class="form-control" name="keperluan" rows="3" placeholder="Contoh: Praktikum Fisika Dasar" required></textarea>
                </div>
            </div>
            
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-success px-5 rounded-pill shadow-sm">
                    <i class="fas fa-save me-2"></i>Proses Peminjaman
                </button>
                <a href="<?= base_url('peminjaman') ?>" class="btn btn-outline-secondary rounded-pill px-4">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>  