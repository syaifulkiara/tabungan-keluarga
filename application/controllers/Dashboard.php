<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->my_login->check_login();

		if ($this->session->userdata('id')) {
            $this->load->model('User_m');
            $this->User_m->update_last_activity($this->session->userdata('id'));
        }

		$this->load->model('Dashboard_m');
		$this->load->model('Transaksi_m');
	}

	public function index()
	{
		$total_saldo  			= $this->Dashboard_m->get_total_saldo();
        $total_member 			= $this->Dashboard_m->get_total_member();
        $total_masuk  			= $this->Dashboard_m->get_total_masuk();
        $total_keluar 			= $this->Dashboard_m->get_total_keluar();
        $masuk_hari_ini 		= $this->Dashboard_m->get_masuk_hari_ini();
        $keluar_hari_ini 		= $this->Dashboard_m->get_keluar_hari_ini();
        $get_transaksi_terakhir = $this->Transaksi_m->get_transaksi_terakhir();
        $members 			    = $this->User_m->get_all_members();
		$data = array('title'     				=> 'Dashboard - Admin',
			          'total_saldo'  			=> $total_saldo,
			          'total_member' 			=> $total_member,
			          'total_masuk'  			=> $total_masuk,
			          'total_keluar' 			=> $total_keluar,
			          'masuk_hari_ini' 			=> $masuk_hari_ini,
			          'keluar_hari_ini' 		=> $keluar_hari_ini, 
			          'get_transaksi_terakhir'  => $get_transaksi_terakhir,
			          'members'					=> $members,
					  'content'   				=> 'dashboard'
		 );
		
		$this->load->view('layouts/wrapper', $data, FALSE);
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */