<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
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

        $this->db->table('kategoris')->insertBatch($data);
    }
}
