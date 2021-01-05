<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_penjualan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('M_menu');
        $this->load->model('M_penjualan');
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
        $data['title'] = "Penjualan";
        $data['menu'] = $this->M_menu->get_menu();
        // $data['penjualan'] = $this->M_penjualan->get_penjualan();


        $data['pelanggan'] = $this->M_penjualan->get_pelanggan();

        $data['barang'] = $this->M_barang->get_barang();
        $data['sales'] = $this->M_penjualan->get_sales();

        $dateValue = date('Y-m-d');
        $time = strtotime($dateValue);

        $data['month'] = date("m", $time);
        $data['day'] = date("d", $time);
        $data['years'] = date("Y", $time);


        $this->load->view('admin/v_penjualan', $data);
    }

    public function save_datapelanggan()
    {


        $save_pelanggan = $this->M_pelanggan;

        $save_pelanggan->save_pelanggan();
        // $this->session->set_flashdata('success', '<div class="alert alert-success" role="alert">Data Produk Berhasil Disimpan :)</div>');
        // redirect('');
        echo "<script>
            $('#closemodal').click(function() {
            $('#tambahpelanggan').modal('hide');
            });
            alert('Data pelanggan berhasil di tambahkan');
        </script>"; //Url tujuan
    }

    public function tampil_nama($id)
    {
        $data = $this->M_penjualan->get_by_id($id);
        echo json_encode($data);
    }

    public function tampil_sales($id)
    {
        $data = $this->M_penjualan->get_by_sales($id);
        echo json_encode($data);
    }

    public function tampil_barang($id)
    {
        $data = $this->M_penjualan->get_by_barang($id);
        echo json_encode($data);
    }

    public function tampil_nota($noinv)
    {
        $data = $this->M_penjualan->nota_jual($noinv);
        echo json_encode($data);
    }

    public function coba()
    {
        $data['title'] = "Penjualan";
        $data['menu'] = $this->M_menu->get_menu();
        // $data['penjualan'] = $this->M_penjualan->get_penjualan();


        $data['pelanggan'] = $this->M_penjualan->get_pelanggan();

        $data['barang'] = $this->M_barang->get_barang();

        $this->load->view('coba/coba2', $data);
    }


    public function getDataBarang()
    {
        $this->M_penjualan->ambilBarang();
        //print_r($this->db->last_query());
    }

    public function get_barang_tampil()
    {
        echo json_encode($this->M_penjualan->get_all_barang()->result());
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
            $row[] = $orde->fv_nmlokasi;
            $row[] = $orde->fv_nmkelompok;
            $row[] = $orde->ff_berat;
            $row[] = $orde->fc_kadar;

            $row[] = ' <button type="button" class="btn btn-primary " onclick="pencarian_kode(\'' . $orde->fc_barcode . '\',\'' . $orde->fc_kdstock . '\',\'' . $orde->fv_nmbarang . '\',\'' . $orde->fc_kdkelompok . '\',\'' . $orde->fc_kdlokasi . '\',\'' . $orde->ff_berat . '\',\'' . $orde->fc_kadar . '\',\'' . $orde->fm_ongkos . '\',\'' . $orde->fm_hargabeli . '\',\'' . $orde->fm_hargajual . '\',\'' . $Nomor . '\',\'' . $orde->f_foto . '\')">Pilih</button>';


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
        $data = $this->M_penjualan->where_max_nota()->row();
        //print_r($this->db->last_query());
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
    }

    public function simpan_penjualan()
    {
        $data_penjualan = array(
            'fc_noinv'           => $this->input->post('fc_noinv'),
            'fd_tglinv'        => $this->input->post('fd_tgliv'),
            'fd_tglinput'                  => date('Y-m-d'), //$this->input->post('tanggal_penjualan'), 
            'fc_kdpel'                  => $this->input->post('fc_kdpel_view'),
            'fc_salesid'             => $this->input->post('fc_salesid_view'),
            'fc_userid'               => '1',
            'fc_ppn'           => 0,
            'fc_sts'               => '1',
            'fv_catatan'                => '',
            'fm_totdisc' => $this->input->post('TotalDiskon'),
            'fm_totongkir' => $this->input->post('TotalOngkir'),
            'fm_subtot' => $this->input->post('SubTotalBayar2'),
            'fm_grandtotal' => $this->input->post('TotalBayar2'),
            'fv_terbilang' => $this->input->post('terbilang'),
        );

        $id_penjualan = $this->M_penjualan->insert($data_penjualan);

        //echo 'post'.$this->input->post('kode_kelompok');
        foreach ($this->input->post('kode_kelompok') as $key => $value) {
            $data_detail_penjualan = array(
                'fn_nomor'    => 0,
                'fc_noinv' =>  $this->input->post('fc_noinv'),
                'fc_kdstock'      => $_POST['kode_barang'][$key],
                'fc_kdkelompok'             => $_POST['kode_kelompok'][$key],
                'fc_sts'       => 1,
                'fm_disc_rp'       => $_POST['diskon'][$key],
                'fn_berat' => $_POST['berat_emas'][$key],
                'ff_kadar' => $_POST['kadar_emas'][$key],
                'fm_ongkos' => $_POST['ongkoskirim'][$key],
                'fm_price'     => $_POST['harga_pergram'][$key],
                'fm_subtot'        => $_POST['sub_total'][$key]
            );

            $id_penjualan_detail = $this->M_penjualan->insert_detail($data_detail_penjualan);

            $kdstock = $_POST['kode_barang'][$key];
            $kondisi = '2';
            $this->M_penjualan->update_stsbrg($kondisi, $kdstock);


            //redirect('admin/Dashboard/datauserbaru');)
        }

        // echo "<script>
        // alert('Transaksi berhasil di simpan !!');
        // window.location.href = '" . base_url('C_penjualan/cetak_nota') . "';
        // </script>";
        redirect('C_penjualan/cetak_nota/' . $this->input->post('fc_noinv'));
    }

    public function cetak_nota($noinv)
    {
        $data['title'] = "Cetak Nota";
        $data['nota'] = $this->M_penjualan->query_nota($noinv);
        $data['barang'] = $this->M_penjualan->query_nota2($noinv);
        $this->load->view('admin/cetak_nota', $data);
    }
}
