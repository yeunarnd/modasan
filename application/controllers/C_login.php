<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //$this->load->model('M_login');
        // $this->load->helper(array('url'));
        // if($this->session->userdata('status') == "admin"){
        // 	echo "<script>
        //         alert('Anda sudah login');
        //         window.location.href = '".base_url('C_login')."';
        //     </script>";//Url tujuan
        // }
    }

    public function index()
    {
        $data['title'] = 'Login';
        $this->load->view('admin/login', $data);
    }

    // public function proses_login()
    // {
    //     $fv_username = $this->input->post('fv_username');
    //     $password = $this->input->post('password');
    //     foreach ($this->M_login->admin($fv_username) as $row) {
    //         $id_admin = $row->fn_id;
    //         $fv_username = $row->fv_username;
    //         //$fc_kdposisi = $row->id_jabata;
    //     }
    //     $where = array(
    //         'fv_username' => $fv_username,
    //         'password' => $password
    //     );
    //     date_default_timezone_set('Asia/Jakarta');
    //     $tgl = date('Y-m-d H:i:s');
    //     $cek = $this->M_login->cek_login("admin", $where)->num_rows();
    //     if ($cek > 0) {
    //         if ($ == 1) {
    //             $data_session = array(
    //                 'username' => $username,
    //                 'iduser' => $iduser,
    //                 'status' => 'admin',
    //                 'jabatan' => 1,
    //             );
    //             //$this->M_login->gantitgl($tgl, $iduser);
    //             $this->session->set_userdata($data_session);
    //             redirect('Beranda');
    //         } else if ($jabatan == 2) {
    //             $data_session = array(
    //                 'username' => $username,
    //                 'iduser' => $iduser,
    //                 'status' => 'admin',
    //                 'jabatan' => 2,
    //             );
    //             $this->M_login->gantitgl($tgl, $iduser);
    //             $this->session->set_userdata($data_session);
    //             redirect('Beranda');
    //         } else if ($jabatan == 3) {
    //             $data_session = array(
    //                 'username' => $username,
    //                 'iduser' => $iduser,
    //                 'status' => 'admin',
    //                 'jabatan' => 3,
    //             );
    //             $this->M_login->gantitgl($tgl, $iduser);
    //             $this->session->set_userdata($data_session);
    //             redirect('Beranda');
    //         }
    //     } else {
    //         $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password anda salah!</div>');
    //         redirect('Login');
    //     }
    // }


    public function action_login()
    {
        $fv_username = $this->input->post('fv_username');
        $fv_password = $this->input->post('fv_password');

        $admin = $this->db->get_where('admin', ['fv_username' => $fv_username])->row_array();
        $cekpass = $this->db->get_where('admin', array('fv_password' => md5($fv_password)));


        //jika usernya terdaftar
        if ($admin) {
            //jika akun user aktif
            //cek password
            if ($cekpass->num_rows() > 0) {

                $data = [
                    'fv_username' => $admin['fv_username'],
                    'fc_userid' => $admin['fc_userid'],

                    //'foto' => $pengguna['foto']
                ];
                // print_r($data);
                $data['logged_in'] = TRUE;
                $this->session->set_userdata($data);
                // if ($admin['fc_kdposisi'] == '0001') {
                redirect('C_home');
                // } else {
                //     $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">posisi anda tidak di temukan!</div>');
                //     redirect('C_Login');
                // }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf password yang anda masukkan salah!</div>');
                redirect('C_Login');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf username yang anda masukkan salah!</div>');
            redirect('C_Login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">anda telah logout</div>');
        redirect('C_login');
    }
}
