<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    public function run()
    {
        // Ambil User
        $userCustomer = $this->db->table('users')->where('role', 'customer')->get()->getRowArray();
        $userId = $userCustomer ? $userCustomer['id'] : 1;
        $userNim = $userCustomer ? $userCustomer['nim'] : '67890';
        $userUsername = $userCustomer ? $userCustomer['username'] : 'mahasiswa_user';

        // Ambil Barang
        $barangMikroskop = $this->db->table('inventaris')->where('nama_alat', 'Mikroskop Binokuler')->get()->getRowArray();
        $barangId = $barangMikroskop ? $barangMikroskop['id'] : 1;

        $data = [
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

        $this->db->table('transaksi')->insertBatch($data);
    }
}
