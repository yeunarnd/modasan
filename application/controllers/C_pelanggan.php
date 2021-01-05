<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_pelanggan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->helper('form');
        $this->load->model('M_menu');
        $this->load->model('M_pelanggan');
        $this->load->model('M_barang');
        if (empty($this->session->userdata('fv_username'))) {
            echo "<script>
                alert('Anda harus login terlebih dahulu');
                window.location.href = '" . base_url('C_login') . "';
            </script>"; //Url tujuan
        }
    }


    public function index()
    {
        $data['title'] = "Pelanggan";
        $data['menu'] = $this->M_menu->get_menu();
        // $data['pelanggan'] = $this->M_pelanggan->get();
        // $this->load->view('admin/v_pelanggan', $data);

        $pelanggan = $this->M_pelanggan->max_pelanggan()->row();

        $kode_pelanggan = $pelanggan->maxs_pelanggan;

        $urut_pelanggan = (int) substr($kode_pelanggan, 4, 4);

        $urut_pelanggan++;

        $char = "PLG";

        $kode_pelanggan = $char . sprintf("%04s", $urut_pelanggan);

        $data['kode_pelanggan'] = $kode_pelanggan;

        //konfigurasi pagination
        $config['base_url'] = site_url('C_pelanggan/index'); //site url
        $config['total_rows'] = $this->db->count_all('tm_pelanggan'); //total row
        $config['per_page'] = 10;  //show record per halaman
        $config["uri_segment"] = 3;  // uri parameter
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        // Membuat Style pagination dengan Bootstrap
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';

        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        //panggil function list_pelanggan yang ada pada mmodel M_pelanggan 
        $data['pelanggan'] = $this->M_pelanggan->list_pelanggan($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();

        //load view pelanggan view
        $this->load->view('admin/v_pelanggan', $data);
    }

    public function save()
    {
        $validasi = $this->form_validation->set_rules('fc_kdpel', 'id pelanggan', 'required|is_unique[tm_pelanggan.fc_kdpel]', [
            'is_unique' => 'Kode sudah ada',
            'required' => 'Nama Tidak Boleh Kosong'
        ]);
        $validasi = $this->form_validation->set_rules('fv_nmpelanggan', 'nama', 'required', [
            'required' => 'Nama Tidak boleh kosong'
        ]);

        $save_pelanggan = $this->M_pelanggan;
        if ($validasi->run() == true) {
            $save_pelanggan->save_pelanggan();
            // $this->session->set_flashdata('success', '<div class="alert alert-success" role="alert">Data Produk Berhasil Disimpan :)</div>');
            // redirect('');
            echo "<script>
            alert('Data pelanggan berhasil di tambahkan');
            window.location.href = '" . base_url('C_pelanggan') . "';
        </script>"; //Url tujuan

        }
    }

    function delete($id)
    {
        $this->M_pelanggan->delete($id);
        echo json_encode(array("status" => TRUE));
        //return redirect('C_pelanggan/index');
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

        $update_pelanggan = $this->M_pelanggan;
        // if ($validasi->run() == true) {
        $update_pelanggan->update_pelanggan();
        echo "<script>
            alert('Data pelanggan berhasil di ubah');
            window.location.href = '" . base_url('C_pelanggan') . "';
        </script>"; //Url tujuan
        //}
    }

    public function ajax_edit2($id)
    {
        $data = $this->M_pelanggan->get_by_id2($id);
        echo json_encode($data);
    }

    public function view()
    {
        $data['sales'] = $this->M_pelanggan->get();
        $data['sales3'] = $this->M_pelanggan->get();
        $data['jabatan'] = $this->M_pelanggan->get_jabatan();
        $this->load->view('tambahan/v_tablesales', $data);
    }

    public function search()
    {
        $keyword = $this->input->post('keyword');
        $data = $this->M_pelanggan->search_pelanggan($keyword);

        $hasil = $this->load->view('tambahan/v_tablesales', array('t_sales' => $data), true);

        // Buat sebuah array
        $callback = array(
            'hasil' => $hasil, // Set array hasil dengan isi dari view.php yang diload tadi
        );
        echo json_encode($callback); // konversi varibael $callback menjadi JSON
    }
}
