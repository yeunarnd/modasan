<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pengaturan extends CI_Model
{
    private $tabel = "tab_akses_mainmenu";
    private $tbadmin = "admin";
    public function save()
    {
        $post = $this->input->post();
        $this->id_menu = $post['id_menu'];
    }

    function get_user()
    {
        return $this->db->get($this->tbadmin)->result();
	}
	
	public function update_aksesmenu($id,$kode,$data)
	{
		$this->db->where(array('id_menu' => $id,'fc_userid' => $kode))->update('tab_akses_mainmenu', $data);
	}

	public function insert_aksesmenu($data)
	{
	    $this->db->insert('tab_akses_mainmenu', $data);
	}

	public function insert_admin($data){
		$this->db->insert('admin', $data);
	}

	public function menu_akses($kode=null)
	{
		$hasil = $this->db->join('mainmenu','mainmenu.idmenu=tab_akses_mainmenu.id_menu','left outer')->where('fc_userid',$kode)->get('tab_akses_mainmenu');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			$hasil = $this->db->get('mainmenu');
			if($hasil->num_rows() > 0){
				return $hasil->result();
			} else {
				return array();
			}
		}
	}
	
	function max(){
		return $this->db->query('SELECT max(fc_userid) AS maxs FROM admin');
	}

	public function get_by_id($id)
    {
        $this->db->where('fc_userid', $id);
        return $this->db->get('admin')->row();
	}
	
	public function get_mainmenu($kode){
		$this->db->where('tab_akses_mainmenu.fc_userid', $kode);
		$this->db->join('tab_akses_mainmenu','mainmenu.idmenu=tab_akses_mainmenu.id_menu','left outer');
		return $this->db->get('mainmenu');
	}

	public function update_admin($kode,$data){
		$this->db->where(array('fc_userid' => $kode))->update('admin', $data);
	}

	public function delete($id)
    {
        $this->db->where('fc_userid', $id);
        $this->db->delete('admin');
	}
	
	public function delete_akses($id){
		$this->db->where('fc_userid', $id);
        $this->db->delete('tab_akses_mainmenu');
	}

	public function get_by_id_setup() {
		$this->db->select('a.fc_isi as set_data1, b.fc_isi as set_data2, c.fc_isi as set_data3, d.fc_isi as set_data4');
		$this->db->from('t_setup a');
		$this->db->join('t_setup b ', 'b.fc_param="ALAMATTOKO"', 'left outer');
		$this->db->join('t_setup c ', 'c.fc_param="TELPTOKO"', 'left outer');
		$this->db->join('t_setup d ', 'd.fc_param="LOGOTOKO"', 'left outer');
		$this->db->where('a.fc_param','NAMATOKO');
		$query = $this->db->get();
		return $query->row();
	}

	public function update_data($data, $where) {
		$this->db->update('t_setup', $data, $where);
		return $this->db->affected_rows();
	}

	public function update_link($data1,$where) {
		$this->db->update('t_setup', $data1, $where);
		return $this->db->affected_rows();
	}
}
