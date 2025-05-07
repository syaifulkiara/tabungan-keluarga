<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('User_m');
    }

    public function index()
    {
        if ($this->session->userdata('id')) {
            redirect(base_url('dashboard'));
        }

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $this->form_validation->set_rules('username','Nama Anda', 'required',
            array( 'required'   => '%s harus diisi'));
        $this->form_validation->set_rules('password','Kata Sandi', 'required',
            array( 'required'   => '%s harus diisi'));
        if($this->form_validation->run())
        {
            $this->my_login->login($username, $password);
        }

        $this->load->view('login');
    }

    public function register()
    {
        // Kalau POST (form submit)
        if ($this->input->post()) {
    
            $this->form_validation->set_rules('username', 'Nama Anda', 'required|is_unique[users.username]',
                ['required' => '%s harus diisi']);
            $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required',
                ['required' => '%s harus diisi']);
            $this->form_validation->set_rules('password', 'Kata Sandi', 'required|min_length[4]',
                ['required' => '%s harus diisi']);
            $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'required|matches[password]',
                ['matches' => 'Konfirmasi Password tidak sama dengan Password.']);
            $this->form_validation->set_rules('role', 'Role', 'required',
                ['required' => '%s harus diisi']);
    
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('warning', validation_errors());
                redirect('auth/register');
            } else {
                // Cek reCAPTCHA
                $recaptchaResponse = $this->input->post('g-recaptcha-response');
                $userIp = $this->input->ip_address();
        
                $secret = '6LeFIyYrAAAAAKwnwz0ivFGPz0VpmnY5AwGzEv4N'; // ganti dengan secret key
                $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$recaptchaResponse&remoteip=$userIp");
                $responseData = json_decode($verifyResponse);
        
                if (!$responseData->success) {
                    $this->session->set_flashdata('warning', 'reCAPTCHA verification failed, please try again.');
                    redirect('auth/register');
                }
    
                // Save user
                $data = [
                    'username'      => $this->input->post('username', true),
                    'nama_lengkap'  => $this->input->post('nama_lengkap', true),
                    'password'      => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'role'          => $this->input->post('role', true)
                ];
    
                $this->User_m->create_user($data);
                $this->session->set_flashdata('success', 'Pendaftaran berhasil, Silakan Login!');
                redirect('auth');
            }
    
        } else {
            // Kalau GET (belum submit form)
            $this->load->view('register');
        }
    }


    public function logout()
    {
        $this->my_login->logout();
    }

}