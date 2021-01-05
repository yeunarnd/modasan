<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_lapenjualan extends CI_Model
{

    public function get_cetak()
    {
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('end');
        $query = $this->db->query("SELECT td_invoice.id, tm_invoice.fc_noinv, tm_invoice.fd_tglinv, td_invoice.fc_kdstock,tm_invoice.fm_subtot,tm_invoice.fm_grandtotal, sum(td_invoice.fn_berat) as berat FROM tm_invoice,td_invoice  WHERE tm_invoice.fc_noinv = td_invoice.fc_noinv and fd_tglinv between '$startdate' AND '$enddate' GROUP BY tm_invoice.fc_noinv");
        return $query->result();
    }

    public function get_berat()
    {
        $sql1 = "SELECT sum(td_invoice.fn_berat) as count FROM td_invoice";
        $result = $this->db->query($sql1);
        return $result->row()->count;
    }
}
