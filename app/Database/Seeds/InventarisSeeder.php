<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InventarisSeeder extends Seeder
{
    public function run()
    {
        // Ambil ID kategori dari database
        $kategoriElk = $this->db->table('kategoris')->where('kode', 'ELK')->get()->getRowArray();
        $kategoriGls = $this->db->table('kategoris')->where('kode', 'GLS')->get()->getRowArray();

        $kategoriElkId = $kategoriElk ? $kategoriElk['id'] : 1;
        $kategoriGlsId = $kategoriGls ? $kategoriGls['id'] : 2;

        // Ambil ID lokasi dari database
        $lokasiKomputer = $this->db->table('lokasi')->where('nama_lokasi', 'Laboratorium Komputer')->get()->getRowArray();
        $lokasiFisika = $this->db->table('lokasi')->where('nama_lokasi', 'Laboratorium Fisika')->get()->getRowArray();

        $lokasiKomputerId = $lokasiKomputer ? $lokasiKomputer['id'] : 1;
        $lokasiFisikaId = $lokasiFisika ? $lokasiFisika['id'] : 2;

        $data = [
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

        $this->db->table('inventaris')->insertBatch($data);
    }
}