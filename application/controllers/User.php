<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
       
        $this->load->model('User_m');
        $this->my_login->check_login(); 

        if ($this->session->userdata('id')) {
            $this->load->model('User_m');
            $this->User_m->update_last_activity($this->session->userdata('id'));
        }
    }

    public function index()
    {
        $user = $this->User_m->get_users();
        $data = array('title'     => 'Main Dashboard', 
                      'users'      => $user,        
                      'content'   => 'user/index'
         );
        
        $this->load->view('layouts/wrapper', $data, FALSE);
    }

    public function edit($id)
    {
        $user = $this->User_m->get_user($id);
        $data = array('title'     => 'Main Dashboard', 
                      'user'      => $user,        
                      'content'   => 'user/edit'
         );
        
        $this->load->view('layouts/wrapper', $data, FALSE);
    }

    public function my_profile()
    {
        $id = $this->session->userdata('id');
        $user = $this->User_m->get_user($id);
        $data = array('title'     => 'Main Dashboard', 
                      'user'      => $user,        
                      'content'   => 'user/my_profile'
         );
        
        $this->load->view('layouts/wrapper', $data, FALSE);
    }

    public function saveUser()
    {
        if ($this->session->userdata('role') != 'admin') {
            show_404();
        }

        $this->form_validation->set_rules('username', 'Nama Anda', 'required|is_unique[users.username]',
            array( 'required'   => '%s harus diisi'));
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required',
            array( 'required'   => '%s harus diisi'));
        $this->form_validation->set_rules('password', 'Kata Sandi', 'required|min_length[5]',
                ['min_length' => 'Panjang Password minimal 5 karakter.','required'   => '%s harus diisi' ]);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('warning', validation_errors());
            redirect('user');
        }

        $data = [
            'username' => $this->input->post('username', TRUE),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('users', $data);
        $this->session->set_flashdata('success', 'User berhasil ditambahkan');
        redirect('user');
    }

    // update oleh member
    public function update_profile()
    {
        $id = $this->session->userdata('id');

        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_tlp', 'No. Telepon', 'required');

        if ($this->form_validation->run() == TRUE) {
            $data = [
                'nama_lengkap' => $this->input->post('nama_lengkap', true),
                'alamat'       => $this->input->post('alamat', true),
                'no_tlp'       => $this->input->post('no_tlp', true)
            ];

            // Upload avatar jika ada
            if (!empty($_FILES['avatar']['name'])) {
                $config['upload_path']   = './assets/avatar/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size']      = 5120;
                $config['file_name']     = 'avatar_' . $id;
                $config['overwrite']     = TRUE; // supaya avatar lama diganti

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('avatar')) {
                    $upload_data = $this->upload->data();
                    $this->_crop_resize_avatar($upload_data['full_path']); // crop otomatis 500x500
                    $data['avatar'] = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('warning', $this->upload->display_errors());
                    redirect('user/my_profile');
                }
            }

            $this->User_m->update_user($id, $data);

            $this->session->set_flashdata('success', 'Profil berhasil diperbarui');
            redirect('user/my_profile');
        } else {
            $user = $this->User_m->get_user($id);
            $data = [
                'title'   => 'Main Dashboard',
                'user'    => $user,
                'content' => 'user/my_profile'
            ];
            $this->load->view('layouts/wrapper', $data, FALSE);
        }
    }

    // Tambahan fungsi private untuk crop + resize otomatis
    private function _crop_resize_avatar($path)
    {
        $this->load->library('image_lib');

        list($width, $height) = getimagesize($path);
        $minSize = min($width, $height);

        $x_axis = ($width - $minSize) / 2;
        $y_axis = ($height - $minSize) / 2;

        // Crop gambar ke tengah
        $config_crop['image_library'] = 'gd2';
        $config_crop['source_image'] = $path;
        $config_crop['maintain_ratio'] = FALSE;
        $config_crop['width'] = $minSize;
        $config_crop['height'] = $minSize;
        $config_crop['x_axis'] = $x_axis;
        $config_crop['y_axis'] = $y_axis;

        $this->image_lib->initialize($config_crop);

        if (!$this->image_lib->crop()) {
            echo $this->image_lib->display_errors();
        }

        // Resize ke 500x500 setelah crop
        $config_resize['image_library'] = 'gd2';
        $config_resize['source_image'] = $path;
        $config_resize['maintain_ratio'] = FALSE;
        $config_resize['width'] = 500;
        $config_resize['height'] = 500;

        $this->image_lib->clear();
        $this->image_lib->initialize($config_resize);

        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
        }
    }



    // UPDATE OLEH ADMIN
    public function update_myprofile()
    {
        $id = $this->input->post('id');

        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_tlp', 'No. Telepon', 'required');

        if ($this->form_validation->run() == TRUE) {
            $data = [
                'nama_lengkap' => $this->input->post('nama_lengkap', true),
                'alamat'       => $this->input->post('alamat', true),
                'no_tlp'       => $this->input->post('no_tlp', true),
                'role'         => $this->input->post('role', true)
            ];

            // Upload avatar jika ada
            if (!empty($_FILES['avatar']['name'])) {
                $config['upload_path']   = './assets/avatar/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size']      = 2048;
                $config['file_name']     = 'avatar_' . $id;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('avatar')) {
                    $upload_data = $this->upload->data();
                    $data['avatar'] = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('warning', $this->upload->display_errors());
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }

            $this->User_m->update_user($id, $data);
            $this->session->set_flashdata('success', 'Profil berhasil diperbarui');
            redirect('user');
        } else {
            $user = $this->User_m->get_user($id);
            $data = [
                'title'   => 'Main Dashboard',
                'user'    => $user,
                'content' => 'user/edit'
            ];
            $this->load->view('layouts/wrapper', $data, FALSE);
        }
    }

    public function ubah_password()
    {
        $this->my_login->check_login(); // pastikan user login

        $this->load->library('form_validation');
        $this->form_validation->set_rules('password_baru', 'Password', 'required|min_length[5]');
        $this->form_validation->set_rules('konfirmasi_password', 'Confirm Password', 'required|matches[password_baru]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('warning', validation_errors());
            redirect('user/my_profile');
        } else {
            $id = $this->session->userdata('id');
            $password_baru = $this->input->post('password_baru');

            $this->db->update('users', [
                'password' => password_hash($password_baru, PASSWORD_DEFAULT)
            ], ['id' => $id]);

            $this->session->set_flashdata('success', 'Password berhasil diubah');
            redirect('user/my_profile');
        }
    }


    public function check_online_status() {
        $users = $this->User_m->get_all_users(); // ambil semua user

        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->id,
                'nama_lengkap' => $user->nama_lengkap,
                'online' => $this->User_m->is_user_online($user->id)
            ];
        }

        echo json_encode($data);
    }

    public function teman()
    {
        // Proteksi hanya untuk member
        // if ($this->session->userdata('role') !== 'member') {
        //     show_404();
        // }

        $user_id = $this->session->userdata('id');
        $members = $this->User_m->get_other_members($user_id);

         $data = [
            'title'   => 'Online Member',
            'members'    => $members,
            'content' => 'user/teman'
        ];
        $this->load->view('layouts/wrapper', $data, FALSE);
    }

    public function hapus($id)
    {
        $this->User_m->delete_user($id);
        if($this->db->affected_rows() > 0){
        $this->session->set_flashdata('success', 'Berhasil hapus member');
        }
        redirect('user');
    }

}
