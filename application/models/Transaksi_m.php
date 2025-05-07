<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_m extends CI_Model {

    public function get_all_transaksi($tipe = null)
    {
        $this->db->select('transaksi.*, users.nama_lengkap');
        $this->db->from('transaksi');
        $this->db->join('users', 'users.id = transaksi.user_id');
        if ($tipe) {
            $this->db->where('transaksi.tipe', $tipe); // 'masuk' atau 'keluar'
        }
        $this->db->order_by('transaksi.tanggal', 'DESC');
        return $this->db->get()->result();
    }

    public function insert($data) {
        return $this->db->insert('transaksi', $data);
    }

    public function get_by_type($type) {
        $this->db->select('transaksi.*, users.nama_lengkap');
        $this->db->from('transaksi');
        $this->db->join('users', 'users.id = transaksi.user_id');
        $this->db->where('transaksi.tipe', $type);
        return $this->db->get()->result();
    }

    public function get_transaksi_by_member($user_id)
    {
        return $this->db->where('user_id', $user_id)
                        ->order_by('tanggal', 'DESC')
                        ->get('transaksi')
                        ->result();
    }

    public function get_transaksi_terakhir()
    {
        return $this->db
        ->select('transaksi.*, users.nama_lengkap, users.no_tlp, users.avatar')
        ->from('transaksi')
        ->join('users', 'users.id = transaksi.user_id')
        ->order_by('transaksi.created_at', 'DESC')
        ->limit(7)
        ->get()
        ->result();

        return $this->db
            ->order_by('created_at', 'DESC')
            ->limit(7)
            ->get('transaksi')
            ->result();
    }

}