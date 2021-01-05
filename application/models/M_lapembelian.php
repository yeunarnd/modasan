<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_lapembelian extends CI_Model
{
    public function get_lapembelian($startdate, $enddate)
    {
        return $this->db->query("SELECT * FROM t_belimst WHERE fd_tglbeli between '$startdate' AND '$enddate'")->result();
    }

    // public function get_grandtotal($startdate, $enddate)
    // {
    //     return $this->db->query("SELECT SUM(fm_total) as gtotal FROM t_belimst  WHERE  fd_tglbeli between '$startdate' AND '$enddate'")->result();
    // }

    // public function get_subtotal($startdate, $enddate)
    // {
    //     return $this->db->query("SELECT SUM(fm_total) as stotal FROM t_belimst  WHERE  fd_tglbeli between '$startdate' AND '$enddate'")->result();
    // }
    // public function get_berat($startdate, $enddate)
    // {
    //     return $this->db->query("SELECT  sum(fn_berat) as berat FROM t_belimst, t_belidtl WHERE t_belimst.fc_nobeli=t_belidtl.fc_nobeli and  fd_tglbeli between '$startdate' AND '$enddate'")->result();
    // }
    
}
