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

    function laporanBulanan()
    {
        $sql = $this->db->query("
  
        select
        ifnull((SELECT sum(fm_grandtotal) FROM (tm_invoice)WHERE((Month(fd_tglinput)=1)AND (YEAR(fd_tglinput)=2021))),0) AS `Januari`,
        ifnull((SELECT sum(fm_grandtotal) FROM (tm_invoice)WHERE((Month(fd_tglinput)=2)AND (YEAR(fd_tglinput)=2021))),0) AS `Februari`,
        ifnull((SELECT sum(fm_grandtotal) FROM (tm_invoice)WHERE((Month(fd_tglinput)=3)AND (YEAR(fd_tglinput)=2021))),0) AS `Maret`,
        ifnull((SELECT sum(fm_grandtotal) FROM (tm_invoice)WHERE((Month(fd_tglinput)=4)AND (YEAR(fd_tglinput)=2021))),0) AS `April`,
        ifnull((SELECT sum(fm_grandtotal) FROM (tm_invoice)WHERE((Month(fd_tglinput)=5)AND (YEAR(fd_tglinput)=2021))),0) AS `Mei`,
        ifnull((SELECT sum(fm_grandtotal) FROM (tm_invoice)WHERE((Month(fd_tglinput)=6)AND (YEAR(fd_tglinput)=2021))),0) AS `Juni`,
        ifnull((SELECT sum(fm_grandtotal) FROM (tm_invoice)WHERE((Month(fd_tglinput)=7)AND (YEAR(fd_tglinput)=2021))),0) AS `Juli`,
        ifnull((SELECT sum(fm_grandtotal) FROM (tm_invoice)WHERE((Month(fd_tglinput)=8)AND (YEAR(fd_tglinput)=2021))),0) AS `Agustus`,
        ifnull((SELECT sum(fm_grandtotal) FROM (tm_invoice)WHERE((Month(fd_tglinput)=9)AND (YEAR(fd_tglinput)=2021))),0) AS `September`,
        ifnull((SELECT sum(fm_grandtotal) FROM (tm_invoice)WHERE((Month(fd_tglinput)=10)AND (YEAR(fd_tglinput)=2021))),0) AS `Oktober`,
        ifnull((SELECT sum(fm_grandtotal) FROM (tm_invoice)WHERE((Month(fd_tglinput)=11)AND (YEAR(fd_tglinput)=2021))),0) AS `November`,
        ifnull((SELECT sum(fm_grandtotal) FROM (tm_invoice)WHERE((Month(fd_tglinput)=12)AND (YEAR(fd_tglinput)=2021))),0) AS `Desember`
        from tm_invoice GROUP BY YEAR(fd_tglinput) 
        
        ");

        return $sql;
    }
}
