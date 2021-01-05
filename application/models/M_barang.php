<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_barang extends CI_Model
{
    private $tabel = "tm_stock";
    private $tbsales = "t_sales";
    private $tbkelompok = "tm_kelompok";
    private $tblokasi = "tm_lokasi";

    var $table_barang = 'tm_stock';
	var $column_order = array('a.fn_id','a.fc_kdstock','a.fc_barcode','a.fv_nmbarang','a.ff_berat','a.fc_kadar',null); //set column field database for datatable orderable
	var $column_search = array('a.fn_id','a.fc_kdstock','a.fc_barcode','a.fv_nmbarang','a.ff_berat','a.fc_kadar'); //set column field database for datatable searchable just title , author , category are searchable
    var $order = array('a.fn_id' => 'asc'); // default order
    
    private function _get_datatables_query() {
        $this->db->select('a.fn_id, a.fc_kdstock, a.fv_nmbarang, b.fv_nmkelompok, c.fv_nmlokasi, a.ff_berat, a.fc_kadar, a.fm_hargabeli, d.fv_nama, a.fc_sts, a.fd_date, a.fc_barcode, a.f_foto, DATE_FORMAT(a.fd_date, "%d-%m-%Y") as tanggal');

        $this->db->from('tm_stock a');

        $this->db->join('tm_kelompok b', 'a.fc_kdkelompok = b.fc_kdkelompok', 'left outer');

        $this->db->join('tm_lokasi c', 'a.fc_kdlokasi = c.fc_kdlokasi', 'left outer');

        $this->db->join('t_sales d', 'a.fc_salesid = d.fc_salesid', 'left outer');

        $this->db->where('fc_kondisi', 0);
		$i = 0;
		foreach ($this->column_search as $item) {
			if ($_REQUEST['search']["value"]) {
				if ($i===0) {
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_REQUEST['search']["value"]);
				} else {
					$this->db->or_like($item, $_REQUEST['search']["value"]);
			}
			
			if (count($this->column_search) - 1 == $i)
				$this->db->group_end();
			}

			$i++;
		}

		if (isset($_REQUEST['order'])) {
			$this->db->order_by($this->column_order[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered() {
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all() {
		$this->db->from($this->table_barang);
		return $this->db->count_all_results();
	}

	public function get_datatables() {
		$this->_get_datatables_query();

		if ($_REQUEST['length'] != -1) {
			$this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		}

		$query = $this->db->get();
		return $query->result();
	}

    public function delete($id)
    {
        $this->db->where('fn_id', $id);
        $this->db->delete('tm_stock');
    }

    public function get_count()
    {
        $query = $this->db->query("SELECT * FROM tm_stock where fc_kondisi = 0");
        return $query->num_rows();
        // $this->db->select('count(fn_id) as count');
        // $this->db->from('tm_stock');
        // $this->db->where('fc_kondisi', 0);
        // return $this->db->get()->row();
    }

    public function get_barang_all()
    {

        $this->db->select('tm_stock.fn_id, tm_stock.fc_kdstock, tm_stock.fv_nmbarang, tm_kelompok.fv_nmkelompok, tm_lokasi.fv_nmlokasi, tm_stock.ff_berat, tm_stock.fc_kadar, tm_stock.fm_hargabeli, t_sales.fv_nama, tm_stock.fc_sts, tm_stock.fd_date');

        $this->db->from('tm_stock', 'tm_kelompok', 'tm_lokasi', 't_sales', 'left outer');

        $this->db->join('tm_kelompok', 'tm_kelompok.fc_kdkelompok = tm_stock.fc_kdkelompok', 'left outer');

        $this->db->join('tm_lokasi', 'tm_lokasi.fc_kdlokasi = tm_stock.fc_kdlokasi', 'left outer');

        $this->db->join('t_sales', 't_sales.fc_salesid = tm_stock.fc_salesid', 'left outer');

        $this->db->where('fc_kondisi', 0);

        $query = $this->db->get();
        return $query->result();
    }

    public function get_barang()
    {
        return $this->db->get($this->tabel)->result();
    }

    public function get_sales()
    {
        return $this->db->get($this->tbsales)->result();
    }

    public function update_kondisibrg($kondisi, $id)
    {
        $this->db->query("UPDATE `tm_stock` SET `fc_kondisi`= '$kondisi' WHERE tm_stock.fn_id='$id'");
    }

    public function jumlahberat()
    {
        $this->db->select_sum('ff_berat');
        $this->db->from('tm_stock');
        $this->db->where('fc_kondisi', 0);
        return $this->db->get()->row();
    }

    public function get_by_id($id)
    {
        $this->db->select('tm_stock.fd_date, tm_stock.fc_barcode, tm_stock.fc_kdstock, tm_stock.fv_nmbarang, tm_stock.fc_kdkelompok, tm_stock.fc_kdlokasi, tm_lokasi.fv_nmlokasi, tm_stock.ff_berat, tm_stock.fc_kadar, tm_stock.fc_kondisi, tm_stock.fm_ongkos, tm_stock.fn_id, tm_stock.f_foto');
        $this->db->where('tm_stock.fn_id', $id);
        $this->db->join('tm_lokasi','tm_stock.fc_kdlokasi=tm_lokasi.fc_kdlokasi','left outer');
        return $this->db->get('tm_stock')->row();
    }

    public function get_edit_kelompok($id)
    {
        $this->db->where('fn_id', $id);
        return $this->db->get('tm_kelompok')->row();
    }

    public function get_edit_lokasi($id)
    {
        $this->db->where('fn_id', $id);
        return $this->db->get('tm_lokasi')->row();
    }

    public function get_lokasi()
    {
        return $this->db->get($this->tblokasi)->result();
    }
    public function get_kelompok()
    {
        return $this->db->get($this->tbkelompok)->result();
    }

    public function list_barang($limit, $start)
    {

        $this->db->select('tm_stock.fn_id, tm_stock.fc_kdstock, tm_stock.fv_nmbarang, tm_kelompok.fv_nmkelompok, tm_lokasi.fv_nmlokasi, tm_stock.ff_berat, tm_stock.fc_kadar, tm_stock.fm_hargabeli, t_sales.fv_nama, tm_stock.fc_sts, tm_stock.fd_date');

        $this->db->from('tm_stock', 'tm_kelompok', 'tm_lokasi', 't_sales', 'left outer');

        $this->db->join('tm_kelompok', 'tm_kelompok.fc_kdkelompok = tm_stock.fc_kdkelompok', 'left outer');

        $this->db->join('tm_lokasi', 'tm_lokasi.fc_kdlokasi = tm_stock.fc_kdlokasi', 'left outer');

        $this->db->join('t_sales', 't_sales.fc_salesid = tm_stock.fc_salesid', 'left outer');

        $this->db->where('fc_kondisi', 0);

        $query = $this->db->get();

        return $query->result();
    }

    public function view_barang()
    {
        $this->db->select('*');
        $this->db->from('tm_stock');
        $this->db->where('fc_kondisi', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function data_barang()
    {
        $this->db->select('*');
        $this->db->from('tm_stock');
        $this->db->where('fc_kondisi', 0);
        $query = $this->db->get_where();
        return $query->result();
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
            // $this->fm_hargabeli = $post['fm_hargabeli'];
            // $this->fm_hargajual = $post['fm_hargajual'];
            //$this->f_foto = $this->uploadImage();
            // $this->fc_sts = $post['fc_sts'];
            // $this->fn_stock = $post['fn_stock'];
            $config['upload_path'] = realpath('assets/img/foto_barang');
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size'] = '5000000';
            $config['max_width'] = '2024';
            $config['max_height']= '1468';

            $new_name = 'fotobarang_'.time();
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if(!$this->upload->do_upload('f_foto')){
                $data = array(
                    'fd_date' => $post['fd_date'],
                    'fc_barcode' => $post['fc_barcode'],
                    'fc_kdstock' => $post['fc_kdstock'],
                    'fv_nmbarang' => $post['fv_nmbarang'],
                    'fc_kdkelompok' => $post['fc_kdkelompok'],
                    'fc_kdlokasi' => $post['fc_kdlokasi'],
                    'ff_berat' => $post['ff_berat'],
                    'fc_kadar' => $post['fc_kadar'],
                    'fm_ongkos' => $post['fm_ongkos']
                );
            }else{ 
                $get_name = $this->upload->data();
                $nama_foto = $get_name['file_name'];
                $gambar1 = $nama_foto;

                $data = array(
                    'fd_date' => $post['fd_date'],
                    'fc_barcode' => $post['fc_barcode'],
                    'fc_kdstock' => $post['fc_kdstock'],
                    'fv_nmbarang' => $post['fv_nmbarang'],
                    'fc_kdkelompok' => $post['fc_kdkelompok'],
                    'fc_kdlokasi' => $post['fc_kdlokasi'],
                    'ff_berat' => $post['ff_berat'],
                    'fc_kadar' => $post['fc_kadar'],
                    'fm_ongkos' => $post['fm_ongkos'],
                    'f_foto' => $gambar1
                );
            }    
            $this->fc_kondisi = 0;
            $this->db->insert($this->tabel, $this);
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

            $config['upload_path'] = realpath('assets/img/foto_barang');
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size'] = '5000000';
            $config['max_width'] = '2024';
            $config['max_height']= '1468';

            $new_name = 'fotobarang_'.time();
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if(!$this->upload->do_upload('f_foto')){
                echo 'ora';
                $data = array(
                    'fd_date' => $post['fd_date'],
                    'fc_barcode' => $post['fc_barcode'],
                    'fc_kdstock' => $post['fc_kdstock'],
                    'fv_nmbarang' => $post['fv_nmbarang'],
                    'fc_kdkelompok' => $post['fc_kdkelompok'],
                    'fc_kdlokasi' => $post['fc_kdlokasi'],
                    'ff_berat' => $post['ff_berat'],
                    'fc_kadar' => $post['fc_kadar'],
                    'fm_ongkos' => $post['fm_ongkos']
                );
            }else{ 
                echo 'iso';
                $get_name = $this->upload->data();
                $nama_foto = $get_name['file_name'];
                $gambar1 = $nama_foto;

                $data = array(
                    'fd_date' => $post['fd_date'],
                    'fc_barcode' => $post['fc_barcode'],
                    'fc_kdstock' => $post['fc_kdstock'],
                    'fv_nmbarang' => $post['fv_nmbarang'],
                    'fc_kdkelompok' => $post['fc_kdkelompok'],
                    'fc_kdlokasi' => $post['fc_kdlokasi'],
                    'ff_berat' => $post['ff_berat'],
                    'fc_kadar' => $post['fc_kadar'],
                    'fm_ongkos' => $post['fm_ongkos'],
                    'f_foto' => 'aa.jpg'
                );
            }    

            $this->fc_kondisi = 0;
            $this->db->update('tm_stock', $this, array('fn_id' => $post['fn_id']));
            print_r($this->db->last_query());
            return $this->db->affected_rows();
        }
    }

    public function save_namakelompok()
    {
        $post = $this->input->post();
        $this->fv_nmkelompok = $post['fv_nmkelompok'];

        $this->db->insert($this->tbkelompok, $this);
    }

    private function uploadImage()
    {
        $config['upload_path'] = './assets/img/foto_barang/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $nama_lengkap = $_FILES['f_foto']['name'];
        $config['file_name'] = $nama_lengkap;
        $config['overwrite'] = true;
        $config['max_size'] = 10240;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('f_foto')) {
            return $this->upload->data("file_name");
        }

        print_r($this->upload->display_errors());
    }

    public function update_barang()
    {
        $post = $this->input->post();
        $this->fn_id = $post['fn_id_edit'];
        $this->fd_date = $post['fd_date_edit'];
        // $this->fc_barcode = $post['fc_barcode'];
        $this->fc_kdstock = $post['fc_kdstock_edit'];
        $this->fv_nmbarang = $post['fv_nmbarang_edit'];
        $this->fc_kdkelompok = $post['fc_kdkelompok_edit'];
        $this->fc_kdlokasi = $post['fc_kdlokasi_edit'];
        $this->fc_salesid = $post['fc_salesid_edit'];
        $this->ff_berat = $post['ff_berat_edit'];
        $this->fc_kadar = $post['fc_kadar_edit'];
        $this->fm_ongkos = $post['fm_ongkos_edit'];
        $this->fm_hargabeli = $post['fm_hargabeli_edit'];
        $this->fm_hargajual = $post['fm_hargajual_edit'];
        if (!empty($_FILES["f_foto"]["name"])) {
            $this->f_foto = $this->uploadImage();
        } else {
            $this->f_foto = $post["f_foto_edit"];
        }
        $this->fc_sts = $post['fc_sts_edit'];
        $this->fn_stock = $post['fn_stock_edit'];
        $this->db->update($this->tabel, $this, array('fn_id' => $post['fn_id_edit']));
    }

    public function save_kelompok()
    {
        $post = $this->input->post();
        $this->fc_kdkelompok = $post['fc_kdkelompok'];
        $this->fv_nmkelompok = $post['fv_nmkelompok'];
        $this->db->insert($this->tbkelompok, $this);
    }

    public function save_lokasi()
    {
        $post = $this->input->post();
        $this->fc_kdlokasi = $post['fc_kdlokasi'];
        $this->fv_nmlokasi = $post['fv_nmlokasi'];
        $this->db->insert($this->tblokasi, $this);
    }

    public function getRole($id_admin, $spesifik, $idmenu)
    {
        $this->db->select($spesifik . ' as r');
        $this->db->where('fc_userid', $id_admin);
        $this->db->where('id_menu', $idmenu);
        // $this->db->where('password', $password);
        return $this->db->get('tab_akses_mainmenu')->result()[0];
        //  var_dump($this->db->last_query());die;
        //  return

    }
    public function filter($limit, $start)
    {
        $post = $this->input->get('refresh');
        $kadar = $this->input->get('fc_kadar');
        if (isset($kadar)) {
            //$kadar = $this->input->get('fc_kadar');
            $this->db->get_where('tm_stock', array('fc_kadar' => $kadar), $limit, $start);
        } else if ($this->input->post('refresh')) {
            $kelompok = $this->input->get('fc_kdkelompok');
            $this->db->get_where('tm_stock', array('fc_kdkelompok' => $kelompok), $limit, $start);
        }
        $lokasi = $this->input->get('fc_kdlokasi');
        if ($lokasi) {
            $this->db->where('fc_kdlokasi', $lokasi);
        }
        return $this->db->get('tm_stock', $limit, $start)->result();
        // $query = $this->db->get_where('tm_stock', array('fc_kadar' => $kadar, 'fc_kdkelompok' => $kelompok, 'fc_kdlokasi' => $lokasi), $limit, $start);
        // return $query->result();
    }

    public function filternew($limit, $start)
    {
        $kadar = $this->input->get('fc_kadar');
        $kelompok = $this->input->get('fc_kdkelompok');
        $lokasi = $this->input->get('fc_kdlokasi');
        $query = $this->db->get_where('tm_stock', array('fc_kadar' => $kadar, 'fc_kdkelompok' => $kelompok, 'fc_kdlokasi' => $lokasi), $limit, $start);
        return $query->result();
    }

    public function filter2($limit, $start)
    {
        if ($kadar = $this->input->get('fc_kadar')) {
            $query = $this->db->get_where('tm_stock', array('fc_kadar' => $kadar), $limit, $start);
            return $query->result();
        } else {
            $query = $this->db->get('tm_stock', $limit, $start);
            return $query->result();
        }
        if ($kelompok = $this->input->get('fc_kdkelompok')) {
            $query = $this->db->get_where('tm_stock', array('fc_kdkelompok' => $kelompok), $limit, $start);
            return $query->result();
        } else {
            $query = $this->db->get('tm_stock', $limit, $start);
            return $query->result();
        }
        if ($kelompok = $this->input->get('fc_kdkelompok')) {
            $query = $this->db->get_where('tm_stock', array('fc_kdkelompok' => $kelompok), $limit, $start);
            return $query->result();
        } else {
            $query = $this->db->get('tm_stock', $limit, $start);
            return $query->result();
        }
        $kadar = $this->input->get('fc_kadar');
        $kelompok = $this->input->get('fc_kdkelompok');
        $lokasi = $this->input->get('fc_kdlokasi');
        $query = $this->db->get_where('tm_stock', array('fc_kadar' => $kadar, 'fc_kdkelompok' => $kelompok, 'fc_kdlokasi' => $lokasi), $limit, $start);
        return $query->result();
    }

    // public function filter3($limit, $start)
    // {
    //     if ($kelompok = $this->input->get('fc_kdkelompok')) {
    //         $query = $this->db->get_where('tm_stock', array('fc_kdkelompok' => $kelompok), $limit, $start);
    //         return $query->result();
    //     } else {
    //         $query = $this->db->get('tm_stock', $limit, $start);
    //         return $query->result();
    //     }
    // }

    // public function filter4($limit, $start)
    // {
    //     if ($lokasi = $this->input->get('fc_kdlokasi')) {
    //         $query = $this->db->get_where('tm_stock', array('fc_kdlokasi' => $lokasi), $limit, $start);
    //         return $query->result();
    //     } else {
    //         $query = $this->db->get('tm_stock', $limit, $start);
    //         return $query->result();
    //     }
    // }

    public function getMenu($menu)
    {
        $this->db->where('link_menu', $menu);
        return $this->db->get('mainmenu')->row();
    }

    public function get_nama_toko()
    {
        $this->db->where('fc_param', 'NAMATOKO');
        return $this->db->get('t_setup')->row();
    }

    function max()
    {
        return $this->db->query('SELECT max(fc_kdstock) AS maxs FROM tm_stock');
    }

    function max_kelompok()
    {
        return $this->db->query('SELECT max(fc_kdkelompok) AS maxs_kelompok FROM tm_kelompok');
    }

    function where_max_kelompok() {
        return $this->db->query('SELECT max(fc_kdkelompok) AS maxs FROM tm_kelompok');
    }

    function where_max_lokasi(){
        return $this->db->query('SELECT max(fc_kdlokasi) AS maxs FROM tm_lokasi');
    }

    function max_lokasi()
    {
        return $this->db->query('SELECT max(fc_kdlokasi) AS maxs_lokasi FROM tm_lokasi');
    }

    function ajax_get_kelompok()
    {
        return $this->db->get('tm_kelompok');
    }

    function ajax_get_lokasi()
    {
        return $this->db->get('tm_lokasi');
    }

    function add_kelompok($data)
    {
        $this->db->insert('tm_kelompok', $data);
        return $this->db->insert_id();
    }

    function add_lokasi($data)
    {
        $this->db->insert('tm_lokasi', $data);
        return $this->db->insert_id();
    }

    function update_kelompok($where, $data)
    {
        $this->db->update('tm_kelompok', $data, $where);
        return $this->db->affected_rows();
    }

    function update_lokasi($where, $data)
    {
        $this->db->update('tm_lokasi', $data, $where);
        return $this->db->affected_rows();
    }

    function delete_by_id_kelompok($id)
    {
        $this->db->where('fn_id', $id);
        $this->db->delete('tm_kelompok');
    }

    function delete_by_id_lokasi($id)
    {
        $this->db->where('fn_id', $id);
        $this->db->delete('tm_lokasi');
    }

    public function filterdata($kadar = null, $kelompok = null, $lokasi = null)
    {

        $this->db->select('tm_stock.fn_id, tm_stock.fc_kdkelompok, tm_stock.fc_kdlokasi, tm_stock.fc_salesid, tm_stock.fc_kdstock, tm_stock.fv_nmbarang, tm_kelompok.fv_nmkelompok, tm_lokasi.fv_nmlokasi, tm_stock.ff_berat, tm_stock.fc_kadar, tm_stock.fm_hargabeli, t_sales.fv_nama, tm_stock.fc_sts, tm_stock.fd_date');
        //$this->db->select_sum('ff_berat');
        //$this->db->from('tm_stock');



        $this->db->from('tm_stock', 'tm_kelompok', 'tm_lokasi', 't_sales', 'left outer');

        $this->db->join('tm_kelompok', 'tm_kelompok.fc_kdkelompok = tm_stock.fc_kdkelompok', 'left outer');

        $this->db->join('tm_lokasi', 'tm_lokasi.fc_kdlokasi = tm_stock.fc_kdlokasi', 'left outer');

        $this->db->join('t_sales', 't_sales.fc_salesid = tm_stock.fc_salesid', 'left outer');


        if ($kadar != "") {
            $this->db->where('fc_kadar', $kadar);
        }

        if ($kelompok != "") {
            $this->db->where('tm_stock.fc_kdkelompok', $kelompok);
        }

        if ($lokasi != "") {
            $this->db->where('tm_stock.fc_kdlokasi', $lokasi);
        }
        $this->db->where('fc_kondisi', 0);

        // $this->db->where('fc_kondisi', 0);
        // $this->db->or_like('fc_kdkelompok', $kelompok);
        // $this->db->where('fc_kondisi', 0);
        // $this->db->or_like('fc_kdlokasi', $lokasi);
        // $this->db->where('fc_kondisi', 0);
        return $this->db->get()->result();
    }

    public function jmlberat($kadar = null, $kelompok = null, $lokasi = null)
    {
        $this->db->select_sum('ff_berat');
        $this->db->from('tm_stock');
        $this->db->where('fc_kondisi', 0);
        if ($kadar != "") {
            $this->db->where('fc_kadar', $kadar);
        }

        if ($kelompok != "") {
            $this->db->where('fc_kdkelompok', $kelompok);
        }

        if ($lokasi != "") {
            $this->db->where('fc_kdlokasi', $lokasi);
        }
        return $this->db->get()->row();
    }

    public function where_max_barang($fc_kdlokasi, $fc_kdkelompok){
        return $this->db->query('SELECT fc_kdstock AS maxs FROM tm_stock where fc_kdlokasi="'.$fc_kdlokasi.'" and fc_kdkelompok="'.$fc_kdkelompok.'" order by fn_id desc limit 1 ');
    }

    // public function filterkk()
    // {
    //     $kadar = $this->input->get('fc_kadar');
    //     $kelompok = $this->input->get('fc_kdkelompok');
    //     // $lokasi = $this->input->get('fc_kdlokasi');
    //     // $array = array('fc_kadar' => $kadar, 'fc_kdkelompok' => $kelompok);
    //     $this->db->select('*');
    //     $this->db->from('tm_stock');
    //     $this->db->where('fc_kadar', $kadar);
    //     $this->db->where('fc_kondisi', 0);
    //     $this->db->like('fc_kdkelompok', $kelompok);
    //     $this->db->where('fc_kondisi', 0);
    //     return $this->db->get('')->result();
    // }

    // public function jmlberat2()
    // {
    //     $kadar = $this->input->get('fc_kadar');
    //     $kelompok = $this->input->get('fc_kdkelompok');
    //     $sql = $this->db->query("SELECT SUM(ff_berat) as berat FROM tm_stock WHERE fc_kondisi=0 AND fc_kadar = '$kadar' AND fc_kdkelompok = '$kelompok' AND fc_kondisi=0");
    //     return $sql->row()->berat;
    // }

    // public function filterkl()
    // {
    //     $kadar = $this->input->get('fc_kadar');
    //     //$kelompok = $this->input->get('fc_kdkelompok');
    //     $lokasi = $this->input->get('fc_kdlokasi');
    //     //$array = array('fc_kadar' => $kadar, 'fc_kdlokasi' => $lokasi);
    //     $this->db->select('*');
    //     $this->db->from('tm_stock');
    //     $this->db->where('fc_kadar', $kadar);
    //     $this->db->where('fc_kondisi', 0);
    //     $this->db->like('fc_kdlokasi', $lokasi);
    //     $this->db->where('fc_kondisi', 0);
    //     return $this->db->get('')->result();
    // }

    // public function jmlberat3()
    // {
    //     $kadar = $this->input->get('fc_kadar');
    //     $lokasi = $this->input->get('fc_kdlokasi');
    //     $sql = $this->db->query("SELECT SUM(ff_berat) as berat FROM tm_stock WHERE fc_kondisi=0 AND fc_kadar = '$kadar' AND fc_kdlokasi = '$lokasi' AND fc_kondisi=0");
    //     return $sql->row()->berat;
    // }

    // public function filterlk()
    // {
    //     //$kadar = $this->input->get('fc_kadar');
    //     $kelompok = $this->input->get('fc_kdkelompok');
    //     $lokasi = $this->input->get('fc_kdlokasi');
    //     //$array = array('fc_kdkelompok' => $kelompok, 'fc_kdlokasi' => $lokasi);
    //     $this->db->select('*');
    //     $this->db->from('tm_stock');
    //     $this->db->where('fc_kdkelompok', $kelompok);
    //     $this->db->where('fc_kondisi', 0);
    //     $this->db->like('fc_kdlokasi', $lokasi);
    //     $this->db->where('fc_kondisi', 0);
    //     return $this->db->get('')->result();
    // }

    // public function jmlberat4()
    // {
    //     $kelompok = $this->input->get('fc_kdkelompok');
    //     $lokasi = $this->input->get('fc_kdlokasi');
    //     $sql = $this->db->query("SELECT SUM(ff_berat) as berat FROM tm_stock WHERE fc_kondisi=0 AND fc_kdkelompok = '$kelompok' AND fc_kdlokasi = '$lokasi' AND fc_kondisi=0");
    //     return $sql->row()->berat;
    // }

    // public function filterdata2()
    // {
    //     $kadar = $this->input->get('fc_kadar');
    //     $kelompok = $this->input->get('fc_kdkelompok');
    //     $lokasi = $this->input->get('fc_kdlokasi');
    //     $array = array('fc_kdkelompok' => $kelompok, 'fc_kadar' => $kadar, 'fc_kdlokasi' => $lokasi);
    //     $this->db->select('*');
    //     $this->db->from('tm_stock');
    //     $this->db->like($array);
    //     $this->db->where('fc_kondisi', 0);
    //     return $this->db->get('')->result();
    // }

    // public function jmlberat5()
    // {
    //     $kadar = $this->input->get('fc_kadar');
    //     $kelompok = $this->input->get('fc_kdkelompok');
    //     $lokasi = $this->input->get('fc_kdlokasi');
    //     $sql = $this->db->query("SELECT SUM(ff_berat) as berat FROM tm_stock WHERE fc_kondisi=0 AND fc_kadar = '$kadar' AND fc_kdkelompok = '$kelompok' AND fc_kdlokasi = '$lokasi'");
    //     return $sql->row()->berat;
    // }
}
