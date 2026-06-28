<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Peminjaman Alat</title>
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
            max-width: 900px;
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
            max-width: 900px;
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
            margin-bottom: 30px;
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

        /* Table */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }

        .report-table th, .report-table td {
            border: 1px solid #9ca3af;
            padding: 8px 10px;
            text-align: left;
        }

        .report-table th {
            background-color: #f3f4f6;
            font-weight: 600;
        }

        .text-center {
            text-align: center !important;
        }

        .status-dipinjam {
            color: #2563eb;
            font-weight: 600;
        }

        .status-kembali {
            color: #16a34a;
            font-weight: 600;
        }

        /* Signatures */
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: flex-end;
            font-size: 14px;
        }

        .signature-box {
            text-align: center;
            width: 280px;
        }

        .signature-box .date {
            margin-bottom: 50px;
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
            <h3>Laporan Transaksi Peminjaman Alat</h3>
            <p>Dicetak pada: <?= date('d F Y - H:i') ?> WIB</p>
        </div>

        <!-- Report Table -->
        <table class="report-table">
            <thead>
                <tr>
                    <th style="width: 40px;" class="text-center">No</th>
                    <th style="width: 100px;">NIM</th>
                    <th>Nama Peminjam</th>
                    <th>Alat Laboratorium</th>
                    <th style="width: 50px;" class="text-center">Qty</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th style="width: 100px;" class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach($semua_riwayat as $r): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= esc($r['nim']) ?></td>
                    <td><strong><?= esc($r['peminjam']) ?></strong></td>
                    <td><?= esc($r['barang']) ?></td>
                    <td class="text-center"><?= esc($r['jumlah']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($r['tanggal_peminjaman'])) ?></td>
                    <td>
                        <?= $r['tanggal_pengembalian'] ? date('d/m/Y H:i', strtotime($r['tanggal_pengembalian'])) : '-' ?>
                    </td>
                    <td class="text-center">
                        <span class="<?= ($r['status'] == 'Dipinjam') ? 'status-dipinjam' : 'status-kembali' ?>">
                            <?= esc($r['status']) ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
                
                <?php if(empty($semua_riwayat)): ?>
                <tr>
                    <td colspan="8" class="text-center py-4" style="color: #6b7280; font-style: italic;">
                        Tidak ada data transaksi peminjaman yang tercatat.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Signatures -->
        <div class="signature-section">
            <div class="signature-box">
                <p class="date">Jakarta, <?= date('d F Y') ?></p>
                <p>Kepala Laboratorium,</p>
                <div style="height: 65px;"></div>
                <p class="name">Dr. Ir. Hermawan, M.T.</p>
                <p class="role">NIP. 197508212003121002</p>
            </div>
        </div>
    </div>

</body>
</html>
