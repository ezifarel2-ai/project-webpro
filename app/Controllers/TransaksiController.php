<?php

namespace App\Controllers;

use App\Models\Transaksi as TransaksiModel;
use App\Models\Inventaris as InventarisModel;

/**
 * ============================================================
 * TransaksiController
 * ------------------------------------------------------------
 * Mengelola seluruh operasi untuk Transaksi Peminjaman Barang.
 * 
 * Struktur Method:
 *   1. INDEX      — Menampilkan riwayat semua transaksi
 *   2. CREATE     — Menampilkan form peminjaman baru
 *   3. STORE      — Menyimpan data peminjaman baru ke database
 *   4. KEMBALIKAN — Memproses pengembalian barang (update status)
 *   5. EXPORT     — Mengekspor data riwayat transaksi ke CSV
 * ============================================================
 */
class TransaksiController extends BaseController
{
    /** @var TransaksiModel */
    protected $transaksiModel;

    /** @var InventarisModel */
    protected $inventarisModel;

    /**
     * Constructor — Inisialisasi model yang digunakan.
     */
    public function __construct()
    {
        $this->transaksiModel  = new TransaksiModel();
        $this->inventarisModel = new InventarisModel();
    }

    // ╔══════════════════════════════════════════════════════════╗
    // ║  1. INDEX — Menampilkan Riwayat Semua Transaksi         ║
    // ╚══════════════════════════════════════════════════════════╝

    /**
     * Menampilkan halaman riwayat transaksi peminjaman.
     * Melakukan JOIN dengan tabel inventaris untuk mendapatkan nama alat.
     *
     * @return string
     */
    public function index()
    {
        $data = [
            'semua_riwayat' => $this->transaksiModel
                ->select('transaksi.*, inventaris.nama_alat as barang, transaksi.nama_peminjam as peminjam')
                ->join('inventaris', 'inventaris.id = transaksi.id_barang')
                ->orderBy('transaksi.id', 'DESC')
                ->findAll(),
        ];

        return view('transaksi/index', $data);
    }

    // ╔══════════════════════════════════════════════════════════╗
    // ║  2. CREATE — Menampilkan Form Peminjaman Baru           ║
    // ╚══════════════════════════════════════════════════════════╝

    /**
     * Menampilkan halaman form untuk membuat transaksi peminjaman baru.
     * Hanya menampilkan barang yang memiliki stok > 0.
     *
     * @return string
     */
    public function tambah()
    {
        $data = [
            'list_barang' => $this->inventarisModel->where('jumlah >', 0)->findAll(),
        ];

        return view('transaksi/tambah', $data);
    }

    // ╔══════════════════════════════════════════════════════════╗
    // ║  3. STORE — Menyimpan Data Peminjaman Baru              ║
    // ╚══════════════════════════════════════════════════════════╝

