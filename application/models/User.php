<?php

class User extends CI_Model {
    
    public $id;
    public $first_name;
    public $last_name;
    public $email_address;
    public $username;
    public $password;
    
    function validate() {
        $user = $this->db->get_where('users', ['username' => $this->input->post('username'), 'password' => md5($this->input->post('password'))]);
        if ($user) {
	    return true;
        }
    }
    
}
