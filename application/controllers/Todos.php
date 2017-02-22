<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Todos extends CI_Controller {
    
    private function load_helper_and_model() {
        //Load helper
        $this->load->helper('url');

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
        
        $query = $this->todo->db->query('SELECT * FROM items');

        $data['todos'] = $query->result();
        
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

        $this->load_helper_and_model();

        $todo = NULL;

        if ($this->input->post('cancel')) {
            //Redirect back to list page
            redirect('', 'refresh');
        }

        if ($this->input->post()) {

            //if something in the post
            $this->form_validation->set_rules([['field' => 'item', 'label' => 'item', 'rules' => 'required']]);

            //check to see if form validates
            if ($this->form_validation->run()) {

                //If form validates
                $data = ['item' => $this->input->post('item')];
                $this->when_posted($id, $data);

                //Redirect back to list page
                redirect('', 'refresh');
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

}
