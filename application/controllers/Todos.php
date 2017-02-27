<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Todos extends CI_Controller {
    
    private function load_helper_and_model() {
        //Load helper
        $this->load->helper('url');

        $this->load->helper('form');
        //Load model
        $this->load->model('todo');
    }

    private function set_flashes($condition, $successMessage, $errorMessage) {
        if ($condition) {
            $this->session->set_flashdata('success', $successMessage);
        } else {
            $this->session->set_flashdata('error', $errorMessage);
        }
    }

    private function when_posted($id, $data) {
        if (!$id) {
            //add todo
            $this->set_flashes($this->todo->db->insert('items', $data), 'Successfully added item to your shopping list', 'There was a problem adding the item to your shopping list');
        } else {
            //edit todo
            $this->todo->db->where('id', $id);
            $this->set_flashes($this->todo->db->update('items', $data), 'Successfully updated the selected item on your shopping list', 'There was a problem updating the selected item on your shopping list');
        }
    }

    public function index() {

        //*****modular views	
        //Load Libary
        $this->load->library('template');

        //Metadata and Title
        $this->template->set_title('List');
        $this->template->set_title_desc('A shopping list');
        $this->template->add_meta('description', 'This is a really cool shopping list.');
        $this->template->add_meta('keywords', 'list, todos');
        
        
        $this->load_helper_and_model();
        
        $query = $this->todo->db->get_where('items', ['user_id' => $this->session->userdata('user_id')]);
        
        $data['todos'] = $query->result();
        
        $this->template->add_css('css/main.css');
        
        //Load page
        $this->template->load_view('pages/list', $data);
    }

    public function add_edit($id = NULL) {

        $data['id'] = $id;
        
        //*****modular views	
        //Load Libary
        $this->load->library('template');
        $this->load->library('form_validation');

        //Metadata and Title
        $this->template->set_title('Add | Edit');
        $this->template->set_title_desc('Edit shopping list');
        $this->template->add_meta('description', 'This is where you add\edit your shopping list.');
        $this->template->add_meta('keywords', 'add, edit, todos');
        $this->template->add_css('css/main.css');
        $this->load_helper_and_model();

        $todo = NULL;

        if ($this->input->post('cancel')) {
            //Redirect back to list page
            redirect('/todos', 'refresh');
        }

        if ($this->input->post()) {

            //if something in the post
            $this->form_validation->set_rules([['field' => 'item', 'label' => 'item', 'rules' => 'required']]);

            //check to see if form validates
            if ($this->form_validation->run()) {

                //If form validates
                $data = ['item' => $this->input->post('item'), 'user_id' => $this->session->userdata('user_id')];
                $this->when_posted($id, $data);

                //Redirect back to list page
                redirect('/todos', 'refresh');
            } else {
                //doesn't validate
                $todo = new Todo();
                $todo->item = '';
            }
        } else {
            //Coming from list
            if (!$id) {
                //Coming to add
                $todo = new Todo();
                $todo->item = '';
            } else {
                //Coming to edit
                $query = $this->todo->db->get_where('items', ['id' => $id]);
                $todo = $query->row();
            }
        }

        //Send todo to page
        $data['todo'] = $todo;

        //Load page
        $this->template->load_view('pages/add_edit', $data);
    }
    
    
    /**
     * Display Login page.
     */
    public function login() {
        $this->load->library('template');
        //Load helper
        $this->load->helper('url');
	$this->load->helper('form');
        $this->template->add_css('css/main.css');
	$this->template->load_view('pages/login');
    }
    
    /**
     * Display Sign Up page.
     */
    public function signup() {
        $this->load->library('template');
        $this->load->helper('url');
	$this->load->helper('form');
        $this->template->add_css('css/main.css');
	$this->template->load_view('pages/signup');
    }
    /**
     * Sign the user out and load home page.
     */
    public function logout() {
        $this->load->helper('url');
	$this->session->sess_destroy();
	redirect('/todos', 'refresh');
    }
    
    public function validate_user(){
	$this->validate(false);	
    }
   /**
    * Validate that the user is a member. Also used as part of login 
    * (and AJAX login) functionality.
    */
    public function validate($is_ajax = true) {
        $this->load->helper('url');
	$this->load->model('User');
	if ($this->User->validate()) {
	    $this->_do_login();
	    if(!$is_ajax){
		redirect('todos');
	    }
	} else { // incorrect username or password
	    $this->session->set_flashdata('error', 'Incorrect username and/or password. Please try again.');
	    redirect('/todos/login', 'refresh');
	}
    }
    /**
     * Log the user in and redirect to home page.
     */
    private function _do_login() {
        $this->load->model('user');
	$data = array(
            'user_id' => $this->user->db->select('id')->where('username', $this->input->post('username'))->get('users')->row()->id,
	    'username' => $this->input->post('username'),
	    'is_logged_in' => true
	);
	$this->session->set_userdata($data);
    }  
    
    /**
     * Create a new user and store in db. Used as part of Signup functionality.
     */
    public function create_user() {
        $this->load->library('template');
	$this->load->library('form_validation');
        $this->load->helper('url');
	//validate 
	$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
	$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
	$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email');
	$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]');
	$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
	$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
	if (!$this->form_validation->run()) {
	    $this->template->load_view('pages/signup');
	} else {
	    //Create new user
	    $this->load->model('user');
	    $data['first_name'] = $this->input->post('first_name');
	    $data['last_name'] = $this->input->post('last_name');
	    $data['email_address'] = $this->input->post('email_address');
	    $data['username'] = $this->input->post('username');
	    $data['password'] = md5($this->input->post('password'));
	    //save new user
	    if ($this->user->db->insert('users', $data)) {
		$this->_do_login();
		$this->session->set_flashdata('success', 'Account successfully created.');
		redirect('/todos', 'refresh');
	    } else {
		$this->session->set_flashdata('error', 'An error occurred and the account was not created.');
		redirect('todos/signup');
	    }
	}
    }
    
    public function delete($id) {

        //Load url helper
        $this->load->helper('url');

        //Load Model
        $this->load->model('todo');

        //Pass id through to view
        $data['id'] = $id;

        //Delete todo
        if ($this->todo->db->delete('items', ['id' => $id])) {
            $this->session->set_flashdata('success', 'Successfully deleted item');
        } else {
            $this->session->set_flashdata('error', 'There was a problem deleting the item');
        }

        //Redirect back to list page
        redirect('', 'refresh');
    }
    
        public function complete($id) {

        //Load url helper
        $this->load->helper('url');

        //Load Model
        $this->load->model('todo');
        
        
        
        $this->todo->db->update('items', ['status' => 'complete'], ['id' => $id]);
        $this->session->set_flashdata('success', 'Successfully completed item');
        
        //Pass id through to view
        $data['id'] = $id;

       
        //Redirect back to list page
        redirect('', 'refresh');
    }

}
