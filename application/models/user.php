<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class User extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	public function get_all_users() {
		return $this->db->get('tabel_users');
	}
	public function delete_user($user) {
		$this->db->where('user', $user);
		if ($this->db->delete('tabel_users')) {
			return true;
		} else {
			return false;
		}
	}

	public function cekUser($user)
	{
		$query = $this->db->query("SELECT * FROM tabel_users WHERE user='$user'");
		$hasil = $query->num_rows();
		if ($hasil >= 1)
			return TRUE;
		else
			return FALSE;
	}

	public function get_user_details($user) {
		$this->db->where('user', $user);
			return $this->db->get('tabel_users');
	}
	public function login($username,$password){
		$where=array(
			'user' => $username,
			'pass' => sha1($password)
		);
		$this->db->select('*')->from('tabel_users')->where($where);
		$query = $this->db->get();
		return $query->first_row('array');
	}
    public function process_create_user($data){
            if ($this->db->insert('tabel_users',$data)){
                    return TRUE;
            } else {
                    return FALSE;
            }
	}
	public function process_update_user($user, $data) {
            $this->db->where('user', $user);
            if ($this->db->update('tabel_users', $data)) {
                return true;
            } else {
                return false;
            }
    }

    public function setPassword($user,$pass)
    {
    	return $this->db->query("UPDATE tabel_users SET pass='$pass' WHERE user='$user'");
    }
    
    public function getPassword($user)
    {
    	$mysql = $this->db->query("SELECT pass FROM tabel_users WHERE user='$user'");
    	return $mysql->first_row()->pass;
    }


}

