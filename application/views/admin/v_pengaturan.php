<?php $this->load->view('partials/header.php') ?>

<!-- #section:basics/navbar.layout -->
<div id="navbar" class="navbar navbar-default    navbar-collapse       h-navbar">
    <script type="text/javascript">
        try {
            ace.settings.check('navbar', 'fixed')
        } catch (e) {}
    </script>

    <div class="navbar-container" id="navbar-container">
        <div class="navbar-header pull-left">
            <!-- #section:basics/navbar.layout.brand -->
            <a href="#" class="navbar-brand">
                <small>
                    <i class="fa fa-leaf"></i>
                    LOGO
                </small>
            </a>
            <button class="pull-right navbar-toggle navbar-toggle-img collapsed" type="button" data-toggle="collapse" data-target=".navbar-buttons,.navbar-menu">
                <span class="sr-only">Toggle user menu</span>

                <img src="../Toko-Emas-Modasan/backend-emas/assets/assets/avatars/user.jpg" alt="Jason's Photo" />
            </button>

            <button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#sidebar">
                <span class="sr-only">Toggle sidebar</span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>
            </button>


        </div>

        <!-- #section:basics/navbar.dropdown -->
        <div class="navbar-buttons navbar-header pull-right  collapse navbar-collapse" role="navigation">
            <ul class="nav ace-nav">
                <!-- #section:basics/navbar.user_menu -->
                <li class="light-blue user-min">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <img class="nav-user-photo" src="../Toko-Emas-Modasan/backend-emas/assets/assets/avatars/user.jpg" alt="Jason's Photo" />
                        <span class="user-info">
                            <small>Welcome,</small>
                            Jason
                        </span>

                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="<?php echo base_url('C_login/logout') ?>">
                                <i class="ace-icon fa fa-cog"></i>
                                Settings
                            </a>
                        </li>

                        <li>
                            <a href="profile.html">
                                <i class="ace-icon fa fa-user"></i>
                                Profile
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="#">
                                <i class="ace-icon fa fa-power-off"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- /section:basics/navbar.user_menu -->
            </ul>
        </div>

    </div>
</div>

<!-- /section:basics/navbar.layout -->
<div class="main-container" id="main-container">
    <script type="text/javascript">
        try {
            ace.settings.check('main-container', 'fixed')
        } catch (e) {}
    </script>

    <!-- #section:basics/sidebar.horizontal -->
    <div id="sidebar" class="sidebar h-sidebar navbar-collapse collapse">
        <script type="text/javascript">
            try {
                ace.settings.check('sidebar', 'fixed')
            } catch (e) {}
        </script>
        <ul class="nav nav-list">
            <?php
            $id_level = $this->session->userdata('fc_userid');
            $main_menu = $this->db->join('mainmenu', 'mainmenu.idmenu=tab_akses_mainmenu.id_menu')
                ->where('tab_akses_mainmenu.fc_userid', $id_level)
                ->where('tab_akses_mainmenu.r', '1')
                ->order_by('mainmenu.idmenu', 'asc')
                ->get('tab_akses_mainmenu')
                ->result();
            foreach ($main_menu as $rs) {
            ?>
                <?php
                $row = $this->db->where('mainmenu_idmenu', $rs->idmenu)->get('submenu')->num_rows();
                if ($row > 0) {
                    $sub_menu = $this->db->join('submenu', 'submenu.id_sub=tab_akses_submenu.id_sub_menu')
                        ->where('submenu.mainmenu_idmenu', $rs->idmenu)
                        ->where('tab_akses_submenu.fc_userid', $id_level)
                        ->where('tab_akses_submenu.r', '1')
                        ->get('tab_akses_submenu')
                        ->result();
                ?>

                    <li class="hover">
                        <a class="dropdown-toggle">
                            <i class="menu-icon <?= $rs->icon_class ?>"></i>
                            <span class="menu-text">
                                <?= $rs->nama_menu ?>
                            </span>

                            <b class="arrow fa fa-angle-down"></b>
                        </a>

                        <b class="arrow"></b>

                        <?php
                        echo "<ul class='submenu'>";
                        foreach ($sub_menu as $rsub) {
                        ?>
                    <li class="hover">
                        <a href="<?= base_url() . $rsub->link_sub ?>">
                            <i class="menu-icon fa fa-caret-right"></i>
                            <?= $rsub->nama_sub ?>
                        </a>

                        <b class="arrow"></b>
                    </li>


                <?php
                        }
                        echo "</ul>";
                    } else {
                ?>
                </li>
                <li class="hover">
                    <a href="<?= base_url() . $rs->link_menu ?>">
                        <i class="menu-icon <?= $rs->icon_class ?>"></i>
                        <span class="menu-text"><?= $rs->nama_menu ?> </span>
                    </a>

                    <b class="arrow"></b>
                </li>
        <?php
                    }
                }
        ?>
        <?php
        if ($id_level == 1) { ?>

        <?php
        }
        ?>


        </ul>

        <!-- #section:basics/sidebar.layout.minimize -->

        <!-- /section:basics/sidebar.layout.minimize -->
        <!-- /.nav-list -->

        <!-- #section:basics/sidebar.layout.minimize -->

        <!-- /section:basics/sidebar.layout.minimize -->
        <script type="text/javascript">
            try {
                ace.settings.check('sidebar', 'collapsed')
            } catch (e) {}
        </script>

    </div>
	<?php
    $bu = base_url();

    $fc_userid = $this->session->userdata('fc_userid');
    $get_menu = $this->M_barang->getMenu($this->uri->segment(1));
    $cr = $this->M_barang->getRole($fc_userid, 'r', $get_menu->idmenu)->r;
    $cc = $this->M_barang->getRole($fc_userid, 'c', $get_menu->idmenu)->r;
    $cu = $this->M_barang->getRole($fc_userid, 'u', $get_menu->idmenu)->r;
    $cd = $this->M_barang->getRole($fc_userid, 'd', $get_menu->idmenu)->r;

    ?>		
    <!-- /section:basics/sidebar.horizontal -->
    <div class="main-content">
        <div class="main-content-inner">
            <div class="page-content">

                <!-- /section:settings.box -->
                <div class="page-header">
                    <h2 style="color: #07A1C8;">
                        Pengaturan
                    </h2>
                </div>
                <div class="row">
                    <div class="col-xs-12" style="margin-top: 30px;">
                        <!-- PAGE CONTENT BEGINS -->
                        <div class="row">
                            <div class="col-xs-12">
                                <table id="simple-table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                        <tr>
                                            <th class="center">
                                                <input type="checkbox" id="check-all" />
                                            </th>
                                            <th>No</th>
                                            <th>Kode User</th>
                                            <th>Username</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php echo form_open('C_pengaturan/delete'); ?>
                                        <?php $no = $this->uri->segment('3') + 1; ?>
                                        <?php foreach ($pengaturan as $u) : ?>
                                            <tr>
                                                <td class="check center">
                                                    <input type="checkbox" class="check-item" id="user" name="fc_userid[]" value="<?php echo $u->fc_userid ?>">
                                                </td>
                                                <td><?= $no++ ?></td>
                                                <td><?= $u->fc_userid ?></td>
                                                <td><?= $u->fv_username ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
						<?php if ($cc == '1') { ?>				
                            <a href="#" data-toggle="modal" data-target="#exampleModal" class=" btn btn-primary" style="margin-left: 10px;">
                                <i class="fa fa-save">
                                    Tambah Operator Baru
                                </i>
                            </a>
						<?php } ?>	
						<?php if ($cu == '1') { ?>
                            <button type="button" class="btn btn-success update">
                                <i class="fa fa-edit">
                                    Edit
                                </i>
                            </button>
						<?php } ?>	
						<?php if ($cd == '1') { ?>
							<button type="submit" class="btn btn-danger" onclick="return confirm(' Anda Yakin Menghapus Data Admin ?')"><i class="fa fa-trash"></i> Hapus</button>
						<?php } ?>		
							<?= form_close(); ?>
                        </div>
						
                    </div>
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" style="width: 664px;">
							<form name="form_data" method="post" id="form_data" action="">
                                <div class="modal-content">
                                    <div class="modal-body">
										<div class="row">
										<div class="widget-box">	
                                        <!-- <h5>Tambah Data Operator</h5> -->
											<div class="widget-header">
													<h4 class="widget-title">Data Operator</h4>

													<div class="widget-toolbar">
														<a href="#" data-action="collapse">
															<i class="ace-icon fa fa-chevron-up"></i>
														</a>

														<a href="#" data-action="close">
															<i class="ace-icon fa fa-times"></i>
														</a>
													</div>
											</div>
											<div class="widget-body">
												<div class="widget-main">
													<div class="form-group">
														<label>Kode User</label>
														<input type="text" class="form-control" name="fc_userid" value="<?php echo $nota?>">
													</div>
													<div class="form-group">
														<label>Username</label>
														<input type="text" class="form-control" name="username">
													</div>
													<div class="form-group">
														<label>Password</label>
														<input type="password" class="form-control" name="password" id="password">
													</div>
													<div class="form-group">
														<label>Ulangi Password</label>
														<input type="password" class="form-control" name="ulangi_password" id="ulangi_password" onkeyup='cek_password(this.value)'>
													</div>
													<div class='form-group'>
														
														<div class='md-form' id='dur_pass4' style='margin: -13px;'>	
															<label class='btn_2 rounded' for='inputSuccess' id='erpr4' style='display: none;'><i class='fa fa-times label-danger'></i>Password Tidak Sama</label>
															<label class='btn_1 rounded' for='inputError'  id='scpr4' style='display: none;'><i class='fa fa-check label-success'></i>Password Sama</label>
														</div>
														
													</div>
												</div>	
											</div>	
										</div>
										<?php
											// if($data==true)
											// {
											  $no=1;$i=0;$j=0;
											  foreach ($data as $tampil){
												if (isset($tampil->id_level)) {
														if ($tampil->c==1) $cek_c="checked"; else $cek_c="";
														if ($tampil->r==1) $cek_r="checked"; else $cek_r="";
														if ($tampil->u==1) $cek_u="checked"; else $cek_u="";
														if ($tampil->d==1) $cek_d="checked"; else $cek_d="";
														//$submenu=$this->db->join('submenu','submenu.id_sub=tab_akses_submenu.id_sub_menu')->where('submenu.mainmenu_idmenu',$tampil->idmenu)->where('tab_akses_submenu.id_level',$tampil->id_level)->get('tab_akses_submenu')->result();
														//print_r($this->db->last_query());
												} 
												else 
												{
													// $submenu=$this->db->where('submenu.mainmenu_idmenu',@$tampil->idmenu)
													// 		->get('submenu')->result();
													$cek="";
										
														// anwar
														$cek_c="";
														$cek_r="";
														$cek_u="";
														$cek_d="";
												}

											echo "
											
												<div class='col-md-4'>
												<div class='alert alert-info'>
												<div class='form-check'>
													<input class='form-check-input' type='checkbox' name=cb_read_menu[$i] id=cb_read_menu[$i] value='1' $cek_r>
													<label class='form-check-label' for='defaultCheck1'>
														Jendela $tampil->nama_menu
													</label>
												</div>
												<div class='form-check'>
													<input class='form-check-input' type='checkbox' name=cb_create_menu[$i] id=cb_create_menu[$i] value='1' $cek_c>
													<label class='form-check-label' for='defaultCheck1'>
														Tambah
													</label>
												</div>
												<div class='form-check'>
													<input class='form-check-input' type='checkbox' name=cb_update_menu[$i] id=cb_update_menu[$i] value='1' $cek_u>
													<label class='form-check-label' for='defaultCheck1'>
														Edit
													</label>
												</div>
												<div class='form-check'>
													<input class='form-check-input' type='checkbox' name=cb_delete_menu[$i] id=cb_delete_menu[$i] value='1' $cek_d>
													<label class='form-check-label' for='defaultCheck1'>
														Hapus
													</label>
												</div>
												</div>
												</div>
											
												
											";	
											
										
											$i++;
										}	
										?>
												
										</div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"> Close</i></button>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save">
                                                Simpan</i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal fade" id="modalupdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" style="width: 664px;">
							<form name="form_data" method="post" id="form_data" action="">
                                <div class="modal-content">
                                    <div class="modal-body">
									<div class="row">
										<div class="widget-box">	
                                        <!-- <h5>Tambah Data Operator</h5> -->
											<div class="widget-header">
													<h4 class="widget-title">Data Operator</h4>

													<div class="widget-toolbar">
														<a href="#" data-action="collapse">
															<i class="ace-icon fa fa-chevron-up"></i>
														</a>

														<a href="#" data-action="close">
															<i class="ace-icon fa fa-times"></i>
														</a>
													</div>
											</div>
											<div class="widget-body">
												<div class="widget-main">
													<div class="form-group">
														<label>Kode User</label>
														<input type="text" class="form-control" name="fc_userid" id="fc_userid">
													</div>
													<div class="form-group">
														<label>Username</label>
														<input type="text" class="form-control" name="fv_username">
													</div>
													<div class="form-group">
														<label>Password</label>
														<input type="password" class="form-control" name="fv_password" id="password">
													</div>
													<div class="form-group">
														<label>Ulangi Password</label>
														<input type="password" class="form-control" name="ulangi_password" id="ulangi_password" onkeyup='cek_password(this.value)'>
													</div>
													<div class='form-group'>
														
														<div class='md-form' id='dur_pass4' style='margin: -13px;'>	
															<label class='btn_2 rounded' for='inputSuccess' id='erpr4' style='display: none;'><i class='fa fa-times label-danger'></i>Password Tidak Sama</label>
															<label class='btn_1 rounded' for='inputError'  id='scpr4' style='display: none;'><i class='fa fa-check label-success'></i>Password Sama</label>
														</div>
														
													</div>
												</div>	
											</div>	
										</div>
										<div id='mainmenu_id'></div>
										</div>
									</div>	
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"> Close</i></button>
                                        <button type="submit" class="btn btn-primary" value="cek"><i class="fa fa-save">Simpan</i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
				<form id="form-upload" class="form-horizontal" role="form" action="<?= site_url('C_pengaturan/update_setup')?>" method="POST" enctype="multipart/form-data">
                    <div class="col-md-4" style="margin-top: 20px;">
                        <h5>Data Toko</h5>
                      
                            <div class="form-group">
                                <label>Nama Toko</label>
                                <input type="text" class="form-control" placeholder="Nama Toko..." id="nama_toko" name="nama_toko">
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" class="form-control" placeholder="Alamat..." id="alamat_toko" name="alamat_toko">
                            </div>
                            <div class="form-group">
                                <label>Telp</label>
                                <input type="text" class="form-control" placeholder="Telp..." id="telp_toko" name="telp_toko">
                            </div>
                       
                    </div>
                    <div class="col-md-4" style="margin-top: 40px; margin-left: 20px;">
					
					<img id="preview-upload1" src="#" style="height: 100px;border: 1px solid #DDC; " /><br /><br />
					<input type="file" name="file-upload1" id="file-upload1">
					<span class="help-block"></span>
					<div class="input-group-btn">
						<button type="submit" class="btn btn-primary">Upload</button>
					</div>
                    </div>
                </form>   
                </div>
                <!-- /.page-header -->
            </div><!-- /.page-content -->
        </div>
    </div><!-- /.main-content -->


