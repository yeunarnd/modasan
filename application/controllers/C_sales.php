<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_sales extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('M_menu');
        $this->load->model('M_sales');
        $this->load->model('M_barang');
        $this->load->library('pagination');
        if (empty($this->session->userdata('fv_username'))) {
            echo "<script>
                alert('Anda harus login terlebih dahulu');
                window.location.href = '" . base_url('C_login') . "';
            </script>"; //Url tujuan
        }
    }


    public function index()
    {
        $data['title'] = "Sales";
        $data['menu'] = $this->M_menu->get_menu();
        //$data['idsales'] = $this->db->get_where('t_sales', ['fc_salesid' => $id_sales])->row_array();
        // $data['sales'] = $this->M_sales->get();
        // $data['sales3'] = $this->M_sales->get();
        $data['jabatan'] = $this->M_sales->get_jabatan();
        $data['jabatan2'] = $this->M_sales->get_jabatan();

        $sales = $this->M_sales->max_sales()->row();

        $kode_sales = $sales->maxs_sales;

        $urut_sales = (int) substr($kode_sales, 4, 2);

        $urut_sales++;

        $char = "SLS";

        $kode_sales = $char . sprintf("%02s", $urut_sales);
        $data['kode_sales'] = $kode_sales;
        $data['sales'] = $this->M_sales->list_sales();

        $this->load->view('admin/v_sales', $data);
    }

    public function save()
    {
        $validasi = $this->form_validation->set_rules('fc_salesid', 'id sales', 'required|is_unique[t_sales.fc_salesid]', [
            'is_unique' => 'Kode sudah ada',
            'required' => 'Nama Tidak Boleh Kosong'
        ]);
        $validasi = $this->form_validation->set_rules('fv_nama', 'nama', 'required', [
            'required' => 'Nama Tidak boleh kosong'
        ]);

        $save_sales = $this->M_sales;
        if ($validasi->run() == true) {
            $save_sales->save_sales();
            // $this->session->set_flashdata('success', '<div class="alert alert-success" role="alert">Data Produk Berhasil Disimpan :)</div>');
            // redirect('');
            echo "<script>
            alert('Data sales berhasil di tambahkan');
            window.location.href = '" . base_url('C_sales') . "';
        </script>"; //Url tujuan

        }
    }

    public function update()
    {
        // $validasi = $this->form_validation->set_rules('fc_salesid', 'id sales', 'required|is_unique[t_sales.fc_salesid]', [
        //     'is_unique' => 'Kode sudah ada',
        //     'required' => 'Nama Tidak Boleh Kosong'
        // ]);
        // $validasi = $this->form_validation->set_rules('fv_nama', 'nama', 'required', [
        //     'required' => 'Nama Tidak boleh kosong'
        // ]);

        $update_sales = $this->M_sales;
        // if ($validasi->run() == true) {
        $update_sales->update_sales();
        echo "<script>
            alert('Data sales berhasil di ubah');
            window.location.href = '" . base_url('C_sales') . "';
        </script>"; //Url tujuan
        //}
    }

    public function delete($id)
    {
        $this->M_sales->delete($id);
        echo json_encode(array("status" => TRUE));
        //return redirect('C_sales');
    }

    public function ajax_edit($id)
    {
        $data = $this->M_sales->get_by_id2($id);
        echo json_encode($data);
    }

    public function view()
    {
        $data['sales'] = $this->M_sales->get();
        $data['sales3'] = $this->M_sales->get();
        $data['jabatan'] = $this->M_sales->get_jabatan();
        $this->load->view('tambahan/v_tablesales', $data);
    }

    public function search()
    {
        if ($this->input->post('')) {
            $data['search'] = $this->input->post('search');
        }
        $this->load->view('tambahan/v_tablesales');
    }
}
