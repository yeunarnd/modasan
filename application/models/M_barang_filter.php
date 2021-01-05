<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_barang_filter extends CI_Model {

    var $table = 'tm_stock';
	var $column_orderid = array('a.fn_id','a.fc_kdstock','a.fc_barcode','a.fv_nmbarang','b.fv_nmkelompok','c.fv_nmloaksi','a.ff_berat','a.fc_kadar',null);  //set column field database for datatable orderable
	var $column_searchid = array('a.fn_id','a.fc_kdstock','a.fc_barcode','a.fv_nmbarang','b.fv_nmkelompok','c.fv_nmloaksi','a.ff_berat','a.fc_kadar'); //set column field database for datatable searchable just title , author , category are searchable
    var $orderid = array('a.fn_id' => 'asc'); // default order

    public function get_datatablesid($id_blok="", $id_blok2="", $id_blok3="") {
		$this->_get_datatables_queryid($id_blok, $id_blok2, $id_blok3);
	//	$this->db->where('orde_sungai',$id);

		if ($_REQUEST['length'] != -1) {
			$this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		}

		$query = $this->db->get();
		return $query->result();
	}
	
	private function _get_datatables_queryid($id_blok="",$id_blok2="", $id_blok3="") {
        $this->db->select('a.fn_id, a.fc_kdstock, a.fv_nmbarang, b.fv_nmkelompok, c.fv_nmlokasi, a.ff_berat, a.fc_kadar, a.fm_hargabeli, d.fv_nama, a.fc_sts, a.fd_date, a.fc_barcode, a.f_foto, DATE_FORMAT(a.fd_date, "%d-%m-%Y") as tanggal');

        $this->db->from('tm_stock a');

        $this->db->join('tm_kelompok b', 'a.fc_kdkelompok = b.fc_kdkelompok', 'left outer');

        $this->db->join('tm_lokasi c', 'a.fc_kdlokasi = c.fc_kdlokasi', 'left outer');

        $this->db->join('t_sales d', 'a.fc_salesid = d.fc_salesid', 'left outer');

        $this->db->where('fc_kondisi', 0);
        if ($id_blok!="") {
            $this->db->where("a.fc_kadar",$id_blok);
        }
        if ($id_blok2!="") {
            $this->db->where("a.fc_kdkelompok",$id_blok2);
		}
		if ($id_blok3!="") {
            $this->db->where("a.fc_kdlokasi",$id_blok3);
        }
		$i = 0;
		

        foreach ($this->column_searchid as $item) {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    // $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_searchid) - 1 == $i); //last loop
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
	
	function count_filteredid($id_blok="",$id_blok2="", $id_blok3="") {
		$this->_get_datatables_queryid($id_blok,$id_blok2, $id_blok3);
		//$this->db->where('orde_sungai',$id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_allid($id_blok="",$id_blok2="", $id_blok3="") {
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
}    