</div>

<script>
    $(".check-item").on("click", function() {
        if ($(".check-item:checked").length < 2) {
            $('.action-update').prop('disabled', false);
        } else {
            $('.action-update').prop('disabled', true);
        }
	});

	$(document).ready(function(){
	  ubah();

	  
      function readURL1(input) {
			if (input.files && input.files[0]) {
				var rd = new FileReader(); 
				rd.onload = function (e) { $('#preview-upload1').attr('src', e.target.result); }; rd.readAsDataURL(input.files[0]);
			}
	  }
	  $("#file-upload1").change(function(){ readURL1(this); });
	})  
	
	$('.update').click(function(e) {
                e.preventDefault();
                var arr = [];
                var checkedValue = $(".check-item:checked").val();
                console.log('checked', checkedValue);
                // jQuery.noConflict();
                $('#modalupdate').modal('show');
                $.ajax({
                    url: "<?php echo base_url('C_pengaturan/edit/') ?>" + checkedValue,
                    type: "GET",
                    dataType: "JSON",
                    success: function(result) {
                        $('#fc_userid').val(result.fc_userid);
                        $('[name="fv_username"]').val(result.fv_username);
                        $('[name="fv_password"]').val(result.fv_view_password);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Data Eror');
                    }
				})
				
				$.getJSON('<?php echo base_url()?>C_pengaturan/get_mainmenu/'+checkedValue, {
					format: "json"
				})
				.done(function (datae) {
					var mainmenu = "";
					var i = 0;
					$.each(datae, function (key, val) {
						if(val.c==1){
							var cek_c = 'checked';
						}else{
							var cek_c = '';
						}

						if(val.r==1){
							var cek_r = 'checked';
						}else{
							var cek_r = '';
						}

						if(val.u==1){
							var cek_u = 'checked';
						}else{
							var cek_u = '';
						}

						if(val.d==1){
							var cek_d = 'checked';
						}else{
							var cek_d = '';
						}
						mainmenu += `
							<div class='col-md-4'>
								 <div class='alert alert-info'>
								 	<div class='form-check'>
													<input class='form-check-input' type='checkbox' name=cb_read_menu[`+i+`] id=cb_read_menu[`+i+`] value='1' `+cek_r+`>
													<label class='form-check-label' for='defaultCheck1'>
														Jendela `+val.nama_menu+`
													</label>
									</div>
									<div class='form-check'>
													<input class='form-check-input' type='checkbox' name=cb_create_menu[`+i+`] id=cb_create_menu[`+i+`] value='1' `+cek_c+`>
													<label class='form-check-label' for='defaultCheck1'>
														Tambah
													</label>
									</div>
									<div class='form-check'>
													<input class='form-check-input' type='checkbox' name=cb_update_menu[`+i+`] id=cb_update_menu[`+i+`] value='1' `+cek_u+`>
													<label class='form-check-label' for='defaultCheck1'>
														Edit
													</label>
									</div>
									<div class='form-check'>
													<input class='form-check-input' type='checkbox' name=cb_delete_menu[`+i+`] id=cb_delete_menu[`+i+`] value='1' `+cek_d+`>
													<label class='form-check-label' for='defaultCheck1'>
														Hapus
													</label>
									</div>
								 </div>
							</div>	 
						`;

						i++;
					})
					var get_menu = mainmenu;
					document.getElementById('mainmenu_id').innerHTML = get_menu;	
				})	

                // $('input.check-item:checked').each(function() {
                //     arr.push($(this).val());
                // });

                // var action = $(this).attr('data-href') + '/' + arr.join("-");
                // window.location.href = action;
    });

    // window.onload = function() {
    //     document.getElementById("pw1").onchange = validatePassword;
    //     document.getElementById("pw2").onchange = validatePassword;
    // }

    function validatePassword() {
        var pass2 = document.getElementById("pw2").value;
        var pass1 = document.getElementById("pw1").value;
        if (pass1 != pass2)
            document.getElementById("pw2").setCustomValidity("Passwords Tidak Sama, Coba Lagi");
        else
            document.getElementById("pw2").setCustomValidity('');
	}
	
	function cek_password(value){
		var password = document.getElementById("password").value;
		var ulangi_password = value;

		if(ulangi_password != password){
			document.getElementById('erpr4').removeAttribute('style');

			//$("#spassnext").attr('disabled','disabled');

			$("#dur_pass4").attr('class','col-sm-10 has-error');

			$("#scpr4").attr('style','display: none;');
		}else{
			

			document.getElementById('scpr4').removeAttribute('style');

			//document.getElementById('spassnext').removeAttribute('disabled');

			$("#dur_pass4").attr('class','col-sm-10 has-success');

			$("#erpr4").attr('style','display: none;');
		}
	}

	function ubah() {
		link_edit = "ajax_edit";
        $.ajax({
            url : "<?php echo base_url('C_pengaturan/ajax_edit')?>",
            type: "GET",
            dataType: "JSON",
            success: function(result) {
            // //set_data1 dst menggambil data function mdl_setup "get_by_id" dan  email dst menenggambillya di id&name di bagian viewnya
            // console.log(result.set_header1);
            var img = '<?= base_url(); ?>assets/img/'+result.set_data4;
               $("#nama_toko").val(result.set_data1); 
			   $("#alamat_toko").val(result.set_data2);
			   $("#telp_toko").val(result.set_data3);
			   $('#preview-upload1').attr('src', img);   
			   		   
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
</script>


<?php $this->load->view('partials/footer.php') ?>
<?php $this->load->view('partials/js.php') ?>
