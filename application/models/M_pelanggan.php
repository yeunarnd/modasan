<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pelanggan extends CI_Model
{
    private $tabel = "tm_pelanggan";

    function list_pelanggan($limit, $start)
    {
        $query = $this->db->get('tm_pelanggan', $limit, $start);
        return $query;
    }

    // public function get_pelanggan()
    // {
    //     return $this->db->get($this->tabel)->result();
    // }

    // public function get()
    // {
    //     $this->db->select('*');
    //     $this->db->from('tm_pelanggan');
    //     $query = $this->db->get()->result();
    //     return $query;
    // }

    public function save_pelanggan()
    {
        $post = $this->input->post();
        $this->fc_kdpel = $post['fc_kdpel'];
        $this->fv_nmpelanggan = $post['fv_nmpelanggan'];
        $this->f_alamat = $post['f_alamat'];
        $this->fc_telp = $post['fc_telp'];
        $this->fc_noktp = $post['fc_noktp'];
        $this->f_keterangan = $post['f_keterangan'];


        $this->db->insert($this->tabel, $this);
    }

    public function update_pelanggan()
    {
        $post = $this->input->post();
        $this->fc_kdpel = $post['fc_kdpel_edit'];
        $this->fv_nmpelanggan = $post['fv_nmpelanggan_edit'];
        $this->f_alamat = $post['f_alamat_edit'];
        $this->fc_telp = $post['fc_telp_edit'];
        $this->fc_noktp = $post['fc_noktp_edit'];
        $this->f_keterangan = $post['f_keterangan_edit'];

        $this->db->update($this->tabel, $this, array('fc_kdpel' => $post['fc_kdpel_edit']));
    }

    public function get_by_id($id_pelanggan)
    {
        return $this->db->get_where($this->tabel, ["fc_kdpel" => $id_pelanggan])->row();
    }

    public function get_by_id2($id)
    {
        $this->db->where('fc_kdpel', $id);
        return $this->db->get('tm_pelanggan')->row();
    }

    public function delete($id)
    {
        $this->db->where('fc_kdpel', $id);
        $this->db->delete('tm_pelanggan');
	}
	
	function max_pelanggan(){
		return $this->db->query('SELECT max(fc_kdpel) AS maxs_pelanggan FROM tm_pelanggan');
	}
}
