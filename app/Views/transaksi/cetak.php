<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Bukti Peminjaman - <?= $t['nim'] ?></title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-color: #f3f4f6;
            --paper-bg: #ffffff;
            --primary-color: #1e3a8a;
            --text-color: #1f2937;
            --border-color: #e5e7eb;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Toolbar Actions */
        .toolbar {
            width: 100%;
            max-width: 800px;
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-back {
            background-color: #ffffff;
            color: #4b5563;
            border: 1px solid var(--border-color);
        }

        .btn-back:hover {
            background-color: #f9fafb;
        }

        .btn-print {
            background-color: var(--primary-color);
            color: #ffffff;
        }

        .btn-print:hover {
            background-color: #1d4ed8;
        }

        .btn i {
            margin-right: 8px;
        }

        /* Printable Paper Layout */
        .paper {
            width: 100%;
            max-width: 800px;
            background-color: var(--paper-bg);
            padding: 50px;
            box-sizing: border-box;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        /* Header (Kop Surat) */
        .kop-surat {
            display: flex;
            align-items: center;
            border-bottom: 3px double #1f2937;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .kop-logo {
            font-size: 40px;
            color: var(--primary-color);
            margin-right: 20px;
        }

        .kop-details {
            flex-grow: 1;
            text-align: center;
        }

        .kop-details h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--primary-color);
        }

        .kop-details p {
            margin: 4px 0 0 0;
            font-size: 12px;
            color: #4b5563;
        }

        /* Title */
        .document-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .document-title h3 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-decoration: underline;
        }

        .document-title p {
            margin: 5px 0 0 0;
            font-size: 13px;
            color: #4b5563;
        }

        /* Meta details */
        .detail-row {
            display: flex;
            margin-bottom: 12px;
            font-size: 14px;
            line-height: 1.6;
        }

        .detail-label {
            width: 180px;
            font-weight: 600;
            color: #4b5563;
        }

        .detail-value {
            flex-grow: 1;
        }

        /* Section divider */
        .divider {
            height: 1px;
            background-color: var(--border-color);
            margin: 25px 0;
        }

        /* Table */
        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }

        .item-table th, .item-table td {
            border: 1px solid #9ca3af;
            padding: 10px 12px;
            text-align: left;
        }

        .item-table th {
            background-color: #f3f4f6;
            font-weight: 600;
        }

        .text-center {
            text-align: center !important;
        }

        /* Signatures */
        .signature-section {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }

        .signature-box {
            text-align: center;
            width: 250px;
        }

        .signature-box .date {
            margin-bottom: 45px;
        }

        .signature-box .name {
            font-weight: 700;
            text-decoration: underline;
        }

        .signature-box .role {
            font-size: 12px;
            color: #4b5563;
            margin-top: 2px;
        }

        /* Print Media styling */
        @media print {
            body {
                background-color: #ffffff;
                padding: 0;
            }

            .toolbar {
                display: none;
            }

            .paper {
                box-shadow: none;
                padding: 0;
                max-width: 100%;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Action Toolbar (Hidden when printing) -->
    <div class="toolbar">
        <a href="<?= base_url('riwayat') ?>" class="btn btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Riwayat
        </a>
        <button onclick="window.print()" class="btn btn-print">
            <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
        </button>
    </div>

    <!-- The Paper Document Sheet -->
    <div class="paper">
        <!-- Kop Surat -->
        <div class="kop-surat">
            <div class="kop-logo">
                <i class="fa-solid fa-flask-vial"></i>
            </div>
            <div class="kop-details">
                <h2>Laboratorium Terpadu Teknik & Komputer</h2>
                <p>Jl. Raya Kampus Utama, Gedung B Lantai 2 | Telp: (021) 12345678</p>
                <p>Email: lab-teknik@domain.ac.id | Website: lab.domain.ac.id</p>
            </div>
        </div>

        <!-- Document Title -->
        <div class="document-title">
            <h3>Surat Bukti Peminjaman Alat</h3>
            <p>Nomor: BP/<?= date('Y/m', strtotime($t['tanggal_peminjaman'])) ?>/<?= str_pad($t['id'], 4, '0', STR_PAD_LEFT) ?></p>
        </div>

        <!-- Borrower Info -->
        <div class="detail-row">
            <div class="detail-label">Nama Peminjam</div>
            <div class="detail-value">: <strong><?= esc($t['peminjam']) ?></strong></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">NIM</div>
            <div class="detail-value">: <?= esc($t['nim']) ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Tanggal Peminjaman</div>
            <div class="detail-value">: <?= date('d F Y - H:i', strtotime($t['tanggal_peminjaman'])) ?> WIB</div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Tanggal Pengembalian</div>
            <div class="detail-value">: <?= $t['tanggal_pengembalian'] ? date('d F Y - H:i', strtotime($t['tanggal_pengembalian'])) . ' WIB' : 'Belum Dikembalikan' ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Keperluan</div>
            <div class="detail-value">: <?= esc($t['keperluan']) ?></div>
        </div>

        <div class="divider"></div>

        <!-- Table of items -->
        <h4 style="margin: 0 0 10px 0; font-size: 15px; text-transform: uppercase;">Daftar Alat Laboratorium</h4>
        <table class="item-table">
            <thead>
                <tr>
                    <th style="width: 50px;" class="text-center">No</th>
                    <th>Nama Alat/Barang</th>
                    <th>Kategori</th>
                    <th>Kondisi Barang</th>
                    <th style="width: 80px;" class="text-center">Jumlah (Qty)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td><strong><?= esc($t['barang']) ?></strong></td>
                    <td><?= esc($t['kategori'] ?? '-') ?></td>
                    <td><?= esc($t['kondisi'] ?? '-') ?></td>
                    <td class="text-center"><?= esc($t['jumlah']) ?> pcs</td>
                </tr>
            </tbody>
        </table>

        <!-- Document Notes / Terms -->
        <div style="margin-top: 30px; font-size: 12px; color: #4b5563; line-height: 1.5;">
            <p><strong>Ketentuan:</strong></p>
            <ol style="padding-left: 20px; margin: 5px 0;">
                <li>Peminjam bertanggung jawab penuh atas keutuhan dan kelayakan kondisi alat selama masa peminjaman.</li>
                <li>Jika terjadi kerusakan atau kehilangan, peminjam wajib mengganti alat sejenis dengan spesifikasi yang sama.</li>
                <li>Harap kembalikan alat tepat waktu sesuai dengan tanggal pengembalian yang disepakati.</li>
            </ol>
        </div>

        <!-- Signatures -->
        <div class="signature-section">
            <div class="signature-box">
                <p>Peminjam,</p>
                <div style="height: 60px;"></div>
                <p class="name"><?= esc($t['peminjam']) ?></p>
                <p class="role">NIM. <?= esc($t['nim']) ?></p>
            </div>
            <div class="signature-box">
                <p class="date">Jakarta, <?= date('d F Y', strtotime($t['tanggal_peminjaman'])) ?></p>
                <p>Petugas Laboratorium,</p>
                <div style="height: 60px;"></div>
                <p class="name">Staff Lab Terpadu</p>
                <p class="role">NIDN. Staff-1092837</p>
            </div>
        </div>
    </div>

</body>
</html>
