<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Seed Kategori
        $kategoriData = [
            [
                'nama_kategori' => 'Alat Elektronik',
                'kode'          => 'ELK',
                'deskripsi'     => 'Peralatan laboratorium berbasis elektronik/listrik',
                'status'        => 'aktif',
                'created_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kategori' => 'Alat Gelas',
                'kode'          => 'GLS',
                'deskripsi'     => 'Peralatan laboratorium dari bahan kaca/gelas',
                'status'        => 'aktif',
                'created_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kategori' => 'Bahan Kimia',
                'kode'          => 'KIM',
                'deskripsi'     => 'Bahan-bahan kimia pendukung praktikum',
                'status'        => 'aktif',
                'created_at'    => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('kategoris')->insertBatch($kategoriData);

        // 2. Seed Lokasi
        $lokasiData = [
            [
                'nama_lokasi' => 'Laboratorium Komputer',
                'keterangan'  => 'Gedung A Lantai 2',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nama_lokasi' => 'Laboratorium Fisika',
                'keterangan'  => 'Gedung B Lantai 1',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nama_lokasi' => 'Laboratorium Kimia',
                'keterangan'  => 'Gedung C Lantai 3',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('lokasi')->insertBatch($lokasiData);

        // 3. Seed Users
        $userData = [
            [
                'nim'        => '12345',
                'username'   => 'admin_lab',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nim'        => '67890',
                'username'   => 'mahasiswa_user',
                'password'   => password_hash('user123', PASSWORD_DEFAULT),
                'role'       => 'customer',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('users')->insertBatch($userData);

        // Ambil ID Kategori & Lokasi untuk foreign key
        $kategoriElk = $this->db->table('kategoris')->where('kode', 'ELK')->get()->getRowArray();
        $kategoriGls = $this->db->table('kategoris')->where('kode', 'GLS')->get()->getRowArray();

        $kategoriElkId = $kategoriElk ? $kategoriElk['id'] : 1;
        $kategoriGlsId = $kategoriGls ? $kategoriGls['id'] : 2;

        $lokasiKomputer = $this->db->table('lokasi')->where('nama_lokasi', 'Laboratorium Komputer')->get()->getRowArray();
        $lokasiFisika = $this->db->table('lokasi')->where('nama_lokasi', 'Laboratorium Fisika')->get()->getRowArray();

        $lokasiKomputerId = $lokasiKomputer ? $lokasiKomputer['id'] : 1;
        $lokasiFisikaId = $lokasiFisika ? $lokasiFisika['id'] : 2;

        // 4. Seed Inventaris
        $inventarisData = [
            [
                'nama_alat'   => 'Mikroskop Binokuler',
                'jumlah'      => 5,
                'kondisi'     => 'Baik',
                'kategori'    => 'Alat Gelas',
                'deskripsi'   => 'Mikroskop cahaya dengan dua lensa okuler untuk pengamatan spesimen biologi.',
                'foto_barang' => 'mikroskop.jpg',
                'kategori_id' => $kategoriGlsId,
                'lokasi_id'   => $lokasiFisikaId,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nama_alat'   => 'Solder Listrik',
                'jumlah'      => 10,
                'kondisi'     => 'Baik',
                'kategori'    => 'Alat Elektronik',
                'deskripsi'   => 'Alat pemanas untuk menyambungkan komponen elektronika pada PCB.',
                'foto_barang' => 'solder.jpg',
                'kategori_id' => $kategoriElkId,
                'lokasi_id'   => $lokasiKomputerId,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('inventaris')->insertBatch($inventarisData);

        // Ambil User & Barang untuk Transaksi
        $userCustomer = $this->db->table('users')->where('role', 'customer')->get()->getRowArray();
        $userId = $userCustomer ? $userCustomer['id'] : 1;
        $userNim = $userCustomer ? $userCustomer['nim'] : '67890';
        $userUsername = $userCustomer ? $userCustomer['username'] : 'mahasiswa_user';

        $barangMikroskop = $this->db->table('inventaris')->where('nama_alat', 'Mikroskop Binokuler')->get()->getRowArray();
        $barangId = $barangMikroskop ? $barangMikroskop['id'] : 1;

        // 5. Seed Transaksi
        $transaksiData = [
            [
                'id_user'              => $userId,
                'id_barang'            => $barangId,
                'nama_peminjam'        => $userUsername,
                'nim'                  => $userNim,
                'keperluan'            => 'Praktikum Mikrobiologi',
                'jumlah'               => 1,
                'tanggal_peminjaman'   => date('Y-m-d H:i:s'),
                'tanggal_pengembalian' => date('Y-m-d H:i:s', strtotime('+3 days')),
                'status'               => 'Dipinjam',
            ]
        ];
        $this->db->table('transaksi')->insertBatch($transaksiData);
    }
}
