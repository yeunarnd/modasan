<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pembelian extends CI_Model
{
    private $tbinvoice = "tm_invoice";
    private $tbpelanggan = "tm_pelanggan";

    public function get_faktur()
    {
        return $this->db->get($this->tbinvoice)->result();
    }

    // public function get_by_id($id)
    // {
    //     $this->db->where('fc_noinv', $id);
    //     return $this->db->get('tm_invoice')->row();
    // }

    public function get_pelanggan_id($id)
    {
        $this->db->where('fc_kdpel', $id);
        return $this->db->get('tm_pelanggan')->row();
    }

    public function get_by_id($id)
    {
        $this->db->where('fc_kdpel', $id);
        return $this->db->get('tm_pelanggan')->row();
    }

    public function get_by_id2($id)
    {
        $this->db->where('fc_noinv', $id);
        $this->db->join('tm_pelanggan', 'tm_invoice.fc_kdpel=tm_pelanggan.fc_kdpel', 'left outer');
        return $this->db->get('tm_invoice')->row();
    }

    public function query_nota($nobeli)
    {
        $query = $this->db->query("SELECT t_belimst.fc_nobeli, tm_pelanggan.fv_nmpelanggan, tm_pelanggan.f_alamat, tm_pelanggan.fc_telp, t_belimst.fd_tglinput ,t_belidtl.fc_kdstock, tm_stock.fv_nmbarang, tm_stock.f_foto, t_belidtl.f_kadar, t_belidtl.fm_potongan, t_belidtl.fn_berat, t_belidtl.fv_kondisi, t_belidtl.fm_potongan, t_belimst.fm_subtot, t_belimst.fm_total, t_belimst.fv_terbilang FROM t_belidtl, t_belimst ,tm_stock, tm_pelanggan WHERE tm_stock.fc_kdstock = t_belidtl.fc_kdstock AND t_belimst.fc_kdpel = tm_pelanggan.fc_kdpel AND t_belidtl.fc_nobeli = t_belimst.fc_nobeli AND t_belidtl.fc_nobeli = '$nobeli'");
        return $query->row();
    }

    public function query_nota2($nobeli)
    {
        $query = $this->db->query("SELECT t_belidtl.fc_kdstock, tm_stock.fv_nmbarang, tm_stock.f_foto, tm_stock.fc_kadar, tm_stock.ff_berat, t_belidtl.fm_hargalama, t_belidtl.fv_kondisi, t_belidtl.fm_potongan, t_belidtl.fm_hargabeli FROM t_belidtl, tm_stock WHERE tm_stock.fc_kdstock = t_belidtl.fc_kdstock AND t_belidtl.fc_nobeli = '$nobeli'");
        return $query->result();
    }

    public function get_by_barang($id)
    {
        $this->db->where('fn_id', $id);
        return $this->db->get('tm_stock')->row_array();
    }

    function get_pelanggan()
    {
        return $this->db->get($this->tbpelanggan)->result();
    }

    public function ambilBarang()
    {
        $this->db->select('*');
        $this->db->from('tm_stock');
        $this->db->join('tm_lokasi', 'tm_stock.fc_kdlokasi=tm_lokasi.fc_kdlokasi', 'left outer');
        $this->db->join('tm_kelompok', 'tm_stock.fc_kdkelompok=tm_kelompok.fc_kdkelompok', 'left outer');
        $this->db->where('fc_sts', 1);

        $barang = $this->db->get();

        if ($barang->num_rows() > 0) {
            $json['status']     = 1;
            foreach ($barang->result() as $b) {
                $json['datanya'][] = $b;
            }
            $json['jumlah_barang'] = count($barang->result());
        } else {
            $json['status']     = 0;
        }

        echo json_encode($json);
    }

    function where_max_nota()
    {
        return $this->db->query('SELECT fc_nobeli AS maxs FROM t_belimst order by fc_nobeli desc limit 1 ');
    }

    function get_sales()
    {
        return $this->db->get('t_sales')->result();
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

    function get_list_penjualan()
    {
        $this->db->select('a.fc_noinv');
        $this->db->select('DATE_FORMAT(a.fd_tglinv, "%d-%m-%Y") as tanggal');
        $this->db->select('b.fv_nmpelanggan');
        $this->db->select('a.fm_grandtotal');
        $this->db->select('a.fc_sts');
        $this->db->join('tm_pelanggan b', 'a.fc_kdpel=b.fc_kdpel', 'left outer');
        $this->db->where('a.fc_sts', 1);
        return $this->db->get('tm_invoice a')->result();
    }

    function get_list_penjualan_det($fc_noinv)
    {
        $this->db->select('a.fc_noinv');
        $this->db->select('a.fc_kdstock');
        $this->db->select('b.fv_nmbarang');
        $this->db->select('a.fn_berat');
        $this->db->select('a.ff_kadar');
        $this->db->select('a.fm_price');
        $this->db->select('a.Id');
        $this->db->join('tm_stock b', 'a.fc_kdstock=b.fc_kdstock', 'left outer');
        $this->db->where('a.fc_noinv', $fc_noinv);
        return $this->db->get('td_invoice a')->result();
    }

    function insertdata($where)
    {
        $this->db->insert('t_belimst', $where);
        return $this->db->insert_id();
    }

    function insertdata_detail($where)
    {
        $this->db->insert('t_belidtl', $where);
        return $this->db->insert_id();
    }

    public function update_status($data1, $where)
    {
        $this->db->update('tm_invoice', $data1, $where);
        return $this->db->affected_rows();
    }
}
