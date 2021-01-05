<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_pembelian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('M_menu');
        $this->load->model('M_pembelian');
        $this->load->model('M_barang');
        $this->load->model('M_pelanggan');
        $this->load->model('M_barang_id');
        if (empty($this->session->userdata('fv_username'))) {
            echo "<script>
                alert('Anda harus login terlebih dahulu');
                window.location.href = '" . base_url('C_login') . "';
            </script>"; //Url tujuan
        }
    }

    public function index()
    {
        $data['title'] = "Pembelian";
        $data['menu'] = $this->M_menu->get_menu();

        $data['barang'] = $this->M_barang->get_barang();
        $data['faktur'] = $this->M_pembelian->get_faktur();
        $data['pelanggan'] = $this->M_pembelian->get_pelanggan();

        $dateValue = date('Y-m-d');
        $time = strtotime($dateValue);

        $data['month'] = date("m", $time);
        $data['day'] = date("d", $time);
        $data['years'] = date("Y", $time);

        $this->load->view('admin/v_pembelian', $data);
    }

    public function tampil_faktur($id)
    {
        $data = $this->M_pembelian->get_by_id($id);
        echo json_encode($data);
    }

    public function tampil_faktur2($id)
    {
        $data = $this->M_pembelian->get_by_id2($id);
        echo json_encode($data);
    }

    public function tampil_pelanggan($id)
    {
        $data = $this->M_pembelian->get_pelanggan_id($id);
        echo json_encode($data);
    }

    public function save_datapelanggan()
    {

        $save_pelanggan = $this->M_pelanggan;

        $save_pelanggan->save_pelanggan();
        // $this->session->set_flashdata('success', '<div class="alert alert-success" role="alert">Data Produk Berhasil Disimpan :)</div>');
        // redirect('');
        echo "<script>
            window.location.href = '" . base_url('C_pembelian') . "';
            
        </script>"; //Url tujuan
    }

    public function tampil_barang($id)
    {
        $data = $this->M_pembelian->get_by_barang($id);
        echo json_encode($data);
    }

    public function getDataBarang()
    {
        $this->M_pembelian->ambilBarang();
        //print_r($this->db->last_query());
    }

    public function ajax_listall($Nomor)
    {

        $list = $this->M_barang_id->get_datatablesid();
        //print_r($this->db->last_query());
        $data = array();
        $no = $_REQUEST['start'];
        foreach ($list as $orde) {
            // $kode_barang = preg_replace ('/[^\p{L}\p{N}]/u', '', $orde->kode_barang);
            // $nama_barang = preg_replace ('/[^\p{L}\p{N}]/u', '', $orde->nama_barang);

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $orde->fc_kdstock;
            $row[] = $orde->fv_nmbarang;
            $row[] = $orde->ff_berat;
            $row[] = $orde->fc_kadar;
            $row[] = $orde->fv_nmlokasi;
            $row[] = $orde->fv_nmkelompok;

            $row[] = ' <button type="button" class="btn btn-primary " onclick="pencarian_kode(\'' . $orde->fc_barcode . '\',\'' . $orde->fc_kdstock . '\',\'' . $orde->fv_nmbarang . '\',\'' . $orde->fc_kdkelompok . '\',\'' . $orde->fc_kdlokasi . '\',\'' . $orde->ff_berat . '\',\'' . $orde->fc_kadar . '\',\'' . $orde->fm_ongkos . '\',\'' . $orde->fm_hargabeli . '\',\'' . $orde->fm_hargajual . '\',\'' . $Nomor . '\')">Pilih</button>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_REQUEST['draw'],
            "recordsTotal" => $this->M_barang_id->count_allid(),
            "recordsFiltered" => $this->M_barang_id->count_filteredid(),
            "data" => $data,
        );
        echo json_encode($output);
    }


    public function max_nota()
    {
        // header('Access-Control-Allow-Origin: *');
        // header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
        $data = $this->M_pembelian->where_max_nota()->row();
        //print_r($this->db->last_query());
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
    }

    public function tampil_nama($id)
    {
        $data = $this->M_penjualan->get_by_id($id);
        echo json_encode($data);
    }

    public function view_barang($id)
    {
        $data = $this->M_penjualan->get_by_barang($id);
        echo json_encode($data);
    }

    public function get_list_penjualan()
    {
        $data = $this->M_pembelian->get_list_penjualan();
        echo json_encode($data);
    }

    public function get_list_penjualan_det($fc_noinv)
    {
        $data = $this->M_pembelian->get_list_penjualan_det($fc_noinv);
        echo json_encode($data);
    }

    function simpan_pembelian()
    {
        $data_pembelian = array(
            'fc_nobeli'           => $this->input->post('no_faktur_penjualan'),
            'fd_tglbeli'        => date('Y-m-d'),
            'fc_noinv_lama'                  => $this->input->post('fc_noinv_view'), //$this->input->post('tanggal_penjualan'), 
            'fc_kdpel'                  => $this->input->post('fc_kdpel_view'),
            'fd_tglinput'             => date('Y-m-d'),
            'fc_userid'               => '1',
            'fm_subtot' => $this->input->post('SubTotalBayar2'),
            'fm_total' => $this->input->post('TotalBayar2'),
            'fm_pot' => $this->input->post('TotalPotongan'),
            'fc_status'               => '1',
            'fv_terbilang' => $this->input->post('terbilang'),
        );

        $id_pembelian = $this->M_pembelian->insertdata($data_pembelian);

        foreach ($this->input->post('Id') as $key => $value) {
            $data_detail_pembelian = array(
                'fc_nobeli' =>  $this->input->post('no_faktur_penjualan'),
                'fc_kdstock'      => $_POST['kode_stok'][$key],
                'fn_berat'             => $_POST['berat_emas'][$key],
                'f_kadar' => $_POST['kadar_emas'][$key],
                'fm_hargalama' => $_POST['hargalama'][$key],
                'fv_kondisi'     => $_POST['kondisi'][$key],
                'fm_potongan'        => $_POST['potongan'][$key],
                'fm_hargabeli'        => $_POST['hargabeli'][$key],
            );

            $id_pembelian_detail = $this->M_pembelian->insertdata_detail($data_detail_pembelian);


            $data1 = array('fc_sts' => '2');
            $this->M_pembelian->update_status($data1, array('fc_noinv' => $this->input->post('no_faktur_penjualan')));

            // echo "<script>
            // alert('Transaksi berhasil di simpan !!');
            // window.history.back();
            // </script>";
        }
        redirect('C_pembelian/cetak_nota/' . $this->input->post('no_faktur_penjualan'));
    }

    public function cetak_nota($nobeli)
    {
        $data['title'] = "Cetak Nota";
        $data['nota'] = $this->M_pembelian->query_nota($nobeli);
        $data['barang'] = $this->M_pembelian->query_nota2($nobeli);
        $this->load->view('admin/cetak_nota2', $data);
    }
}
