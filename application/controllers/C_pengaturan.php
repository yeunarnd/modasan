<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_pengaturan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('form');
		$this->load->model('M_menu');
		$this->load->model('M_barang');
		$this->load->model('M_pengaturan');
		if (empty($this->session->userdata('fv_username'))) {
            echo "<script>
                alert('Anda harus login terlebih dahulu');
                window.location.href = '" . base_url('C_login') . "';
            </script>"; //Url tujuan
        }
    }

    public function index($kode=null)
    {
		if ($this->input->post()) {
			$fc_userid = $this->input->post('fc_userid');
			$cek_data=$this->db->where('fc_userid',$fc_userid)->get('tab_akses_mainmenu')->num_rows();
			// print_r($this->db->last_query());
            // print_r($cek_data);
            if ($cek_data>0) {
                $this->user_aksesUpdate($fc_userid);
            } else {
                $this->user_akses($fc_userid);
            }
        } else {
			$data['title'] = "Pengaturan";
			$data['menu'] = $this->M_menu->get_menu();
			
			$data['pengaturan'] = $this->M_pengaturan->get_user();
			$data['data']=$this->M_pengaturan->menu_akses($kode);

			$kode_user = $this->M_pengaturan->max()->row();

			$userno = $kode_user->maxs;
				//tampil data

			$urut = (int) substr($userno, 4, 3);

			$urut++;

			$char = "USR";

			$userno = $char . sprintf("%03s", $urut);
			$data['nota'] = $userno; 
			//print_r($this->db->last_query());
			$this->load->view('admin/v_pengaturan', $data);
		}	
    }

    public function save()
    {
        
	}
	
	public function user_aksesUpdate($kode=null) {
		//   echo "update";
	  //  print_r('asa'.@$this->input->post('cb_create_sub'));
	 	$data_admin = array(
		//	'fc_userid' => $this->input->post('fc_userid'),
			'fv_username' => $this->input->post('fv_username'),
			'fv_password' => md5($this->input->post('fv_password'))
		);  
		$this->M_pengaturan->update_admin($kode,$data_admin);
		 $jml_menu=$this->db->get('mainmenu')->result();
		 $j=0;
		 $i=0;
		 foreach($jml_menu as $idmenu) { 
		   $data1 = array(
					 'id_menu' =>$idmenu->idmenu,
					 'c' =>@$this->input->post('cb_create_menu')[$i],
					 'r' =>@$this->input->post('cb_read_menu')[$i],
					 'u' =>@$this->input->post('cb_update_menu')[$i],
					 'd' =>@$this->input->post('cb_delete_menu')[$i],
					// 'entry_user' => $this->session->userdata('username')
				   );
		//    $jml_sub=$this->db->where('mainmenu_idmenu',@$idmenu->idmenu)
		// 					 ->get('submenu')->result();
		//    foreach($jml_sub as $idsub) { 
			   
		// 	 $data2 = array(
		// 			   'id_sub_menu' =>$idsub->id_sub,
		// 			   'c' =>@$this->input->post('cb_create_sub')[$i][$j],
		// 			   'r' =>@$this->input->post('cb_read_sub')[$i][$j],
		// 			   'u' =>@$this->input->post('cb_update_sub')[$i][$j],
		// 			   'd' =>@$this->input->post('cb_delete_sub')[$i][$j],
		// 			   'entry_user' => $this->session->userdata('username')
		// 			 );
		// 	 $cek_sub=$this->db->where('id_sub_menu',$idsub->id_sub)->where('id_level',$kode)->get('tab_akses_submenu')->num_rows();
		// 	 $this->M_user->update_aksessub($idsub->id_sub,$kode,$data2);
		// 	// print_r($this->db->last_query());
		// 	 // echo "submenu <br/>";
		// 	 // echo "<pre>";
		// 	 // print_r($cek_sub);
		// 	 // echo "</pre>";
		// 	  if ($cek_sub==1) {
		// 	   $this->M_user->update_aksessub($idsub->id_sub,$kode,$data2);
		// 	   //print_r($this->db->last_query());
		// 	 } else {
		// 	   $this->M_user->insert_aksessub($data2);
		// 	   //print_r($this->db->last_query());
		// 	 }
		// 	 $j++;
		//    }
		   $cek_menu=$this->db->where('id_menu',$idmenu->idmenu)->where('fc_userid',$kode)->get('tab_akses_mainmenu')->num_rows();
		   $this->M_pengaturan->update_aksesmenu($idmenu->idmenu,$kode,$data1);
		   //print_r($this->db->last_query())."<br/>";
		   // echo "mainmenu <br/>";
		   // echo "<pre>";
		   // print_r($cek_menu);
		   // echo "</pre>";
		   if ($cek_menu==1) {
			   $this->M_pengaturan->update_aksesmenu($idmenu->idmenu,$kode,$data1);
			   //print_r($this->db->last_query());
		   } else {
			   $this->M_pengaturan->insert_aksesmenu($data1);
			 //print_r($this->db->last_query());
		   }
		   $i++;
		 }
		 redirect('C_pengaturan');
	   }

	   public function user_akses($kode) {
		$data_admin = array(
			'fc_userid' => $this->input->post('fc_userid'),
			'fv_username' => $this->input->post('username'),
			'fv_password' => md5($this->input->post('ulangi_password'))
		);  
		$this->M_pengaturan->insert_admin($data_admin);
        $jml_menu=$this->db->get('mainmenu')->result();
        $i=0;
        $y=0;
        foreach($jml_menu as $idmenu) { 
          $data1 = array(
                    'id_menu' =>$idmenu->idmenu,
                    'fc_userid' =>$this->input->post('fc_userid'),
                    'c' =>@$this->input->post('cb_create_menu')[$i],
                    'r' =>@$this->input->post('cb_read_menu')[$i],
                    'u' =>@$this->input->post('cb_update_menu')[$i],
                    'd' =>@$this->input->post('cb_delete_menu')[$i],
                   // 'entry_user' => $this->session->userdata('username')
                  );
          
            // $jml_sub=$this->db->where('mainmenu_idmenu',$idmenu->idmenu)->get('submenu')->result();
           
            // foreach($jml_sub as $idsub) { 
            // $data2 = array(
            //             'id_sub_menu' =>$idsub->id_sub,
            //             'id_level' =>$kode,
            //             'c' =>@$this->input->post('cb_create_sub')[$i][$y],
            //             'r' =>@$this->input->post('cb_read_sub')[$i][$y],
            //             'u' =>@$this->input->post('cb_update_sub')[$i][$y],
            //             'd' =>@$this->input->post('cb_delete_sub')[$i][$y],
            //             'entry_user' => $this->session->userdata('username')
            //         );
            // $this->M_user->insert_aksessub($data2);
            
            // $y++;
            // }
            $this->M_pengaturan->insert_aksesmenu($data1);
          $i++;
        }
       
        redirect('C_pengaturan');
	  }
	  
	  public function edit($id)
	  {
			$data = $this->M_pengaturan->get_by_id($id);
			echo json_encode($data);
	  }

	  public function get_mainmenu($kode){
			echo json_encode($this->M_pengaturan->get_mainmenu($kode)->result_array());
	  }

	  function delete()
		{
			foreach ($_POST['fc_userid'] as $id) {
				$this->M_pengaturan->delete($id);
				$this->M_pengaturan->delete_akses($id);
			}
			return redirect('C_pengaturan');
		}

	public function ajax_edit() {
		$data = $this->M_pengaturan->get_by_id_setup();
		//print_r($this->db->last_query());
		echo json_encode($data);
	}

	public function update_setup(){
		$gambar5="";

		$data1 = array('fc_isi' => $this->input->post('nama_toko'));
        $this->M_pengaturan->update_link($data1,array('fc_param' => 'NAMATOKO'));
        
		$data2 = array('fc_isi' => $this->input->post('alamat_toko'));
        $this->M_pengaturan->update_link($data2,array('fc_param' => 'ALAMATTOKO'));
        
		$data3 = array('fc_isi' => $this->input->post('telp_toko'));
        $this->M_pengaturan->update_link($data3,array('fc_param' => 'TELPTOKO'));

		$config['upload_path'] = realpath('./assets/img/');
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size'] = '2000000';
        $config['max_width'] = '2024';
        $config['max_height']= '1468';
		
		$new_name = 'logoheader_'.time();
		$config['file_name'] = $new_name;
		$this->load->library('upload', $config);
 		$this->upload->initialize($config);
		if($this->upload->do_upload('file-upload1')){
			$get_name = $this->upload->data();
			$data['fc_isi'] = $get_name['file_name'];
			$where = array('fc_param' => 'LOGOTOKO');	
		 	$this->M_pengaturan->update_data($data,$where); 
		}
		

		// $new_name = 'drp_fotofooter_'.time();
		// $config['file_name'] = $new_name;
		// $this->load->library('upload', $config);
 		// $this->upload->initialize($config);
		// if($this->upload->do_upload('file-upload2')){
		// 	$get_name = $this->upload->data();
		// 	$data['fc_isi'] = $get_name['file_name'];
		// 	$where = array('fc_param' => 'LOGO2');	
		//  	$this->setup->update_data($data,$where);   
		// }

		redirect('C_pengaturan');	
	}
		
}
