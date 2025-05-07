<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saldo_m extends CI_Model {
    public function get_saldo_all() {
        return $this->db->query("
            SELECT m.id, m.nama_lengkap,
                SUM(CASE WHEN t.tipe = 'masuk' THEN t.jumlah ELSE 0 END) AS total_masuk,
                SUM(CASE WHEN t.tipe = 'keluar' THEN t.jumlah ELSE 0 END) AS total_keluar,
                (SUM(CASE WHEN t.tipe = 'masuk' THEN t.jumlah ELSE 0 END) -
                 SUM(CASE WHEN t.tipe = 'keluar' THEN t.jumlah ELSE 0 END)) AS saldo
            FROM users m
            LEFT JOIN transaksi t ON m.id = t.user_id
            GROUP BY m.id
        ")->result();
    }

    public function get_total_saldo() {
        return $this->db->query("
            SELECT (
                SUM(CASE WHEN tipe = 'masuk' THEN jumlah ELSE 0 END) -
                SUM(CASE WHEN tipe = 'keluar' THEN jumlah ELSE 0 END)
            ) AS total_saldo FROM transaksi
        ")->row();
    }

    public function get_saldo_masuk_keluar($user_id)
    {
        $masuk = $this->db->select_sum('jumlah')
            ->where('tipe', 'masuk')
            ->where('user_id', $user_id)
            ->get('transaksi')
            ->row()
            ->jumlah;

        $keluar = $this->db->select_sum('jumlah')
            ->where('tipe', 'keluar')
            ->where('user_id', $user_id)
            ->get('transaksi')
            ->row()
            ->jumlah;

        return [
            'masuk' => $masuk ?? 0,
            'keluar' => $keluar ?? 0,
            'total' => ($masuk ?? 0) - ($keluar ?? 0),
        ];
    }


}