    /**
     * Memproses penyimpanan data transaksi peminjaman baru.
     * Mengecek ketersediaan stok dan mengurangi stok barang setelah berhasil.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function simpan()
    {
        $id_barang    = $this->request->getPost('id_barang');
        $jumlah_pinjam = $this->request->getPost('jumlah');

        // Validasi ketersediaan barang
        $barang = $this->inventarisModel->find($id_barang);

        if (!$barang) {
            return redirect()->back()->with('error', 'Barang tidak ditemukan!');
        }

        if ($barang['jumlah'] < $jumlah_pinjam) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi!');
        }

        // Siapkan data transaksi
        $data = [
            'id_user'              => session()->get('id_user') ?? 1,
            'id_barang'            => $id_barang,
            'nama_peminjam'        => $this->request->getPost('nama_peminjam'),
            'nim'                  => $this->request->getPost('nim'),
            'keperluan'            => $this->request->getPost('keperluan'),
            'jumlah'               => $jumlah_pinjam,
            'tanggal_peminjaman'   => date('Y-m-d H:i:s'),
            'tanggal_pengembalian' => $this->request->getPost('tanggal_pengembalian'),
            'status'               => 'Dipinjam',
        ];

        // Simpan transaksi dan kurangi stok
        if ($this->transaksiModel->insert($data)) {
            $stok_baru = $barang['jumlah'] - $jumlah_pinjam;
            $this->inventarisModel->update($id_barang, ['jumlah' => $stok_baru]);

            return redirect()->to(base_url('riwayat'))->with('success', 'Berhasil disimpan!');
        }

        return redirect()->to(base_url('peminjaman'));
    }

    // ╔══════════════════════════════════════════════════════════╗
    // ║  4. KEMBALIKAN — Memproses Pengembalian Barang          ║
    // ╚══════════════════════════════════════════════════════════╝

    /**
     * Memproses pengembalian barang yang sedang dipinjam.
     * Mengembalikan stok barang dan mengubah status menjadi 'Kembali'.
     *
     * @param int $id ID transaksi yang akan dikembalikan
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function kembalikan($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to(base_url('riwayat'))->with('error', 'Akses ditolak! Hanya admin yang dapat memproses pengembalian.');
        }

        // Cari data transaksi
        $transaksi = $this->transaksiModel->find($id);

        if (!$transaksi) {
            return redirect()->to(base_url('riwayat'))->with('error', 'Data transaksi tidak ditemukan!');
        }

        // Cek apakah sudah dikembalikan sebelumnya (mencegah double stok)
        if ($transaksi['status'] == 'Kembali') {
            return redirect()->to(base_url('riwayat'))->with('error', 'Barang ini sudah dikembalikan!');
        }

        // Ambil data barang dan hitung stok baru
        $barang     = $this->inventarisModel->find($transaksi['id_barang']);
        $stok_final = $barang['jumlah'] + $transaksi['jumlah'];

        // Update stok di tabel inventaris
        $this->inventarisModel->update($transaksi['id_barang'], ['jumlah' => $stok_final]);

        // Update status transaksi dan set tanggal pengembalian
        $this->transaksiModel->update($id, [
            'status'               => 'Kembali',
            'tanggal_pengembalian' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('riwayat'))->with('success', 'Barang berhasil dikembalikan. Stok telah diperbarui!');
    }

    // ╔══════════════════════════════════════════════════════════╗
    // ║  5. EXPORT — Mengekspor Data Riwayat ke CSV             ║
    // ╚══════════════════════════════════════════════════════════╝

    /**
     * Mengekspor seluruh data riwayat transaksi ke file CSV.
     * File akan langsung di-download oleh browser pengguna.
     *
     * @return void
     */
    public function export()
    {
        // Ambil data riwayat transaksi
        $riwayat = $this->transaksiModel
            ->select('transaksi.*, inventaris.nama_alat as barang, transaksi.nama_peminjam as peminjam')
            ->join('inventaris', 'inventaris.id = transaksi.id_barang')
            ->orderBy('transaksi.id', 'DESC')
            ->findAll();

        $filename = 'riwayat_transaksi_lab_' . date('Ymd_His') . '.csv';

        // Set headers untuk download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');

        // Add BOM agar Excel mendeteksi UTF-8 secara otomatis
        fwrite($output, "\xEF\xBB\xBF");

        // Header kolom CSV
        fputcsv($output, [
            'No',
            'NIM Peminjam',
            'Nama Peminjam',
            'Alat Lab',
            'Jumlah (Qty)',
            'Keperluan',
            'Tanggal Peminjaman',
            'Tanggal Pengembalian',
            'Status',
        ]);

        // Isi data baris per baris
        $no = 1;
        foreach ($riwayat as $row) {
            fputcsv($output, [
                $no++,
                $row['nim'],
                $row['peminjam'],
                $row['barang'],
                $row['jumlah'],
                $row['keperluan'],
                $row['tanggal_peminjaman'],
                $row['tanggal_pengembalian'] ? $row['tanggal_pengembalian'] : '-',
                $row['status'],
            ]);
        }

        fclose($output);
        exit;
    }
}