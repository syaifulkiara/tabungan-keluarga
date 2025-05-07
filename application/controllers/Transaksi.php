<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->my_login->check_login();

        if ($this->session->userdata('id')) {
            $this->load->model('User_m');
            $this->User_m->update_last_activity($this->session->userdata('id'));
        }
        
        $this->load->model('Transaksi_m');
        $this->load->model('Saldo_m');
        $this->load->model('User_m');
    }

    public function index() {
        $transaksi = $this->Transaksi_m->get_all_transaksi();
        $data = array('title'     => 'Transaksi',
                      'transaksi' => $transaksi,
                      'content'   => 'transaksi/index'
         );
        
        $this->load->view('layouts/wrapper', $data, FALSE);
    }

    public function masuk() {
        $transaksi = $this->Transaksi_m->get_by_type('masuk');
        $users = $this->User_m->get_users();
        $data = array('title'     => 'Transaksi Masuk',
                      'transaksi' => $transaksi,
                      'users'   => $users,
                      'content'   => 'transaksi/masuk'
         );
        
        $this->load->view('layouts/wrapper', $data, FALSE);
    }

    public function keluar() {        
        $transaksi = $this->Transaksi_m->get_by_type('keluar');
        $users = $this->User_m->get_users();
        $data = array('title'     => 'Transaksi Keluar',
                      'transaksi' => $transaksi,
                      'users'   => $users,
                      'content'   => 'transaksi/keluar'
         );
        
        $this->load->view('layouts/wrapper', $data, FALSE);
    }

    public function edit($id)
    {
        if ($this->session->userdata('role') !== 'admin') {
            show_404();
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');

        if ($this->form_validation->run()) {
            $this->db->where('id', $id);
            $this->db->update('transaksi', [
                'jumlah'     => $this->input->post('jumlah'),
                'keterangan' => $this->input->post('keterangan'), 
                'tanggal'    => $this->input->post('tanggal'), 
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            $this->session->set_flashdata('success', 'Transaksi berhasil diubah');
        } else {
            $this->session->set_flashdata('warning', validation_errors());
        }

        redirect('transaksi');
    }


    public function hapus($id)
    {
        // Hanya admin
        if ($this->session->userdata('role') !== 'admin') {
            show_404();
        }

        $this->db->where('id', $id);
        $this->db->delete('transaksi');
        $this->session->set_flashdata('success', 'Transaksi berhasil dihapus');
        redirect('transaksi');
    }


    public function riwayat()
    {
        $user_id = $this->session->userdata('id');
        $transaksi = $this->Transaksi_m->get_transaksi_by_member($user_id);
        $saldoku = $this->Saldo_m->get_saldo_masuk_keluar($user_id);
        $saldo_masuk = $saldoku['masuk'];
        $saldo_keluar = $saldoku['keluar'];
        $total_saldo = $saldoku['total'];

        $data = array('title'     => 'Riwayat Transaksi',
                      'transaksi' => $transaksi,
                      'saldoku'   => $saldoku,
                      'saldo_masuk'  => $saldo_masuk,
                      'saldo_keluar' => $saldo_keluar,
                      'total_saldo'  => $total_saldo,
                      'content'   => 'transaksi/riwayat'
         );
        
        $this->load->view('layouts/wrapper', $data, FALSE);
    }
}