<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saldo extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->my_login->check_login();

        if ($this->session->userdata('id')) {
            $this->load->model('User_m');
            $this->User_m->update_last_activity($this->session->userdata('id'));
        }
        
        $this->load->model('Saldo_m');
    }

    public function index() {
        $total = $this->Saldo_m->get_total_saldo();
        $saldo = $this->Saldo_m->get_saldo_all();
        $data = array('title'     => 'Saldo',
                      'total'   => $total,
                      'saldo'   => $saldo,
                      'content'   => 'saldo/index'
         );
        
        $this->load->view('layouts/wrapper', $data, FALSE);
    }

    public function tambah()
    {
        // Pastikan hanya admin yang bisa
        if ($this->session->userdata('role') !== 'admin') {
            show_404();
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_id', 'Member', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah Saldo', 'required|numeric|min_length[1]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('warning', validation_errors());
            redirect('dashboard');
        }

        $data = [
            'user_id'    => $this->input->post('user_id'),
            'jumlah'     => $this->input->post('jumlah'),
            'tipe'       => 'masuk',
            'keterangan' => $this->input->post('keterangan'),
            'tanggal'    => date('Y-m-d'),
            'created_at' => date('Y-m-d H:i:s') 
        ];

        $this->db->insert('transaksi', $data);
        $this->session->set_flashdata('success', 'Saldo berhasil ditambahkan ke member');
        redirect('dashboard');
    }

    public function kurang()
    {
        if ($this->session->userdata('role') !== 'admin') {
            show_404();
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_id', 'Member', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah Saldo', 'required|numeric|min_length[1]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('warning', validation_errors());
            redirect('dashboard');
        }

        $user_id = $this->input->post('user_id');
        $jumlah  = $this->input->post('jumlah');

        // Hitung total saldo member
        $total_masuk = $this->db->select_sum('jumlah')
                                ->where('user_id', $user_id)
                                ->where('tipe', 'masuk')
                                ->get('transaksi')->row()->jumlah;

        $total_keluar = $this->db->select_sum('jumlah')
                                 ->where('user_id', $user_id)
                                 ->where('tipe', 'keluar')
                                 ->get('transaksi')->row()->jumlah;

        $saldo = $total_masuk - $total_keluar;

        if ($jumlah > $saldo) {
            $this->session->set_flashdata('warning', 'Saldo member tidak mencukupi!');
            redirect('dashboard');
        }

        $data = [
            'user_id'    => $user_id,
            'jumlah'     => $jumlah,
            'tipe'       => 'keluar',
            'keterangan' => $this->input->post('keterangan'),
            'tanggal'    => date('d-m-Y'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('transaksi', $data);
        $this->session->set_flashdata('success', 'Saldo berhasil dikurangi dari member');
        redirect('dashboard');
    }


}