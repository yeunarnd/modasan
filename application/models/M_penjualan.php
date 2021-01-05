<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_penjualan extends CI_Model
{
	private $tbpelanggan = "tm_pelanggan";
	private $tbsales = "tm_sales";

	function get_pelanggan()
	{
		return $this->db->get($this->tbpelanggan)->result();
	}

	function get_sales()
	{
		return $this->db->get('t_sales')->result();
	}

	public function get_by_id($id)
	{
		$this->db->where('fc_kdpel', $id);
		return $this->db->get('tm_pelanggan')->row();
	}

	public function get_by_sales($id)
	{
		$this->db->where('fc_salesid', $id);
		return $this->db->get('t_sales')->row();
	}

	public function get_by_barang($id)
	{
		$this->db->where('fn_id', $id);
		return $this->db->get('tm_stock')->row_array();
	}

	public function nota_jual($noinv)
	{
		$this->db->select('*');
		$this->db->from('tm_invoice', 'td_invoice', 'tm_stock', 'tm_pelanggan');
		$this->db->join('tm_invoice', 'td_invoice.fc_noinv=tm_invoice.fc_noinv');
		$this->db->join('tm_pelanggan', 'tm_invoice.fc_kdpel=tm_pelanggan.fc_kdpel');
		$this->db->join('tm_stock', 'td_invoice.fc_kdstock=tm_stock.fc_kdstock');
		$this->db->where('fc_noinv', $noinv);
		return $this->db->get()->row();
	}

	public function query_nota($noinv)
	{
		$query = $this->db->query("SELECT tm_invoice.fc_kdpel, tm_pelanggan.fv_nmpelanggan, tm_pelanggan.f_alamat, tm_pelanggan.fc_telp, tm_invoice.fd_tglinv ,td_invoice.fc_kdstock, tm_stock.fv_nmbarang, tm_stock.f_foto, td_invoice.ff_kadar, td_invoice.fn_berat, td_invoice.fm_ongkos, td_invoice.fm_subtot, tm_invoice.fm_grandtotal, tm_invoice.fv_terbilang FROM td_invoice, tm_invoice,tm_stock, tm_pelanggan WHERE tm_stock.fc_kdstock = td_invoice.fc_kdstock AND tm_invoice.fc_kdpel = tm_pelanggan.fc_kdpel AND td_invoice.fc_noinv = tm_invoice.fc_noinv AND td_invoice.fc_noinv = '$noinv'");
		return $query->row();
	}

	public function query_nota2($noinv)
	{
		$query = $this->db->query("SELECT td_invoice.fc_kdstock, tm_stock.fv_nmbarang, tm_stock.f_foto, tm_stock.fc_kadar, tm_stock.ff_berat, td_invoice.fm_ongkos, td_invoice.fm_subtot, td_invoice.fm_price FROM td_invoice, tm_stock WHERE tm_stock.fc_kdstock = td_invoice.fc_kdstock AND td_invoice.fc_noinv = '$noinv'");
		return $query->result();
	}

	public function ambilBarang()
	{

		$this->db->select('*');
		$this->db->from('tm_stock');
		$this->db->join('tm_lokasi', 'tm_stock.fc_kdlokasi=tm_lokasi.fc_kdlokasi', 'left outer');
		$this->db->join('tm_kelompok', 'tm_stock.fc_kdkelompok=tm_kelompok.fc_kdkelompok', 'left outer');
		$this->db->where('fc_kondisi', 0);
		$this->db->where('fc_sts', 1);

		$barang = $this->db->get();

		if ($barang->num_rows() > 0) {
			$json['status'] 	= 1;
			foreach ($barang->result() as $b) {
				$json['datanya'][] = $b;
			}
			$json['jumlah_barang'] = count($barang->result());
		} else {
			$json['status'] 	= 0;
		}

		echo json_encode($json);
	}

	public function update_stsbrg($kondisi, $kdstock)
	{
		$this->db->query("UPDATE `tm_stock` SET `fc_kondisi`= '$kondisi' WHERE tm_stock.fc_kdstock='$kdstock'");
	}

	public function get_all_barang()
	{
		$this->db->select('*');
		$this->db->from('tm_stock');
		$this->db->join('tm_lokasi', 'tm_stock.fc_kdlokasi=tm_lokasi.fc_kdlokasi', 'left outer');
		$this->db->join('tm_kelompok', 'tm_stock.fc_kdkelompok=tm_kelompok.fc_kdkelompok', 'left outer');
		$this->db->where('fc_sts', 1);

		return $this->db->get();
	}

	function where_max_nota()
	{
		return $this->db->query('SELECT fc_noinv AS maxs FROM tm_invoice order by fc_noinv desc limit 1 ');
	}

	

	function insert($where)
	{
		$this->db->insert('tm_invoice', $where);
		return $this->db->insert_id();
	}

	function insert_detail($where)
	{
		$this->db->insert('td_invoice', $where);
		return $this->db->insert_id();
	}
}
