<?php
defined('BASEPATH') or exit('no direct script access allowed');

class Crud_Multiple extends MY_App
{

    private $redirect = 'app/crud_multiple';
    private $redirect_create = 'app/crud_multiple/create';

    public function __construct()
    {

        parent::__construct();

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('app/M_Crud_Multiple');
    }

    public function index()
    {

        $data = [
            'title' => 'Module Crud',
            'biodata' => $this->M_Crud_Multiple->read(),
        ];

        $this->load->view('app/crud_multiple/index', $data);
    }

    public function create()
    {

        $data = [
            'title' => 'Create Data',
            'update' => false,
        ];

        /**
         * check if count form > 100
         */
        if ($this->input->get('form')) {

            if ($this->input->get('form') > 100) {
                $this->session->set_flashdata('validation', 'Form limited 100');
                redirect($this->redirect_create);
                exit;
            } elseif (!is_numeric($this->input->get('form'))) {
                $this->session->set_flashdata('validation', 'Error Create Form, Parameter not interger');
                redirect($this->redirect_create);
                exit;
            }
        }

        $this->load->view('app/crud_multiple/form', $data);
    }

    public function process_create()
    {

        $create = $this->M_Crud_Multiple->create_multiple();

        if ($create == TRUE) {

            $this->session->set_flashdata('create', true);
        } else {

            $this->session->set_flashdata('create', 'failed');
        }

        redirect($this->redirect);
    }

    public function update($id = false)
    {

        $data = [
            'title' => 'Update Data',
            'update' => true,
            'biodata' => $this->M_Crud_Multiple->read_multiple($id),
        ];

        $this->load->view('app/crud_multiple/form', $data);
    }

    public function process_update()
    {

        if ($this->M_Crud_Multiple->update_multiple() == TRUE) {

            $this->session->set_flashdata('edit', true);
        } else {

            $this->session->set_flashdata('edit', 'failed');
        }

        redirect($this->redirect);
    }

    public function process_delete()
    {


        if ($this->M_Crud_Multiple->delete_batch() == TRUE) {

            $this->session->set_flashdata('delete', true);
        } else {

            $this->session->set_flashdata('delete', 'failed');
        }

        redirect($this->redirect);
    }
}
