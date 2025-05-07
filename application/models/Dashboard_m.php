<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_m extends CI_Model {

    public function get_total_saldo() {
        $masuk = $this->db->select_sum('jumlah')->where('tipe', 'masuk')->get('transaksi')->row()->jumlah;
        $keluar = $this->db->select_sum('jumlah')->where('tipe', 'keluar')->get('transaksi')->row()->jumlah;
        return $masuk - $keluar;
    }

    public function get_total_member() {
        return $this->db->count_all('users');
    }

    public function get_total_masuk() {
        return $this->db->select_sum('jumlah')->where('tipe', 'masuk')->get('transaksi')->row()->jumlah;
    }

    public function get_total_keluar() {
        return $this->db->select_sum('jumlah')->where('tipe', 'keluar')->get('transaksi')->row()->jumlah;
    }

    public function get_masuk_hari_ini() {
        return $this->db
            ->select_sum('jumlah')
            ->where('tipe', 'masuk')
            ->where('DATE(tanggal)', date('Y-m-d'))
            ->get('transaksi')
            ->row()
            ->jumlah;
    }

    public function get_keluar_hari_ini() {
        return $this->db
            ->select_sum('jumlah')
            ->where('tipe', 'keluar')
            ->where('DATE(tanggal)', date('Y-m-d'))
            ->get('transaksi')
            ->row()
            ->jumlah;
    }
}