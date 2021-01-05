<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_menu extends CI_Model
{
    private $tabel = "mainmenu";

    public function get_menu()
    {
        $this->db->select('*');
        $this->db->from('mainmenu');
        $this->db->order_by('idmenu');
        $query = $this->db->get()->result();
        return $query;

    }

}