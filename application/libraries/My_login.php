<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_login
{
	protected $CI;

	public function __construct()
	{
        $this->CI =& get_instance();
        $this->CI->load->model('User_m');
	}

	public function login($username, $password)
	{
		$check = $this->CI->User_m->login($username, $password);
		if ($check) {
			// Simpan ke session
			$this->CI->session->set_userdata([
				'id'       		=> $check->id,
				'username' 		=> $check->username,
				'nama_lengkap'  => $check->nama_lengkap,
				'avatar'   		=> $check->avatar,
				'role'     		=> $check->role,
				'logged_in'		=> TRUE
			]);

			// Redirect berdasarkan role
			if ($check->role == 'admin') {
				redirect(base_url('dashboard'));
			} else if ($check->role == 'member') {
				redirect(base_url('member'));
			} else {
				// Role tidak dikenal
				$this->logout(); 
			}
		} else {
			$this->CI->session->set_flashdata('warning', 'Nama pengguna atau kata sandi salah');
			redirect(base_url('auth'));
		}
	}

	public function check_login()
	{
		if (!$this->CI->session->userdata('logged_in')) {
			$this->CI->session->set_flashdata('warning', 'Anda belum login');
			redirect(base_url('auth'));
		}
	}

	public function logout()
	{
			$this->CI->session->unset_userdata('id');
			$this->CI->session->unset_userdata('username');
			$this->CI->session->unset_userdata('role');
			$this->CI->session->unset_userdata('logged_in');
			
			$this->CI->session->set_flashdata('success','Anda telah berhasil keluar');
			redirect(base_url('auth'));
	}

	

}

/* End of file My_login.php */
/* Location: ./application/libraries/My_login.php */
