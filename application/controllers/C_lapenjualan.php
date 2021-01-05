<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_lapenjualan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('M_menu');
        $this->load->model('M_lapenjualan');
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
        $data['title'] = "Laporan Penjualan";
        $data['menu'] = $this->M_menu->get_menu();
        // $startdate = $this->input->get('startdate', TRUE);
        // $enddate = $this->input->get('enddate', TRUE);


        // if ($startdate and $enddate) {
        //     $data['penjualan'] = $this->M_lapenjualan->get_lapenjualan($startdate, $enddate);
        //     // $data['total_asset'] = $this->M_lapenjualan->get_lapenjualan($startdate, $enddate);
        // } else {
        //     $data['penjualan'] = $this->M_lapenjualan->tampil_semua();
        // }

        $this->load->view('admin/v_lapenjualan', $data);
    }

    // public function filter()
    // {
    //     $startdate = $this->input->get('startdate', TRUE);
    //     $enddate = $this->input->get('enddate', TRUE);

    //     $data['penjualan'] = $this->M_lapenjualan->get_lapenjualan($startdate, $enddate);

    //     $this->load->view('admin/v_lapenjualan', $data);
    // }

    public function view_cetak()
    {
        $data['title'] = "Cetak Laporan Penjualan";
        //$data['menu'] = $this->M_menu->get_menu();
        // $data['pelanggan'] = $this->M_penjualan->get_pelanggan();
        $data['brt'] = $this->M_lapenjualan->get_berat();
        $data['lapen'] = $this->M_lapenjualan->get_cetak();
        $this->load->view('admin/cetak_lapenjualan', $data);
    }

}
