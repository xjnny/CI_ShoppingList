<?php

class User extends CI_Model {
    
    public $id;
    public $first_name;
    public $last_name;
    public $email_address;
    public $username;
    public $password;
    
    function validate() {
        $user = $this->db->select('id', 'username', 'password')->where(['username' => $this->input->post('username'), 'password' => md5($this->input->post('password'))])->get('users')->row()->id;
        if ($user !== NULL) {
	    return true;
        }
    }
    
}
