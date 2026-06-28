<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LokasiSeeder extends Seeder
{
    public function run()
    {
        $data = [
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

        $this->db->table('lokasi')->insertBatch($data);
    }
}
