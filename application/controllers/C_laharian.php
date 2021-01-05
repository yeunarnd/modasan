<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_laharian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('M_menu');
        $this->load->model('M_laharian');
        $this->load->model('M_barang');
        $this->load->model('M_pelanggan');
        if (empty($this->session->userdata('fv_username'))) {
            echo "<script>
                alert('Anda harus login terlebih dahulu');
                window.location.href = '" . base_url('C_login') . "';
            </script>"; //Url tujuan
        }
    }

    public function index()
    {
        $data['title'] = "Laporan Harian";
        $data['menu'] = $this->M_menu->get_menu();


        $this->load->view('admin/v_laharian', $data);
    }
}
