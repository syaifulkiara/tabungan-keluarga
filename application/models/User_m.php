<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function login($username, $password)
    {
        $this->db->where('username', $username);
        $user = $this->db->get('users')->row();

        if ($user) {
            if (password_verify($password, $user->password)) {
                return $user; // login berhasil
            }
        }

        return false; // login gagal
    }

    public function get_users() {
        return $this->db->get('users')->result();
    }

    public function get_user($id) {
        return $this->db->get_where('users', array('id' => $id))->row();
    }

    public function get_user_by_username($username) {
        return $this->db->get_where('users', array('username' => $username))->row();
    }

    public function create_user($data) {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function update_user($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function delete_user($id) {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }

    public function check_password($id, $password) {
        $user = $this->get_user($id);
        return password_verify($password, $user->password);
    }

    public function update_password($id, $password) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        return $this->update_user($id, array('password' => $hashed));
    }

    //GET STATUS ONLINE 

    public function update_last_activity($id) {
        $this->db->where('id', $id);
        $this->db->update('users', ['last_activity' => date('Y-m-d H:i:s')]);
    }

    public function is_user_online($id) {
        $this->db->select('last_activity');
        $this->db->where('id', $id);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            $last_activity = $query->row()->last_activity;

            if ($last_activity !== null) {
                return (time() - strtotime($last_activity)) <= 120; // 5 menit
            }
        }

        return false; // default offline
    }

    public function get_online_users() {
        $this->db->where('last_activity >=', date('Y-m-d H:i:s', strtotime('-5 minutes')));
        return $this->db->get('users')->result();
    }

    public function get_all_users() {
        return $this->db->get('users')->result();
    }

    public function get_all_members()
    {
        return $this->db->where('role', 'member')->get('users')->result();
    }

    public function get_other_members($exclude_id)
    {
        return $this->db
            ->where('role', 'member')
            ->where('id !=', $exclude_id)
            ->get('users')
            ->result();
    }

}