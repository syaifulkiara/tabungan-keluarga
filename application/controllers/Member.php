<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->my_login->check_login();

		if ($this->session->userdata('id')) {
            $this->load->model('User_m');
            $this->User_m->update_last_activity($this->session->userdata('id'));
        }

	}

	public function index()
	{
		$data = array('title'     => 'Dashboard - Member',   
					  'content'   => 'member'
		 );
		$this->load->view('layouts/wrapper', $data, FALSE);
	}

}