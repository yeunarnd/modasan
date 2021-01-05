<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('M_menu');
        $this->load->model('M_barang');
        $this->load->model('M_barang_filter');
        $this->load->library('pagination');
        $this->load->library(array('upload','image_lib'));
        if(empty($this->session->userdata('fv_username'))){
			echo "<script>
                alert('Anda harus login terlebih dahulu');
                window.location.href = '".base_url('C_login')."';
            </script>";//Url tujuan
		}
    }

    public function index()
    {
        $data['title'] = "Barang";
        $data['tkd'] = $this->input->get('fc_kadar');
        $data['tkl'] = $this->input->get('fc_kdkelompok');
        $data['tlk'] = $this->input->get('fc_kdlokasi');
        $data['menu'] = $this->M_menu->get_menu();
        $data['barang'] = $this->M_barang->get_barang();
        $data['sales'] = $this->M_barang->get_sales();
        $data['sales2'] = $this->M_barang->get_sales();
        $data['kelompok'] = $this->M_barang->get_kelompok();
        $data['kelompok2'] = $this->M_barang->get_kelompok();
        $data['lokasi'] = $this->M_barang->get_lokasi();
        $data['lokasi2'] = $this->M_barang->get_lokasi();
        $data['jmlberat'] = $this->M_barang->jumlahberat();

        $data['kode_barcode'] = $this->randomString();

        $nota = $this->M_barang->max()->row();

        $kode = $nota->maxs;
        //tampil data

        $urut = (int) substr($kode, 0, 5);

        $urut++;

        //$char = "BPB";

        $kode = sprintf("%05s", $urut);

        $data['kode_barang'] = $kode;

        //kelompok

        $kelompok = $this->M_barang->max_kelompok()->row();

        $kode_kelompok = $kelompok->maxs_kelompok;

        $urut_kelompok = (int) substr($kode_kelompok, 0, 3);

        $urut_kelompok++;

        $kode_kelompok = sprintf("%03s", $urut_kelompok);

        $data['kode_kelompok'] = $kode_kelompok;

        //lokasi
        $lokasi = $this->M_barang->max_lokasi()->row();

        $kode_lokasi = $lokasi->maxs_lokasi;

        $urut_lokasi = (int) substr($kode_lokasi, 0, 2);

        $urut_lokasi++;

        $kode_lokasi = sprintf("%02s", $urut_lokasi);

        $data['kode_lokasi'] = $kode_lokasi;
        $data['barang'] = $this->M_barang->get_barang_all();
        //print_r($this->db->last_query());

        //$data['pagination'] = $this->pagination->create_links();


        //load view pelanggan view
        //if ($r == '1' || $c == '1' || $u == '1' || $d == '1') {

        $this->load->view('admin/v_barang', $data);
        //}	
    }

    public function ajax_list() {
        $list = $this->M_barang->get_datatables();
        
		$data = array();
		$no = $_REQUEST['start'];
		foreach ($list as $barang) {
			if($barang->f_foto==''){ $cover = 'no_image.jpg'; }else{ $cover = $barang->f_foto; }
			$row2 = '<img src="'.base_url().'assets/img/foto_barang/new/'.$cover.'" style="height: 500px; width: 600px;">';
			$no++;
            $row = array();
            $row[] =  '<input type="checkbox" class="check-item" name="id" id="id" value="'.$barang->fn_id.'">';
			$row[] = $no;
            $row[] = $barang->fc_barcode;
            $row[] = $barang->fc_kdstock;
            $row[] = $barang->fv_nmbarang;
            $row[] = $barang->fv_nmkelompok;
            $row[] = $barang->fv_nmlokasi;
            $row[] = $barang->ff_berat;
            $row[] = $barang->fc_kadar;
            $row[] = $barang->tanggal;
			$row[] = '
					  <a href="#modal-table'.$barang->fn_id.'" data-toggle="modal" class="tooltip-success" data-rel="tooltip" title="Edit">
						<span class="green">
							<i class="ace-icon fa fa-eye bigger-120"></i>
						</span>
					  </a>
					  <div id="modal-table'.$barang->fn_id.'" class="modal fade" tabindex="-1">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header no-padding">
									<div class="table-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
										<span class="white">&times;</span>
									</button>
									Gambar
									</div>
								</div>

								<div class="modal-body no-padding">
								<div align="center">
									'.$row2.'
								</div>		
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
						</div>	
					 ';
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_REQUEST['draw'],
						"recordsTotal" => $this->M_barang->count_all(),
						"recordsFiltered" => $this->M_barang->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
    }
    

    public function ajax_listall3($id_blok, $id_blok2, $id_blok3){
       // echo 'id_block2'.$id_blok2;
        if ($id_blok==0) {
            $id_blok="";
        }
    
        if ($id_blok2==0) {
            $id_blok2="";
        }
    
        if ($id_blok3==0) {
            $id_blok3="";
        }
    
        $list = $this->M_barang_filter->get_datatablesid($id_blok, $id_blok2, $id_blok3);
       // print_r($this->db->last_query());
        $data = array();
        $no = $_REQUEST['start'];
        foreach ($list as $barang) {
           
            if($barang->f_foto==''){ $cover = 'no_image.jpg'; }else{ $cover = $barang->f_foto; }
			$row2 = '<img src="'.base_url().'assets/img/foto_barang/new/'.$cover.'" style="height: 500px; width: 600px;">';
			$no++;
            $row = array();
            $row[] =  '<input type="checkbox" class="check-item" name="id" id="id" value="'.$barang->fn_id.'">';
			$row[] = $no;
            $row[] = $barang->fc_barcode;
            $row[] = $barang->fc_kdstock;
            $row[] = $barang->fv_nmbarang;
            $row[] = $barang->fv_nmkelompok;
            $row[] = $barang->fv_nmlokasi;
            $row[] = $barang->ff_berat;
            $row[] = $barang->fc_kadar;
            $row[] = $barang->tanggal;
			$row[] = '
					  <a href="#modal-table'.$barang->fn_id.'" data-toggle="modal" class="tooltip-success" data-rel="tooltip" title="Edit">
						<span class="green">
							<i class="ace-icon fa fa-eye bigger-120"></i>
						</span>
					  </a>
					  <div id="modal-table'.$barang->fn_id.'" class="modal fade" tabindex="-1">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header no-padding">
									<div class="table-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
										<span class="white">&times;</span>
									</button>
									Gambar
									</div>
								</div>

								<div class="modal-body no-padding">
								<div align="center">
									'.$row2.'
								</div>		
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
						</div>	
					';
           
            $data[] = $row;
        }
    
        $output = array(
                        "draw" => $_REQUEST['draw'],
                        "recordsTotal" => $this->M_barang_filter->count_allid($id_blok, $id_blok2,$id_blok3),
                        "recordsFiltered" => $this->M_barang_filter->count_filteredid($id_blok, $id_blok2,$id_blok3),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function max_kode($kode_lokasi, $kode_kelompok){
        $data = $this->M_barang->where_max_barang($kode_lokasi, $kode_kelompok)->row();
        //print_r($this->db->last_query());
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
    }

    public function max_kode_kelompok() {
        $data = $this->M_barang->where_max_kelompok()->row();
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
    }

    public function max_kode_lokasi(){
        $data = $this->M_barang->where_max_lokasi()->row();
        $json['maxs'] = @$data->maxs;
        echo json_encode($json);
    }

    public function save_nmkelompok()
    {
        $save_kelompok = $this->form_validation->set_rules('');

        $save_kelompok->save_namakelompok();
        // $this->session->set_flashdata('success', '<div class="alert alert-success" role="alert">Data Produk Berhasil Disimpan :)</div>');
        // redirect('');

        // echo "<script>
        //     alert('Data sales berhasil di tambahkan');
        //     window.location.href = '" . base_url('C_barang') . "';
        // </script>"; //Url tujuan
    }

    public function save_barang()
    {

        $post = $this->input->post();

        if ($post['fn_id'] == '') {
            $this->fd_date = $post['fd_date'];
            $this->fc_barcode = $post['fc_barcode'];
            $this->fc_kdstock = $post['fc_kdstock'];
            $this->fv_nmbarang = $post['fv_nmbarang'];
            $this->fc_kdkelompok = $post['fc_kdkelompok'];
            $this->fc_kdlokasi = $post['fc_kdlokasi'];
            // $this->fc_salesid = null;
            $this->ff_berat = $post['ff_berat'];
            $this->fc_kadar = $post['fc_kadar'];
            $this->fm_ongkos = $post['fm_ongkos'];

            $idlokasi = explode("-", $post['fc_kdlokasi']); 
            // $this->fm_hargabeli = $post['fm_hargabeli'];
            // $this->fm_hargajual = $post['fm_hargajual'];
            //$this->f_foto = $this->uploadImage();
            // $this->fc_sts = $post['fc_sts'];
            // $this->fn_stock = $post['fn_stock'];
            $data['fd_date'] = $post['fd_date'];
            $data['fc_barcode'] = $post['fc_barcode'];
            $data['fc_kdstock'] = $post['fc_kdstock'];
            $data['fv_nmbarang'] = $post['fv_nmbarang'];
            $data['fc_kdkelompok'] = $post['fc_kdkelompok'];
            $data['fc_kdlokasi'] = $idlokasi[0];
            $data['ff_berat'] = $post['ff_berat'];
            $data['fc_kadar'] = $post['fc_kadar'];
            $data['fc_kondisi'] = 0;
            $data['fm_ongkos'] = $post['fm_ongkos'];

            $config['upload_path'] = realpath('assets/img/foto_barang');
            $config['allowed_types']        = '*';

            $new_name = 'fotobarang_'.time();
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if($this->upload->do_upload('f_foto')){
                $get_name = $this->upload->data();
					
					$this->image_lib->initialize(array(
						'image_library' => 'gd2',
						'source_image' => $_SERVER['DOCUMENT_ROOT'] . '/assets/img/foto_barang/' . $get_name['file_name'],
						'new_image' => $_SERVER['DOCUMENT_ROOT'] . '/assets/img/foto_barang/new',
						'maintain_ratio' => false,
						'create_thumb' => true,
						'quality' => '40%',
						'width' => 400,
						'height' => 300
                    ));
                    
                    if($this->image_lib->resize())
					{
						$output = '<h4>Thumb - hasil Resize</h4>';
						$output .= realpath('./assets/img/foto_barang/new/'.$get_name['raw_name'].'_thumb'.$get_name['file_ext']);
						$output .= '<h4 style="margin-top: 30px">Gambar Original</h4>';
						$output .= realpath('./assets/img/foto_barang/new/'.$get_name['file_name']);
						 
						//echo $data['output'] = $output;
						$data['f_foto'] = $get_name['raw_name'].'_thumb'.$get_name['file_ext'];

						unlink('assets/img/foto_barang/'.$get_name['file_name']);
					}
                
            }
           
            $this->db->insert('tm_stock', $data);
           // print_r($this->db->last_query());
            $this->session->set_flashdata('success', '<div class="alert alert-success" role="alert">Data Produk Berhasil Disimpan :)</div>');
            // redirect('');
            echo "<script>
                alert('Data Barang berhasil di tambahkan');
                window.location.href = '" . base_url('C_barang') . "';
            </script>"; //Url tujuan
        } else {
            $this->fd_date = $post['fd_date'];
            $this->fc_barcode = $post['fc_barcode'];
            $this->fc_kdstock = $post['fc_kdstock'];
            $this->fv_nmbarang = $post['fv_nmbarang'];
            $this->fc_kdkelompok = $post['fc_kdkelompok'];
            $this->fc_kdlokasi = $post['fc_kdlokasi'];
            // $this->fc_salesid = $post['fc_salesid'];
            $this->ff_berat = $post['ff_berat'];
            $this->fc_kadar = $post['fc_kadar'];
            $this->fm_ongkos = $post['fm_ongkos'];
            // $this->fm_hargabeli = $post['fm_hargabeli'];
            // $this->fm_hargajual = $post['fm_hargajual'];
            // $this->f_foto = $this->uploadImage();
            // $this->fc_sts = $post['fc_sts'];
            // $this->fn_stock = $post['fn_stock'];
            $idlokasi = explode("-", $post['fc_kdlokasi']);
            $data['fd_date'] = $post['fd_date'];
            $data['fc_barcode'] = $post['fc_barcode'];
            $data['fc_kdstock'] = $post['fc_kdstock'];
            $data['fv_nmbarang'] = $post['fv_nmbarang'];
            $data['fc_kdkelompok'] = $post['fc_kdkelompok'];
            $data['fc_kdlokasi'] = $idlokasi[0];
            $data['ff_berat'] = $post['ff_berat'];
            $data['fc_kadar'] = $post['fc_kadar'];
            $data['fc_kondisi'] = 0;
            $data['fm_ongkos'] = $post['fm_ongkos'];

            

            $config['upload_path'] = realpath('assets/img/foto_barang');
            $config['allowed_types']        = '*';

            $new_name = 'fotobarang_'.time();
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if($this->upload->do_upload('f_foto')){
               // echo 'ora';
               $get_name = $this->upload->data();
					
               $this->image_lib->initialize(array(
                   'image_library' => 'gd2',
                   'source_image' => $_SERVER['DOCUMENT_ROOT'] . '/assets/img/foto_barang/' . $get_name['file_name'],
                   'new_image' => $_SERVER['DOCUMENT_ROOT'] . '/assets/img/foto_barang/new',
                   'maintain_ratio' => false,
                   'create_thumb' => true,
                   'quality' => '40%',
                   'width' => 400,
                   'height' => 300
               ));
               
               if($this->image_lib->resize())
               {
                   $output = '<h4>Thumb - hasil Resize</h4>';
                   $output .= realpath('./assets/img/foto_barang/new/'.$get_name['raw_name'].'_thumb'.$get_name['file_ext']);
                   $output .= '<h4 style="margin-top: 30px">Gambar Original</h4>';
                   $output .= realpath('./assets/img/foto_barang/new/'.$get_name['file_name']);
                    
                   //echo $data['output'] = $output;
                   $data['f_foto'] = $get_name['raw_name'].'_thumb'.$get_name['file_ext'];

                   unlink('assets/img/foto_barang/'.$get_name['file_name']);
               }
            } 

            // $this->fc_kondisi = 0;
            $this->db->update('tm_stock', $data, array('fn_id' => $post['fn_id']));
            echo "<script>
                alert('Data Barang berhasil di update');
                window.location.href = '" . base_url('C_barang') . "';
            </script>"; //Url tujuan
        }
        

    }

    public function cetak_barcode()
    {
        $nama_toko = $this->M_barang->get_nama_toko();
        $data['nama_tokone'] = $nama_toko->fc_isi;
        $data['barcode'] = $this->input->post('fc_barcode2');
        $data['kode_stock'] = $this->input->post('fc_kdstock2');
        $data['berat'] = $this->input->post('ff_berat2');
        $data['kadar'] = $this->input->post('fc_kadar2');
        $data['nama_barang'] = $this->input->post('fv_nmbarang2');
        $data['kelompok'] = $this->input->post('fc_kdkelompok2');
        $data['lokasi'] = $this->input->post('fc_kdlokasi2');
        $this->load->view('admin/v_barcode', $data);
    }

    public function get_barcode()
    {
        echo $this->randomString();
    }

    function randomString($length = 10)
    {
        $str = "";
        $characters = array_merge(range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str  .= $characters[$rand];
        }
        return $str;
    }

    public function update_barang()
    {

        $save_barang = $this->M_barang;
        $save_barang->update_barang();
        // $this->session->set_flashdata('success', '<div class="alert alert-success" role="alert">Data Produk Berhasil Disimpan :)</div>');
        // redirect('');
        echo "<script>
            alert('Data Barang berhasil di ubah');
            window.location.href = '" . base_url('C_barang') . "';
        </script>"; //Url tujuan

    }

    public function edit($id)
    {
        $data = $this->M_barang->get_by_id($id);
        echo json_encode($data);
    }

    public function get_edit_kelompok($id)
    {
        $data = $this->M_barang->get_edit_kelompok($id);
        echo json_encode($data);
    }

    public function get_edit_lokasi($id)
    {
        $data = $this->M_barang->get_edit_lokasi($id);
        echo json_encode($data);
    }

    public function delete()
    {
        foreach ($_POST['id'] as $id) {
            $this->M_barang->delete($id);
        }
        return redirect('C_barang/index');
    }

    public function diambil($id)
    {
        $kondisi = 1;
        $this->M_barang->update_kondisibrg($kondisi, $id);
        echo json_encode(array("status" => TRUE));
        //return redirect('C_barang');
    }

    public function save_kelompok()
    {

        $save_kelompok = $this->M_barang;
        $save_kelompok->save_kelompok();
        // $this->session->set_flashdata('success', '<div class="alert alert-success" role="alert">Data Produk Berhasil Disimpan :)</div>');
        // redirect('');
        echo "<script>
            alert('Data kelompok berhasil di tambahkan');
            window.location.href = '" . base_url('C_barang') . "';
        </script>"; //Url tujuan
    }

    public function save_lokasi()
    {

        $save_lokasi = $this->M_barang;
        $save_lokasi->save_lokasi();
        // $this->session->set_flashdata('success', '<div class="alert alert-success" role="alert">Data Produk Berhasil Disimpan :)</div>');
        // redirect('');
        echo "<script>
            alert('Data lokasi berhasil di tambahkan');
            window.location.href = '" . base_url('C_barang') . "';
        </script>"; //Url tujuan
    }


    public function filter()
    {
        $data['title'] = "Barang";
        $data['menu'] = $this->M_menu->get_menu();
        $data['barang'] = $this->M_barang->get_barang();
        $data['sales'] = $this->M_barang->get_sales();
        $data['sales2'] = $this->M_barang->get_sales();
        $data['kelompok'] = $this->M_barang->get_kelompok();
        $data['kelompok2'] = $this->M_barang->get_kelompok();
        $data['lokasi'] = $this->M_barang->get_lokasi();
        $data['lokasi2'] = $this->M_barang->get_lokasi();


        //konfigurasi pagination
        $config['base_url'] = site_url('C_barang/index'); //site url
        $config['total_rows'] = $this->db->count_all('tm_stock'); //total row
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
        $data['barang'] = $this->M_barang->filternew($config["per_page"], $data['page']);
        // $data['barang'] = $this->M_barang->filter2($config["per_page"], $data['page']);
        // $data['barang'] = $this->M_barang->filter3($config["per_page"], $data['page']);
        // $data['barang'] = $this->M_barang->filter4($config["per_page"], $data['page']);
        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('admin/v_barang', $data);
    }

    public function Barcode($code)
    {
        $this->load->library('Zend');
        $this->zend->load('Zend/Barcode');
        Zend_Barcode::render('code128', 'image', array(
            'text' => $code,
            'fontSize' => 10,
            'barThickWidth' => 5,
            'barHeight' => 25,
            'drawText' => true
        ), array());
    }

    public function ajax_get_kelompok()
    {
        echo json_encode($this->M_barang->ajax_get_kelompok()->result_array());
    }

    public function ajax_get_lokasi()
    {
        echo json_encode($this->M_barang->ajax_get_lokasi()->result_array());
    }

    public function ajax_add_kelompok()
    {

        if ($this->input->post('fn_id') == '') {
            $data = array(

                'fc_kdkelompok' => $this->input->post('fc_kdkelompok'),
                'fv_nmkelompok' => $this->input->post('fv_nmkelompok'),
            );

            $this->M_barang->add_kelompok($data);
            echo json_encode(array('status' => TRUE));
        } else {
            $data = array(

                'fc_kdkelompok' => $this->input->post('fc_kdkelompok'),
                'fv_nmkelompok' => $this->input->post('fv_nmkelompok'),
            );
            $this->M_barang->update_kelompok(array('fn_id' => $this->input->post('fn_id')), $data);
            //print_r($this->db->last_query());
            echo json_encode(array("status" => TRUE));
        }
    }

    public function ajax_add_lokasi()
    {
        if ($this->input->post('fn_id') == '') {
            $data = array(

                'fc_kdlokasi' => $this->input->post('fc_kdlokasi'),
                'fv_nmlokasi' => $this->input->post('fv_nmlokasi'),
            );

            $this->M_barang->add_lokasi($data);
            echo json_encode(array('status' => TRUE));
        } else {
            $data = array(

                'fc_kdlokasi' => $this->input->post('fc_kdlokasi'),
                'fv_nmlokasi' => $this->input->post('fv_nmlokasi'),
            );
            $this->M_barang->update_lokasi(array('fn_id' => $this->input->post('fn_id')), $data);
            //print_r($this->db->last_query());
            echo json_encode(array("status" => TRUE));
        }
    }

    public function ajax_delete_kelompok($id)
    {
        $this->M_barang->delete_by_id_kelompok($id);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete_lokasi($id)
    {
        $this->M_barang->delete_by_id_lokasi($id);
        echo json_encode(array("status" => TRUE));
    }


    public function kadar()
    {
        $barang = $this->M_barang->data_barang();
        $kadar = $_GET['kadar'];
        if ($kadar == 0) {
            $barang = $this->db->get('tm_stock', array('fc_kondisi' => 0))->result();
        } else {
            $barang = $this->db->get_where('tm_stock', ['fc_kadar' => $kadar, 'fc_kondisi' => 0])->result();
        }
    }

    public function kelompok()
    {
        $barang = $this->M_barang->data_barang();
        $kelompok = $_GET['kelompok'];
        if ($kelompok == 0) {
            $barang = $this->db->get('tm_stock', ['fc_kondisi' => 0])->result();
        } else {
            $barang = $this->db->get_where('tm_stock', ['fc_kdkelompok' => $kelompok, 'fc_kondisi' => 0])->result();
        }
    }

    public function lokasi($limit, $start)
    {
        $barang = $this->M_barang->data_barang();
        $lokasi = $_GET['lokasi'];
        if ($lokasi == 0) {
            $barang = $this->db->get_where('tm_stock', array('fc_kondisi' => 0), $limit, $start)->result();
        } else {
            $barang = $this->db->get_where('tm_stock', ['fc_kdlokasi' => $lokasi, 'fc_kondisi' => 0])->result();
        }
    }

    public function filterdata()
    {
        $data['title'] = "Barang";
        $data['kelompok2'] = $this->M_barang->get_kelompok();
        $data['lokasi2'] = $this->M_barang->get_lokasi();
        $data['jmlberat'] = $this->M_barang->jumlahberat();
        $data['barang'] = $this->M_barang->filterdata2();
        //$data['barang'] = $this->M_barang->filterdata2();
        $this->load->view('admin/v_barang', $data);
    }

    public function cobafilter()
    {
        $kadar = $this->input->get('fc_kadar');
        $kelompok = $this->input->get('fc_kdkelompok');
        $lokasi = $this->input->get('fc_kdlokasi');
        //if ($data) {
        $nota = $this->M_barang->max()->row();
        $data['sales'] = $this->M_barang->get_sales();
        $kode = $nota->maxs;
        //tampil data

        $urut = (int) substr($kode, 0, 5);

        $urut++;

        //$char = "BPB";

        $kode = sprintf("%05s", $urut);

        $data['kode_barang'] = $kode;
        $data['title'] = "filer barang";
        $data['kode_barcode'] = $this->randomString();
        $data['kelompok2'] = $this->M_barang->get_kelompok();
        $data['lokasi2'] = $this->M_barang->get_lokasi();
        $data['tkd'] = $this->input->get('fc_kadar');
        $data['tkl'] = $this->input->get('fc_kdkelompok');
        $data['tlk'] = $this->input->get('fc_kdlokasi');
        $data['jmlberat'] = $this->M_barang->jmlberat($kadar, $kelompok, $lokasi);
        //print_r($this->db->last_query());

        //$data['pagination'] = $this->pagination->create_links();
        $data['barang'] = $this->M_barang->filterdata($kadar, $kelompok, $lokasi);

        $this->load->view('admin/v_barang', $data);
    }
    public function echo()
    {
        $this->M_barang->get_count();
    }
}
