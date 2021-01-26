<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('M_menu', '', TRUE);
        $this->load->model('M_pelanggan', '', TRUE);
        $this->load->database();
    }

    public function index()
    {
        if (empty($this->session->userdata('fv_username'))) {
            echo "<script>
                alert('Anda harus login terlebih dahulu');
                window.location.href = '" . base_url('C_login') . "';
            </script>"; //Url tujuan
        }
        foreach ($this->M_menu->laporanBulanan()->result_array() as $row) {
            $data['grafik'][] = (float)$row['Januari'];
            $data['grafik'][] = (float)$row['Februari'];
            $data['grafik'][] = (float)$row['Maret'];
            $data['grafik'][] = (float)$row['April'];
            $data['grafik'][] = (float)$row['Mei'];
            $data['grafik'][] = (float)$row['Juni'];
            $data['grafik'][] = (float)$row['Juli'];
            $data['grafik'][] = (float)$row['Agustus'];
            $data['grafik'][] = (float)$row['September'];
            $data['grafik'][] = (float)$row['Oktober'];
            $data['grafik'][] = (float)$row['November'];
            $data['grafik'][] = (float)$row['Desember'];
        }
        $data['title'] = 'Home';
        $data['menu'] = $this->M_menu->get_menu();
        $this->load->view('admin/home', $data);
    }

    
    public function comingsoon()
    {
        $this->load->view('admin/v_comingsoon');
    }
}
