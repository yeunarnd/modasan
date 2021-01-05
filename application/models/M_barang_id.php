<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_barang_id extends CI_Model
{
	var $table = 'tm_stock';
	var $column_orderid = array('a.fn_id', 'a.fd_date', 'a.fc_barcode', 'a.fc_kdstock', 'a.fv_nmbarang', null); //set column field database for datatable orderable
	var $column_searchid = array('a.fn_id', 'a.fd_date', 'a.fc_barcode', 'a.fc_kdstock', 'a.fv_nmbarang'); //set column field database for datatable searchable just title , author , category are searchable
	var $orderid = array('a.fn_id' => 'asc'); // default order

	public function get_datatablesid()
	{
		$this->_get_datatables_queryid();
		//	$this->db->where('orde_sungai',$id);

		if ($_REQUEST['length'] != -1) {
			$this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_queryid()
	{
		$this->db->select('a.fn_id,a.fd_date,a.fc_barcode,a.fc_kdstock,a.fv_nmbarang,a.fc_kdkelompok,b.fv_nmkelompok,a.fc_kdlokasi,c.fv_nmlokasi,a.ff_berat, a.fc_kadar,a.fm_ongkos,a.fm_hargabeli,a.fm_hargajual, a.f_foto');
		$this->db->from("tm_stock a");
		$this->db->join('tm_lokasi c', 'a.fc_kdlokasi=c.fc_kdlokasi', 'left outer');
		$this->db->join('tm_kelompok b', 'a.fc_kdkelompok=b.fc_kdkelompok', 'left outer');
		$this->db->where('a.fc_sts', 1);
		$this->db->where('a.fc_kondisi', 0);
		$i = 0;


		foreach ($this->column_searchid as $item) {
			if ($_POST['search']['value']) // if datatable send POST for search
			{

				if ($i === 0) // first loop
				{
					// $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_searchid) - 1 == $i); //last loop
				// $this->db->group_end(); //close bracket


			}

			$i++;
		}

		if (isset($_REQUEST['order'])) {
			$this->db->order_by($this->column_orderid[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
		} else if (isset($this->orderid)) {
			$order = $this->orderid;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filteredid()
	{
		$this->_get_datatables_queryid();
		//$this->db->where('orde_sungai',$id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function filter()
	{
		$kadar = $this->input->post('fc_kadar');
		$kelompok = $this->input->post('fc_kdkelompok');
		$lokasi = $this->input->post('fc_kdlokasi');
		$query = $this->db->query("SELECT * FROM tm_stock WHERE fc_kadar = '$kadar' AND fc_kdkelompok = '$kelompok' AND fc_kdlokasi = '$lokasi'")->result();
		return $query;
	}
	
	function count_allid()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
}
