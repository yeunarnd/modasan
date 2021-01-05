<?php $this->load->view('partials/header.php') ?>

<!-- <link href="<?php echo base_url('assets') ?>/table/bootstrap-table.css" rel="stylesheet">
<script src="<?php echo base_url('assets') ?>/table/bootstrap-table.js"></script> -->
<script src="<?php echo base_url('assets') ?>/assets/js/sprintf.js"></script>
<style>
	/* .table>tbody>tr>td{
		vertical-align: middle;
		position: relative;
	} */
	.daftar-autocomplete {
		list-style: none;
		margin: 0;
		padding: 0;
		width: 106%;
		max-height: 350px;
	}

	.daftar-autocomplete li {
		padding: 5px 10px 5px 10px;
		background: #FAFAFA;
		border-bottom: #ddd 1px solid;
	}

	.daftar-autocomplete li:hover,
	.daftar-autocomplete li.autocomplete_active {
		background: #304ffe;
		color: #fff;
		cursor: pointer;
	}

	#hasil_pencarian {
		padding: 0px;
		display: none;
		position: absolute;
		overflow: auto;
		border: 1px solid #ddd;
		z-index: 1;
		width: 17%;
	}

	.--focus {
		background: #304ffe !important;
		color: white;
	}
</style>
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

				<img src="../../assets/assets/avatars/user.jpg" alt="Jason's Photo" />
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
						<img class="nav-user-photo" src="../../assets/assets/avatars/user.jpg" alt="Jason's Photo" />
						<span class="user-info">
							<small>Welcome,</small>
							Jason
						</span>
						<i class="ace-icon fa fa-caret-down"></i>
					</a>
					<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
						<li>
							<a href="">
								<i class="ace-icon fa fa-cog"></i>
								Settings
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="<?php echo base_url('C_login/logout') ?>">
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

	<!-- /section:basics/sidebar.horizontal -->
	<div class="main-content">
		<div class="main-content-inner">
			<div class="page-content">
				<div class="page-header">
					<h2 style="color: #07A1C8;">
						Penjualan

					</h2>
				</div><!-- /.page-header -->

				<div class="row">
					<div class="col-xs-12">
						<!-- PAGE CONTENT BEGINS -->

						<button type="button" data-toggle="modal" data-target="#tampilPenjualan" class="btn btn-success"><i class="fa fa-print"> Penjualan</i></button>

						<!-- Modal -->
						<div class="modal fade" id="tampilPenjualan" tabindex="-1">
							<div class="modal-dialog modal-lg" style='width: 1100px;'>
								<div class="modal-content">
									<div class="modal-header">
										<h3 class="modal-title" id="exampleModalLabel">Penjualan</h3>
									</div>
									<div class="modal-body">
										<form method='post' action='<?php echo base_url('C_penjualan/simpan_penjualan') ?>'>
											<div class="row">
												<div class="col-xs-12">

													<div class="col-md-5">
														<br>
														<br>
														<br>
														<br>
														<br>
														<br>
														<div class="form-group row">


														</div>
													</div>
													<div class="col-md-1 ">

													</div>
													<div class="col-md-6">
														<div class="form-group row">
															<label for="inputPassword" class="col-sm-4 col-form-label">Faktur</label>
															<div class="col-sm-8">
																<input type="text" name="fc_noinv" class="form-control" id="no_nota" placeholder="" readonly>
															</div>
														</div>
														<div class="form-group row">
															<label for="inputPassword" class="col-sm-4 col-form-label">Tanggal</label>
															<?php
															$tgl = date("Y-m-d");
															?>
															<div class="col-sm-8">
																<input type="text" class="form-control" name="fd_tgliv" id="inputPassword" value="<?= $tgl ?>" readonly>
															</div>
														</div>
														<div class="form-group row">
															<label for="inputPassword" class="col-sm-2 col-form-label">Sales</label>
															<!-- <div class="col-sm-8"> -->
															<div class="col-sm-2">
																<input type="hidden" class="form-control pull-right" id="inputPassword" name="fc_salesid_view" placeholder="Kode">
															</div>
															<div class="col-sm-5">
																<!-- <input type="text" class="form-control" id="inputPassword" name="fv_nmpelanggan_view" placeholder="Nama"> -->
																<span id='nama_sales'></span>
															</div>
															<div class="col-sm-3">
																<div class="col-sm-6">
																	<button type="button" class="btn-sm btn-primary" data-toggle="modal" data-target="#carisales">
																		<i class=" ace-icon glyphicon glyphicon-search"></i>
																	</button>
																</div>
															</div>
															<!-- </div> -->
														</div>
														<div class="form-group row">
															<label for="inputPassword" class="col-sm-2 col-form-label">Pelanggan</label>
															<div class="col-sm-2">
																<input type="hidden" class="form-control pull-right" id="inputPassword" name="fc_kdpel_view" placeholder="Kode">
															</div>
															<div class="col-sm-5">
																<!-- <input type="text" class="form-control" id="inputPassword" name="fv_nmpelanggan_view" placeholder="Nama"> -->
																<span id='nama_pelanggan'></span>
															</div>
															<div class="col-sm-3">
																<div class="col-sm-6">
																	<button type="button" class="btn-sm btn-primary" data-toggle="modal" data-target="#caripelanggan">
																		<i class=" ace-icon glyphicon glyphicon-search"></i>
																	</button>
																</div>
																<div class="col-sm-6">
																	<button type="button" class="btn-sm btn-primary" data-toggle="modal" data-target="#tambahpelanggan">
																		<i class=" ace-icon glyphicon glyphicon-plus"></i>
																	</button>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<table class="table table-bordered" id="tableTransaksi">
												<thead>
													<tr>
														<th scope="col">No</th>
														<th scope="col">Kode</th>
														<th scope="col">Uraian Barang</th>
														<th scope="col">Berat</th>
														<th scope="col">Kadar</th>
														<th scope="col">Harga Per Gram</th>
														<th scope="col">Ongkos</th>
														<th scope="col">Diskon</th>
														<th scope="col">Total Harga</th>
														<th scope="col">Hapus</th>
													</tr>
												</thead>
												<tbody>

												</tbody>
											</table>
											
											<div class="row">
												<div class="col-xs-12">
													<div class="col-md-2">
														<div>
															<div id="foto">

															</div>
															<button type="button" class="btn-sm btn-primary" id="BarisBaru">
																<i class="ace-icon glyphicon glyphicon-plus"> Baris Baru</i>
															</button>
														</div>
													</div>
													<div class="col-md-4">
													<div id="preview-upload" ></div>
													</div>
													<div class="col-md-6">
														<div class="form-group row">
															<div class="col-sm-1">
															</div>
															<label class="col-sm-3 col-form-label">Subtotal</label>
															<div class="col-sm-8">
																<input type="text" class="form-control" id="SubTotalBayar" name='SubTotalBayar' readonly>
																<input type="hidden" class="form-control" id="SubTotalBayar2" name='SubTotalBayar2' readonly>
																<input type="hidden" class="form-control" id="TotalOngkir" name='TotalOngkir'>
																<input type="hidden" class="form-control" id="TotalDiskon" name='TotalDiskon'>
																<!-- <span id="subtotal"></span> -->
															</div>
														</div>
														<div class="form-group row">
															<div class="col-sm-1">
															</div>
															<label class="col-sm-3 col-form-label">GrandTotal</label>
															<div class="col-sm-8">
																<input type="text" class="form-control" id="TotalBayar" name='TotalBayar' readonly>
																<input type="hidden" class="form-control" id="TotalBayar2" name='TotalBayar2' readonly>
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-2 col-form-label">Terbilang</label>
															<div class="col-sm-10">
																<input type="text" class="form-control" name="terbilang" readonly placeholder="" id="terbilang">
															</div>
														</div>
													</div>
												</div>
											</div>
											<button class="btn btn-primary" type="submit"><i class="fa fa-save"> Simpan</i></button>
										</form>
									</div>

								</div>

							</div>
						</div>
					</div>

					<!-- /section:settings.box -->

				</div><!-- /.page-header -->

				<div class="row">
					<div class="col-xs-12">
						<!-- PAGE CONTENT BEGINS -->

						<!-- Modal -->
						<div class="modal fade" id="tambahpelanggan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog ">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Tambah Pelanggan</h5>
									</div>
									<div class="modal-body">
										<div class="row">
											<div class="col-xs-12">
												<form method="post" action="<?= base_url('C_penjualan/save_datapelanggan') ?>" enctype="multipart/form-data">
													<div class="col-md-12">
														<div class="form-group row">
															<label for="kode" class="col-sm-4 col-form-label">Kode</label>
															<div class="col-sm-8">
																<input type="text" name="fc_kdpel" class="form-control" id="kode" placeholder="Kode">
																<?= form_error('fc_kdpel', '<small class="text-danger pl-3">', '</small>') ?>
															</div>
														</div>
														<div class="form-group row">
															<label for="" class="col-sm-4 col-form-label">Nama</label>
															<div class="col-sm-8">
																<input type="text" name="fv_nmpelanggan" class="form-control" id="" placeholder="Nama">
																<?= form_error('fv_nmpelanggan', '<small class="text-danger pl-3">', '</small>') ?>
															</div>
														</div>
														<div class="form-group row">
															<label for="" class="col-sm-4 col-form-label">Alamat</label>
															<div class="col-sm-8">
																<input type="text" name="f_alamat" class="form-control" id="" placeholder="Alamat">
																<?= form_error('f_alamat', '<small class="text-danger pl-3">', '</small>') ?>
															</div>
														</div>
														<div class="form-group row">
															<label for="" class="col-sm-4 col-form-label">No Hp</label>
															<div class="col-sm-8">
																<input type="text" name="fc_telp" class="form-control" id="" placeholder="No Hp">
																<?= form_error('fc_telp', '<small class="text-danger pl-3">', '</small>') ?>
															</div>
														</div>
														<div class="form-group row">
															<label for="" class="col-sm-4 col-form-label">No KTP</label>
															<div class="col-sm-8">
																<input type="text" name="fc_noktp" class="form-control" id="" placeholder="No KTP">
																<?= form_error('fc_noktp', '<small class="text-danger pl-3">', '</small>') ?>
															</div>
														</div>
														<div class="form-group row">
															<label for="" class="col-sm-4 col-form-label">Keterangan</label>
															<div class="col-sm-8">
																<input type="text" name="f_keterangan" class="form-control" id="" placeholder="Keterangan">
																<?= form_error('f_keterangan', '<small class="text-danger pl-3">', '</small>') ?>
															</div>
														</div>
													</div>
													<button type="submit" class="btn btn-primary">Simpan</button>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- PAGE CONTENT ENDS -->
						</div>


						<div class="modal fade" id="carisales" tabindex="-1">
							<div class="modal-dialog ">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Cari Sales</h5>
									</div>
									<div class="modal-body">
										<div class="row">
											<div class="col-xs-12">
												<div class="col-md-12">
													<table id="myTable2" class="display">
														<thead>
															<tr>
																<th class="center">
																	Ceklist
																</th>
																<th>
																	Nama Sales
																</th>
																<th>
																	Email
																</th>
																<th>
																	No Hp
																</th>	
															</tr>
														</thead>
														<tbody>
															<?php $i = 1;
															foreach ($sales as $s) : ?>
																<tr>
																	<td class="center">
																		<label class="pos-rel check-sales">
																			<input type="checkbox" class="check-sales" value="<?= $s->fc_salesid ?>" />
																			<span class="lbl"></span>
																		</label>
																	</td>
																	<td><?= $s->fv_nama ?> </td>
																	<td><?= $s->fc_email ?> </td>
																	<td><?= $s->fc_hp ?> </td>
																</tr>
															<?php endforeach; ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-2" style="margin-top: 5px;">
												<button type="button" data-dismiss="modal" class="btn btn-primary action-select-sales">Pilih</button>

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="modal fade" id="caripelanggan" tabindex="-1">
							<div class="modal-dialog ">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Cari Pelanggan</h5>
									</div>
									<div class="modal-body">
										<div class="row">
											<div class="col-xs-12">
												<div class="col-md-12">
													<table id="myTable" class="display">
														<thead>
															<tr>
																<th class="center">
																	Ceklist
																</th>
																<th>
																	Nama Pelanggan
																</th>
																<th>
																	Alamat
																</th>
																<th>
																	No Telp
																</th>
															</tr>
														</thead>
														<tbody>
															<?php $i = 1;
															foreach ($pelanggan as $p) : ?>
																<tr>
																	<td class="center">
																		<label class="pos-rel check">
																			<input type="checkbox" class="check" value="<?= $p->fc_kdpel ?>" />
																			<span class="lbl"></span>
																		</label>
																	</td>
																	<td><?= $p->fv_nmpelanggan ?> </td>
																	<td><?= $p->f_alamat ?> </td>
																	<td><?= $p->fc_telp ?> </td>
																</tr>
															<?php endforeach; ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-2" style="margin-top: 5px;">
												<button type="button" data-dismiss="modal" class="btn btn-primary action-select">Pilih</button>

											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- PAGE CONTENT ENDS -->
						</div>


						<!-- /.col -->
						<div class="modal fade" id="pilihbarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-lg ">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Pilih Barang</h5>
									</div>
									<div class="modal-body">
										<div class="row">
											<div class="col-xs-12">
												<!-- <table id="barang_perintah" data-toggle="table" data-url="<?php echo base_url('C_penjualan/get_barang_tampil'); ?>" data-search="true"  data-server-side="true" data-sort-order="desc" data-pagination="true">
												<thead>
													<tr>
														<th data-formatter="runningFormatter" data-sortable="true">No</th>
														<th data-field="fc_kdstock"  data-sortable="true">Kode Barang</th>
														<th data-field="fv_nmbarang"  data-sortable="true">Nama</th>
														<th data-field="fv_nmlokasi"  data-sortable="true" data-align="right">Lokasi</th>
														<th data-field="fv_nmkelompok"  data-sortable="true" data-align="right">Kelompok</th>
														<th data-field="ff_berat"  data-sortable="true" data-align="right">Berat</th>
														<th data-field="fc_kadar"  data-sortable="true" >Kadar </th>
														<th data-field="fc_sts"  data-sortable="true" data-formatter="sts">Status</th>
													</tr>
												</thead>
											</table> -->
												<table class="table table-bordered" id="tableBarang" style="width: 100%">
													<thead>
														<tr>
															<th>No</th>
															<th>Kode Barang</th>
															<th>Nama</th>
															<th>Lokasi</th>
															<th>Kelompok</th>
															<th>Berat</th>
															<th>Kadar</th>
															<th>Aksi</th>
														</tr>
													</thead>
													<tbody>

													</tbody>
												</table>
												
											</div>
										</div>


									</div>
								</div>
							</div>

							<!-- PAGE CONTENT ENDS -->
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.page-content -->
			</div>
		</div><!-- /.main-content -->
	</div>
</div>

<script>
	let dataBarang;
	var table2;
	$(document).ready(function() {
		getDataBarang();
		BarisBaru();
		//detail_barang();
		$('html, body').animate({
			scrollTop: 0
		}, 0);
		$.ajax({
			url: "<?php echo base_url() . 'C_penjualan/max_nota'; ?>",
			dataType: 'json',
			method: 'POST',
			success: function(json) {
				var d = "<?php echo $day ?>";
				var m = "<?php echo $month ?>";
				var y = "<?php echo $years ?>";

				if (json.maxs == null) {
					max = 'PJ' + '' + y + '' + m + '' + d + '-' + '00000';
				} else {
					max = json.maxs;
				}

				var ambil_tanggal = max.substring(8, 10);
				console.log('max', max);
				console.log('ambil_tanggal', ambil_tanggal);

				if (d == ambil_tanggal) {
					// urut = max.substring(18, 20);
					urut = max.split('-')[1];
				} else {
					urut = "000";
				}

				urut++;
				//console.log(urut);
				var kodene = sprintf("%05s", urut);

				var invoice = 'PJ' + '' + y + '' + m + '' + d + '-' + kodene;
				console.log('invoice' + invoice);
				$('#no_nota').val(invoice);
			}
		});
	});

	function detail_barang(id) {
		$('#pilihbarang').modal('show');
		table2 = $('#tableBarang').DataTable({

			"processing": true, //Feature control the processing indicator.
			"serverSide": true,
			"bDestroy": true,
			"order": [], //Initial no order.

			// Load data for the table's content from an Ajax source
			"ajax": {
				"url": "<?php echo base_url() ?>C_penjualan/ajax_listall/" + id,
				"type": "POST"
			},


			order: [1, 'asc']

		}).fnDestroy();
		table2.ajax.reload();
	}

	$('#BarisBaru').on('click', function() {
		BarisBaru();
	});

	function runningFormatter(value, row, index) {
		return index + 1;
	}

	$(document).on('click', '#HapusBaris', function(e) {
		e.preventDefault();
		if ($(this).parent().parent().find("#pencarian_kode").val() == "") {
			$(this).parent().parent().remove();
			var Nomor = 1;
			$('#tableTransaksi tbody tr').each(function() {
				$(this).find('td:nth-child(1)').html(Nomor);
				Nomor++;
			})
			HitungTotalBayar();
		} else {
			$(this).parent().parent().remove();
			var Nomor = 1;
			$('#tableTransaksi tbody tr').each(function() {
				$(this).find('td:nth-child(1)').html(Nomor);
				Nomor++;
			})
			HitungTotalBayar();
		}
	});

	function BarisBaru() {
		var Nomor = $('#tableTransaksi tbody tr').length + 1;

		// 0
		var Baris = "<tr>";
		Baris += "<td>" + Nomor + "</td>";

		// 1
		Baris += "<td style='display: flex;height: 58px;'>";
		Baris += "<input autocomplete='off' required  type='text' class='form-control kode_barang" + Nomor + "' name='kode_barang[]' id='pencarian_kode' placeholder='Ketik Kode / Nama Barang'><button type='button' class='btn-sm btn-success' onclick='detail_barang(" + Nomor + ")' style='margin-left: 4px;'> <i class='ace-icon glyphicon glyphicon-search'></i></button>";
		Baris += "<div id='hasil_pencarian' class='hasil_pencarian'></div>";
		Baris += "</td>";

		// 2
		Baris += "<td>";
		Baris += '<span class="nama_barang' + Nomor + '"></span>';
		Baris += "</td>";

		// 3
		Baris += "<td>";
		Baris += '<span class="berat' + Nomor + '"></span>';
		Baris += "</td>";
		// Baris += "<td>";
		// Baris += "<input required  type='hidden' name='harga_satuan[]'> <input type='hidden' id='id_barang' name='id_barang[]' /> <input type='hidden' id='id_varian_harga' name='id_varian_harga[]' /><input type='hidden' id='harga_jual' name='harga_jual[]' /><input type='hidden' id='stok_min' name='stok_min[]' />";
		// Baris += "<span></span>";
		// Baris += "</td>";

		// 4
		Baris += "<td>";

		Baris += '<span class="kadar' + Nomor + '"></span>';
		Baris += "</td>";
		// Baris += "<td><input type='hidden' id='berat_emas' name='berat_emas'></td>";
		// Baris += "<div style='display: flex;'>"
		// Baris += '<button id="minus_jumlah" type="button" class="btn btn-success pull-left" style="padding: 5px;"><i class="fa fa-minus fa-fw"></i></button>';
		// Baris += "<input required type='text' class='form-control col-md' id='jumlah_beli' name='jumlah_beli[]' style='width: 62px; margin: 0 5px;'  disabled><input type='hidden' id='harga_jual' name='harga_jual[]' /><input type='hidden' id='stok_min' name='stok_min[]' />";
		// Baris += '<button id="plus_jumlah" type="button" class="btn btn-success pull-left" style="padding: 5px;"><i class="fa fa-plus fa-fw"></i></button>';
		// Baris += "</div>"
		// Baris += "</td>";

		// 5
		Baris += "<td><input type='number' name='harga_pergram[]' id='harga_pergram' class='form-control harga_pergram" + Nomor + "'></td>";
		// Baris += "<td>";
		// Baris += "<input  required type='hidden' name='sub_total[]'>";
		// Baris += '<span></span>';
		// Baris += "</td>";
		// 5
		Baris += "<td><input type='number' name='ongkoskirim[]' id='ongkoskirim' class='form-control ongkos_kirim" + Nomor + "'></td>";

		//6
		Baris += "<td><input type='number' name='diskon[]' id='diskon' class='form-control diskon" + Nomor + "'></td>";

		// 7
		Baris += "<td>";
		Baris += "<input  required type='hidden' name='sub_total[]' id='sub_total' class='sub_total" + Nomor + "'>";
		Baris += "<input type='hidden' id='berat_emas' name='berat_emas[]' class='berat_emas" + Nomor + "'>";
		Baris += "<input type='hidden' id='kadar_emas' name='kadar_emas[]' class='kadar_emas" + Nomor + "'>";
		Baris += "<input type='hidden' id='kode_kelompok' name='kode_kelompok[]' class='kode_kelompok" + Nomor + "'>";
		Baris += '<span></span>';
		Baris += "</td>";

		Baris += "<td><button  class='btn btn-danger' id='HapusBaris'><i class='fa fa-times' style='color:white;'></i></button></td>";
		Baris += "</tr>";

		$('#tableTransaksi').append(Baris);
		// Fokus Input
		$('#tableTransaksi tbody tr').each(function() {
			$(this).find('td:nth-child(2) input').focus();
		});
	}

	function getDataBarang() {
		$.ajax({
			url: "<?php echo base_url() ?>C_penjualan/getDataBarang",
			method: 'POST',
			dataType: 'JSON',
			success: function(json) {
				console.log(json);
				dataBarang = json.datanya;
			}
		})
	}

	let intervalPress;

	function cariBarang(keyword, Indexnya, foundItem) {
		let htmlFoundItem = "<ul id='daftar-autocomplete' class='daftar-autocomplete'>";
		foundItem.forEach((b, i) => {
			//	var b.stok_gudang = 0;
			if (i == 0) {
				htmlFoundItem += '<li class="--focus">';
			} else {
				htmlFoundItem += '<li>';
			}

			htmlFoundItem += `
					<b>Kode</b> : 
					`
				// <span id='kodenya'>` + b.kode_barang + `</span> <br />
				+
				`
					<span id='barcodenya'>` + b.fc_barcode + `</span> <br />
					<span id='kodestocknya'>` + b.fc_kdstock + `</span> <br />
					<span id='barangnya'>` + b.fv_nmbarang + `</span><br />
					<span id='beratnya' style='display:none;'>` + b.ff_berat + `</span>
					<span id='kadarnya' style='display:none;'>` + b.fc_kadar + `</span>
					<span id='hargajualnya' style='display:none;'>` + b.fm_hargajual + `</span>
					<span id='ongkosnya' style='display:none;'>` + b.fm_ongkos + `</span>
					<span id='kelompoknya' style='display:none;'>` + b.fc_kdkelompok + `</span>
					<span id='fotonya' style='display:none;'>` + b.f_foto + `</span>
				</li>
			`;
		})
		htmlFoundItem += "</ul>";

		if (foundItem.length > 0 && keyword != "") {
			$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(2)').find('div#hasil_pencarian').show('fast');
			$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(2)').find('div#hasil_pencarian').html(htmlFoundItem);
		} else {
			let tidakAda = '<ul class="daftar-autocomplete"><li> <span>Data Tidak Ditemukan</span></li><ul>'
			$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(2)').find('div#hasil_pencarian').html(tidakAda);
			$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(2)').find('div#hasil_pencarian').show('fast');
		}
		return foundItem.length;
	}

	let tempKeyword = false;
	$(document).on('keyup', '#pencarian_kode', function(e) {
		var keyword = $(this).val();
		var Indexnya = $(this).parent().parent().index();
		var key = e.which || e.keyCode;
		if (e.which == 40) {
			$(this).select();
			$(this).parent().find("#hasil_pencarian > #daftar-autocomplete li").each(function(i, e) {
				if ($(this).hasClass("--focus") && i < $(this).parent().find('li').length - 1) {
					$(this).removeClass("--focus");
					$(this).parent().find('li').each(function(ii, e) {
						if (ii == (i + 1)) {
							$(this).addClass("--focus");
							if ($(this).position().top > 350) {
								$(this).parent().parent().scrollTop($(this).parent().parent().scrollTop() + 71);
							}
						}
					})
					return false;
				}
			})
			e.preventDefault();
			return false;
		} else if (e.which == 38) {
			$(this).select();
			$(this).parent().find("#hasil_pencarian > #daftar-autocomplete li").each(function(i, e) {
				if ($(this).hasClass("--focus") && i != 0) {
					$(this).removeClass("--focus");
					$(this).parent().find('li').each(function(ii, e) {
						if (ii == (i - 1)) {
							$(this).addClass("--focus");
							if ($(this).position().top < 0) {
								$(this).parent().parent().scrollTop($(this).parent().parent().scrollTop() - 71);
							}
						}
					})
					return false;
				}
			})
			e.preventDefault();
			return false;
		} else if (e.which == 13) {
			$(this).select();
			let foundItem = [];
			for (let i = 0; i < dataBarang.length; i++) {
				let reg = new RegExp('^' + keyword + '.*$', 'i');
				if (
					// dataBarang[i].kode_barcode_varian == keyword ||
					// dataBarang[i].kode_barang.match(reg) || 
					// dataBarang[i].nama_barang.includes(keyword) || 
					((dataBarang[i].fc_barcode ? dataBarang[i].fc_barcode : '').toLowerCase()).includes(keyword.toLowerCase()) ||
					((dataBarang[i].fc_kdstock ? dataBarang[i].fc_kdstock : '').toLowerCase()).includes(keyword.toLowerCase()) ||
					((dataBarang[i].fv_nmbarang ? dataBarang[i].fv_nmbarang : '').toLowerCase()).includes(keyword.toLowerCase())
				) {
					foundItem.push(dataBarang[i])
				}
			}

			// foundItem = [foundItem[0]];

			if (foundItem.length > 1) {
				if ($(this).parent().find('#hasil_pencarian > #daftar-autocomplete').is(':visible') && tempKeyword) {
					$(this).parent().find("#hasil_pencarian > #daftar-autocomplete li").each(function(i, e) {
						if ($(this).hasClass('--focus')) {
							$(this).parent().parent().parent().find('input').val($(this).find('span#kodestocknya').html());

							var Indexnya = $(this).parent().parent().parent().parent().index();
							var KodeBarcode = $(this).find('span#barcodenya').html();
							var KodeStock = $(this).find('span#kodestocknya').html();
							var NamaBarang = $(this).find('span#barangnya').html();
							//var Harganya 	  = $(this).find('span#harganya').html();
							var Berat = $(this).find('span#beratnya').html();
							//console.log('IdBarang'+IdBarang);
							var Kadar = $(this).find('span#kadarnya').html();
							//console.log('IdVarianHarga'+IdVarianHarga);
							var HargaJual = $(this).find('span#hargajualnya').html();
							var Ongkos = $(this).find('span#ongkosnya').html();
							var Kelompok = $(this).find('span#kelompoknya').html();
							var Foto = $(this).find('span#fotonya').html();


							$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(2)').find('div#hasil_pencarian').hide();
							$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(3)').html(NamaBarang);
							$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input#berat_emas').val(Berat);
							$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(4)').html(Berat + ' Gram');
							$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(5)').html(Kadar + ' %');
							$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input#harga_pergram').val(0);
							$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(7) input#ongkoskirim').val(Ongkos);
							$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) input#diskon').val(0);
							$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input#kadar_emas').val(Kadar);
							$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input#kode_kelompok').val(Kelompok);
							$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input#sub_total').val(0);
							// $('#tableTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input#jumlah_beli').removeAttr('disabled').val(1);

							if(Foto==""){
								var fotonya = "no_image.jpg";
							}else{
								var fotonya = Foto;
							}

							var image = document.createElement("img");
							image.src = '<?= base_url(); ?>assets/img/foto_barang/new/'+fotonya;
							image.style = 'width:99px;margin: 5px;';
							var src = document.getElementById("preview-upload");
							src.appendChild(image);

							var IndexIni = Indexnya + 1;
							var TotalIndex = $('#tableTransaksi tbody tr').length;
							if (IndexIni == TotalIndex) {
								//BarisBaru();
								$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input').focus();
								// $('html, body').animate({ scrollTop: $(document).height() }, 0);
							} else {
								$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input').focus();
							}
							//HitungTotalBayar();
						}
					})
				} else {
					cariBarang(keyword, Indexnya, foundItem);
					tempKeyword = true;
				}
			} else {
				cariBarang(keyword, Indexnya, foundItem);
				$(this).parent().find("#hasil_pencarian > #daftar-autocomplete li").each(function(i, e) {
					if ($(this).hasClass('--focus')) {
						$(this).parent().parent().parent().find('input').val($(this).find('span#kodestocknya').html());

						var Indexnya = $(this).parent().parent().parent().parent().index();
						var KodeBarcode = $(this).find('span#barcodenya').html();
						var KodeStock = $(this).find('span#kodestocknya').html();
						var NamaBarang = $(this).find('span#barangnya').html();
						//var Harganya 	  = $(this).find('span#harganya').html();
						var Berat = $(this).find('span#beratnya').html();
						//console.log('IdBarang'+IdBarang);
						var Kadar = $(this).find('span#kadarnya').html();
						//console.log('IdVarianHarga'+IdVarianHarga);
						var HargaJual = $(this).find('span#hargajualnya').html();
						var Ongkos = $(this).find('span#ongkosnya').html();
						var Kelompok = $(this).find('span#kelompoknya').html();
						var Foto = $(this).find('span#fotonya').html();

						$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(2)').find('div#hasil_pencarian').hide();
						$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(3)').html(NamaBarang);
						$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input#berat_emas').val(Berat);
						$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(4)').html(Berat + ' Gram');
						$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(5)').html(Kadar + ' %');
						$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input#harga_pergram').val(0);
						$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(7) input#ongkoskirim').val(Ongkos);
						$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) input#diskon').val(0);
						$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input#kadar_emas').val(Kadar);
						$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input#kode_kelompok').val(Kelompok);
						$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input#sub_total').val(0);

						if(Foto==""){
							var fotonya = "no_image.jpg";
						}else{
							var fotonya = Foto;
						}

						var image = document.createElement("img");
						image.src = '<?= base_url(); ?>assets/img/foto_barang/new/'+fotonya;
						image.style = 'width:99px;margin: 5px;';
						var src = document.getElementById("preview-upload");
						src.appendChild(image);

						var IndexIni = Indexnya + 1;
						var TotalIndex = $('#tableTransaksi tbody tr').length;
						if (IndexIni == TotalIndex) {
							//BarisBaru();
							$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input').focus();
						} else {
							$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input').focus();
						}
						//HitungTotalBayar();

					}
				})
			}
		} else {
			tempKeyword = false;
		}
	})

	$(document).on('click', '#daftar-autocomplete li', function() {
		$(this).parent().find(".--focus").each(function() {
			$(this).removeClass("--focus");
		})
		$(this).addClass("--focus");
		$(this).parent().parent().parent().find('input').val($(this).find('span#kodestocknya').html());

		var Indexnya = $(this).parent().parent().parent().parent().index();
		var KodeBarcode = $(this).find('span#barcodenya').html();
		var KodeStock = $(this).find('span#kodestocknya').html();
		var NamaBarang = $(this).find('span#barangnya').html();
		//var Harganya 	  = $(this).find('span#harganya').html();
		var Berat = $(this).find('span#beratnya').html();
		//console.log('IdBarang'+IdBarang);
		var Kadar = $(this).find('span#kadarnya').html();
		//console.log('IdVarianHarga'+IdVarianHarga);
		var HargaJual = $(this).find('span#hargajualnya').html();
		var Ongkos = $(this).find('span#ongkosnya').html();
		var Kelompok = $(this).find('span#kelompoknya').html();
		var Foto = $(this).find('span#fotonya').html();


		$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(2)').find('div#hasil_pencarian').hide();
		$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(3)').html(NamaBarang);
		$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input#berat_emas').val(Berat);
		$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(4)').html(Berat + ' Gram');
		$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(5)').html(Kadar + ' %');
		$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input#harga_pergram').val(0);
		$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(7) input#ongkoskirim').val(Ongkos);
		$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) input#diskon').val(0);
		$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input#kadar_emas').val(Kadar);
		$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input#kode_kelompok').val(Kelompok);
		$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input#sub_total').val(0);

		if(Foto==""){
			var fotonya = "no_image.jpg";
		}else{
			var fotonya = Foto;
		}

		var image = document.createElement("img");
		image.src = '<?= base_url(); ?>assets/img/foto_barang/new/'+fotonya;
		image.style = 'width:99px;margin: 5px;';
		var src = document.getElementById("preview-upload");
		src.appendChild(image);


		var IndexIni = Indexnya + 1;
		var TotalIndex = $('#tableTransaksi tbody tr').length;
		if (IndexIni == TotalIndex) {
			//BarisBaru();
			$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input').focus();
			// $('html, body').animate({ scrollTop: $(document).height() }, 0);
		} else {
			$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input').focus();
		}
		//HitungTotalBayar();	

	});

	function pencarian_kode(fc_barcode, fc_kdstock, fv_nmbarang, fc_kdkelompok, fc_kdlokasi, ff_berat, fc_kadar, fm_ongkos, fm_hargabeli, fm_hargajual, Nomor, f_foto) {
		$('.kode_barang' + Nomor).val(fc_kdstock);
		$('.nama_barang' + Nomor).html(fv_nmbarang);
		$('.berat' + Nomor).html(ff_berat + ' Gram');
		$('.kadar' + Nomor).html(fc_kadar + ' %');
		$('.harga_pergram' + Nomor).val(0);
		$('.diskon' + Nomor).val(0);
		$('.ongkos_kirim' + Nomor).val(fm_ongkos);
		$('.berat_emas' + Nomor).val(ff_berat);
		$('.kadar_emas' + Nomor).val(fc_kadar);
		$('.kode_kelompok' + Nomor).val(fc_kdkelompok);

		if(f_foto==""){
			var fotonya = "no_image.jpg";
		}else{
			var fotonya = f_foto;
		}
		// var img = '<?= base_url(); ?>assets/img/foto_barang/'+f_foto;
		// console.log('img', img);
		// //$('#preview-upload').attr('src', img);   

		// $('#preview-upload').attr('src', img);

		var image = document.createElement("img");
		image.src = '<?= base_url(); ?>assets/img/foto_barang/new/'+fotonya;
		image.style = 'width:99px;margin: 5px;';
		var src = document.getElementById("preview-upload");
		src.appendChild(image);
		//HitungTotalBayar();	
		$('#pilihbarang').modal('hide');
	}

	$(document).on('keyup', '#harga_pergram', function() {
		var Indexnya = $(this).parent().parent().index();

		var Berat_emas = $('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input#berat_emas').val();
		var Ongkir = $('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(7) input#ongkoskirim').val();
		var Harga_emas = $(this).val();
		var Diskon = $('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) input#diskon').val();

		var SubTotal = parseFloat(Berat_emas) * parseInt(Harga_emas);
		if (SubTotal > 0) {
			var SubTotalVal = SubTotal;
			SubTotal = to_rupiah(SubTotal);
		} else {
			SubTotal = '';
			var SubTotalVal = 0;
		}
		// var SubTotalVal = Math.round(SubTotal / 1000) * 1000;
		var SubTotal2 = parseFloat(Berat_emas) * parseInt(Harga_emas) + parseInt(Ongkir);
		if (SubTotal2 > 0) {
			var SubTotalVal2 = SubTotal2;
			SubTotal2 = to_rupiah(SubTotal2);
		} else {
			SubTotal2 = '';
			var SubTotalVal2 = 0;
		}
		$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input#sub_total').val(Number(Math.round((Math.round(SubTotalVal2 / 1000) * 1000) + 'e2') + 'e-2'));
		$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) span').html(Number(Math.round((Math.round(SubTotalVal2 / 1000) * 1000) + 'e2') + 'e-2'));
		// console.log(Number(Math.round((Math.round(SubTotalVal / 1000) * 1000) + 'e2') + 'e-2'))
		// console.log(Number(Math.round((Math.round(SubTotalVal2 / 1000) * 1000) + 'e2') + 'e-2'))
		console.log(SubTotal)
		console.log(SubTotalVal2)
		HitungTotalBayar();
	});

	$(document).on('keyup', '#ongkoskirim', function() {
		var Indexnya = $(this).parent().parent().index();
		var Berat_emas = $('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input#berat_emas').val();
		// var Ongkir = $('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(7) input#ongkoskirim').val();
		var Harga_emas = $('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input#harga_pergram').val();
		var Ongkir = $(this).val();
		var Diskon = $('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) input#diskon').val();

		var SubTotal = (parseFloat(Berat_emas) * parseInt(Harga_emas)) + (parseInt(Ongkir));
		if (SubTotal > 0) {
			var SubTotalVal = SubTotal;
			SubTotal = to_rupiah(SubTotal);
		} else {
			SubTotal = '';
			var SubTotalVal = 0;
		}

		var SubTotal2 = (parseFloat(Berat_emas) * parseInt(Harga_emas) + parseInt(Ongkir)) - (parseInt(Diskon));
		if (SubTotal2 > 0) {
			var SubTotalVal2 = SubTotal2;
			SubTotal2 = to_rupiah(SubTotal2);
		} else {
			SubTotal2 = '';
			var SubTotalVal2 = 0;
		}

		$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input#sub_total').val(Math.round(Number(Math.round((Math.round(SubTotalVal2 / 1000) * 1000) + 'e2') + 'e-2')));
		$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) span').html(Number(Math.round((Math.round(SubTotalVal2 / 1000) * 1000) + 'e2') + 'e-2'));
		HitungTotalBayar();
	})

	$(document).on('keyup', '#diskon', function() {
		var Indexnya = $(this).parent().parent().index();

		var Berat_emas = $('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input#berat_emas').val();
		var Ongkir = $('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(7) input#ongkoskirim').val();
		var Harga_emas = $('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input#harga_pergram').val();
		var Diskon = $(this).val();

		var SubTotal = (parseFloat(Berat_emas) * parseInt(Harga_emas)) - (parseInt(Diskon));
		if (SubTotal > 0) {
			var SubTotalVal = SubTotal;
			SubTotal = to_rupiah(SubTotal);
		} else {
			SubTotal = '';
			var SubTotalVal = 0;
		}

		var SubTotal2 = (parseFloat(Berat_emas) * parseInt(Harga_emas) + parseInt(Ongkir)) - (parseInt(Diskon));
		if (SubTotal2 > 0) {
			var SubTotalVal2 = SubTotal2;
			SubTotal2 = to_rupiah(SubTotal2);
		} else {
			SubTotal2 = '';
			var SubTotalVal2 = 0;
		}

		$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input#sub_total').val(Number(Math.round((Math.round(SubTotalVal2 / 1000) * 1000) + 'e2') + 'e-2'));
		$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) span').html(Number(Math.round((Math.round(SubTotalVal2 / 1000) * 1000) + 'e2') + 'e-2'));
		HitungTotalBayar();
	})


	function HitungTotalBayar() {
		var Total = 0;
		var TotalOngkos = 0;
		var TotalDiskon = 0;
		$('#tableTransaksi tbody tr').each(function() {
			if ($(this).find('td:nth-child(9) input#sub_total').val() > 0) {
				var SubTotal = $(this).find('td:nth-child(9) input#sub_total').val();
				Total = parseInt(Total) + parseInt(SubTotal);
			}
		});

		$('#tableTransaksi tbody tr').each(function() {
			if ($(this).find('td:nth-child(7) input#ongkoskirim').val() > 0) {
				var SubTotalOngkos = $(this).find('td:nth-child(7) input#ongkoskirim').val();
				TotalOngkos = parseInt(TotalOngkos) + parseInt(SubTotalOngkos);
			}
		});

		$('#tableTransaksi tbody tr').each(function() {
			if ($(this).find('td:nth-child(8) input#diskon').val() > 0) {
				var SubTotalDiskon = $(this).find('td:nth-child(8) input#diskon').val();
				TotalDiskon = parseInt(TotalDiskon) + parseInt(SubTotalDiskon);
			}
		});
		console.log('Total', Total);
		$('#TotalBayar').val(to_rupiah(Total));
		$('#SubTotalBayar').val(to_rupiah(Total));

		$('#TotalBayar2').val(Total);
		$('#SubTotalBayar2').val(Total);

		$('#TotalOngkir').val(TotalOngkos);
		$('#TotalDiskon').val(TotalDiskon);

		$('#terbilang').val(sayit(Total));

		// $('#UangCash').val('');
		// $('#UangDebit').val('');
		// $('#UangKembali').val('');
	}

	function to_rupiah(angka) {
		var rev = parseInt(angka, 10).toString().split('').reverse().join('');
		var rev2 = '';
		for (var i = 0; i < rev.length; i++) {
			rev2 += rev[i];
			if ((i + 1) % 3 === 0 && i !== (rev.length - 1)) {
				rev2 += '.';
			}
		}
		return rev2.split('').reverse().join('');
	}

	var thoudelim = ".";
	var decdelim = ",";
	var curr = "Rp ";
	var d = document;

	// format(1000000.5,3) : 1.000.000,500
	// format(1000000.55555,3) : 1.000.000,556

	function format(s, r) {
		s = Math.round(s * Math.pow(10, r)) / Math.pow(10, r);
		s = String(s);
		s = s.split(".");
		var l = s[0].length;
		var t = "";
		var c = 0;
		while (l > 0) {
			t = s[0][l - 1] + (c % 3 == 0 && c != 0 ? thoudelim : "") + t;
			l--;
			c++;
		}
		s[1] = s[1] == undefined ? "0" : s[1];
		for (i = s[1].length; i < r; i++) {
			s[1] += "0";
		}
		return curr + t + decdelim + s[1];
	}

	function threedigit(word) {
		eja = Array("Nol", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan");
		while (word.length < 3) word = "0" + word;
		word = word.split("");
		a = word[0];
		b = word[1];
		c = word[2];
		word = "";
		word += (a != "0" ? (a != "1" ? eja[parseInt(a)] : "Se") : "") + (a != "0" ? (a != "1" ? " Ratus" : "ratus") : "");
		word += " " + (b != "0" ? (b != "1" ? eja[parseInt(b)] : "Se") : "") + (b != "0" ? (b != "1" ? " Puluh" : "puluh") : "");
		word += " " + (c != "0" ? eja[parseInt(c)] : "");
		word = word.replace(/Sepuluh ([^ ]+)/gi, "$1 Belas");
		word = word.replace(/Satu Belas/gi, "Sebelas");
		word = word.replace(/^[ ]+$/gi, "");

		return word;
	}

	function sayit(s) {
		var thousand = Array("", "Ribu", "Juta", "Milyar", "Trilyun");
		s = Math.round(s * Math.pow(10, 2)) / Math.pow(10, 2);
		s = String(s);
		s = s.split(".");
		var word = s[0];
		var cent = s[1] ? s[1] : "0";
		if (cent.length < 2) cent += "0";

		var subword = "";
		i = 0;
		while (word.length > 3) {
			subdigit = threedigit(word.substr(word.length - 3, 3));
			subword = subdigit + (subdigit != "" ? " " + thousand[i] + " " : "") + subword;
			word = word.substring(0, word.length - 3);
			i++;
		}
		subword = threedigit(word) + " " + thousand[i] + " " + subword;
		subword = subword.replace(/^ +$/gi, "");

		word = (subword == "" ? "NOL" : subword.toUpperCase()) + " RUPIAH";
		subword = threedigit(cent);
		cent = (subword == "" ? "" : " ") + subword.toUpperCase() + (subword == "" ? "" : " SEN");
		return word + cent;
	}

	$(".check").on("click", function() {
		if ($(".check:checked").length < 2) {
			$('.action-select').prop('disabled', false);
		} else {
			$('.action-select').prop('disabled', true);
		}
	});

	$(".check-sales").on("click", function() {
		if ($(".check-sales:checked").length < 2) {
			$('.action-select-sales').prop('disabled', false);
		} else {
			$('.action-select-sales').prop('disabled', true);
		}
	});

	$(window).click(function() {
		var Indexnya = $(this).parent().parent().index();
		$('.hasil_pencarian').hide();
	});
	$(document).on('click', '#pencarian_kode', function() {
		$('.hasil_pencarian').hide();
		var Indexnya = $(this).parent().parent().index();
		$('#tableTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(2)').find('div#hasil_pencarian').show();
	});
	$(document).on('keypress', '#tableTransaksi', function(e) {
		var key = e.which || e.keyCode;
		if (key == 13) {
			return false;
		}
	});

	$(document).on('keypress', '#tableTransaksi', function(e) {
		var key = e.which || e.keyCode;
		if (key == 13) {
			return false;
		}
	});

	$(document).on('keydown', 'body', function(e) {
		var charCode = (e.which) ? e.which : event.keyCode;

		if (charCode == 118) //F7
		{
			BarisBaru();
			return false;
		}

		if (charCode == 119) //F8
		{
			$('#UangCash').focus();
			return false;
		}
		if (charCode == 121) //F10
		{
			$('#Simpan').click();
			return false;
		}
	});



	$('.action-select').click(function(e) {
		e.preventDefault();
		var arr = [];
		var checkedValue = $(".check:checked").val();
		console.log('checked', checkedValue);
		$('#tampilPenjualan').modal('show');
		$.ajax({
			url: "<?php echo base_url('C_penjualan/tampil_nama/') ?>" + checkedValue,
			type: "GET",
			dataType: "JSON",
			success: function(result) {
				$('#nama_pelanggan').html('<b>Nama: </b>' + result.fv_nmpelanggan + '<br />' + '<b>Alamat: </b>' + result.f_alamat + '<br />' + '<b>No Telp: </b>' + result.fc_telp);
				//$('[id="fv_nmpelanggan_view"]').val(result.fv_nmpelanggan);
				$('[name="fc_kdpel_view"]').val(result.fc_kdpel);
				$('[name="f_alamat_view"]').val(result.f_alamat);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Data Eror');
			}
		})
	});

	$('.action-select-sales').click(function(e) {
		e.preventDefault();
		var arr = [];
		var checkedValue = $(".check-sales:checked").val();
		console.log('checked', checkedValue);
		$('#tampilPenjualan').modal('show');
		$.ajax({
			url: "<?php echo base_url('C_penjualan/tampil_sales/') ?>" + checkedValue,
			type: "GET",
			dataType: "JSON",
			success: function(result) {
				$('#nama_sales').html('<b>Nama: </b>' + result.fv_nama +'<br />'+ '<b>Email: </b>'+result.fc_email+ '<br/>'+ '<b>No Hp: </b>'+result.fc_hp);
				//$('[id="fv_nmpelanggan_view"]').val(result.fv_nmpelanggan);
				$('[name="fc_salesid_view"]').val(result.fc_salesid);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Data Eror');
			}
		})
	});

	//action-barang
	$('.action-barang').click(function(e) {
		e.preventDefault();
		var arr = [];
		var checkedValue = $(".check:checked").val();
		console.log('checked', checkedValue);
		$('#tampilPenjualan').modal('show');
		// $.ajax({
		//     url: "<?php echo base_url('C_penjualan/tampil_nama/') ?>" + checkedValue,
		//     type: "GET",
		//     dataType: "JSON",
		//     success: function(result) {
		//         $('[name="fv_nmpelanggan_view"]').val(result.fv_nmpelanggan);
		//         //$('[id="fv_nmpelanggan_view"]').val(result.fv_nmpelanggan);
		//         $('[name="fc_kdpel_view"]').val(result.fc_kdpel);
		//     },
		//     error: function(jqXHR, textStatus, errorThrown) {
		//         alert('Data Eror');
		//     }
		// })
	});

	function sum() {
		var txtFirstNumberValue = document.getElementsById('fm_hargajual').value;
		var txtSecondNumberValue = document.getElementsById('fm_ongkos').value;
		var result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue);
		if (!isNaN(result)) {
			document.getElementById('fm_total').value = result;
		}
	}

	$(function() {

		var set_number = function() {
			var table = $().length + 1;

			$('#no').val(table);
		}

		set_number();

		$('#add_data').click(function(e) {
			e.preventDefault();
			$('#tampilPenjualan').modal('show');

			var no = $('#no').val();
			var fc_kdstock = $('#fc_kdstock').val();
			var fv_nmbarang = $('#fv_nmbarang').val();
			var ff_berat = $('#ff_berat').val();
			var fc_kadar = $('#fc_kadar').val();
			var fm_hargajual = $('#fm_hargajual').val();
			var fm_ongkos = $('#fm_ongkos').val();
			var fm_total = parseInt($('#fm_hargajual').val()) + parseInt($('#fm_ongkos').val());

			$('#data_table tbody:last-child').append(
				'<tr>' +
				'<td>' + no + '</td>' +
				'<td>' + fc_kdstock + '</td>' +
				'<td>' + fv_nmbarang + '</td>' +
				'<td>' + ff_berat + '</td>' +
				'<td>' + fc_kadar + '</td>' +
				'<td>' + fm_hargajual + '</td>' +
				'<td>' + fm_ongkos + '</td>' +
				'<td id="fm_total">' + fm_total + '</td>' +
				'</tr>'
			);

			$('#no').val('');
			$('#fc_kdstock').val('');
			$('#fv_nmbarang').val('');
			$('#ff_berat').val('');
			$('#fc_kadar').val('');
			$('#fm_hargajual').val('');
			$('#fm_ongkos').val('');
			parseInt($('#fm_hargajual').val('')) + parseInt($('#fm_ongkos').val(''));




			var table = document.getElementById("data_table"),
				total = 0;
			var subtotal = $('#fm_total').val();
			for (var t = 1; t < table.rows.length; t++) {
				total = total + parseInt(table.rows[t].cells[8]) + parseInt(subtotal);
			}
			document.getElementById("subtotal").innerHTML = total;
			console.log(total);
		});
	})


	$('.action-barang').click(function(e) {
		e.preventDefault();
		var arr = [];
		var checkedValue = $(".check-barang:checked").val();
		console.log('checked', checkedValue);
		$('#tampilPenjualan').modal('show');
		$.ajax({
			url: "<?php echo base_url('C_penjualan/tampil_barang/') ?>" + checkedValue,
			type: "GET",
			dataType: "JSON",
			success: function(result) {
				$('[name="fc_kdstock_view"]').val(result.fc_kdstock);
				$('[name="fv_nmbarang_view"]').val(result.fv_nmbarang);
				$('[name="ff_berat_view"]').val(result.ff_berat);
				$('[name="fc_kadar_view"]').val(result.fc_kadar);
				$('[name="fm_hargajual_view"]').val(result.fm_hargajual);
				$('[name="fm_ongkos_view"]').val(result.fm_ongkos);
				$('[name="fv_nmbarang_view"]').val(result.fv_nmbarang);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Data Eror');
			}
		})
	});

	function sts(value) {
		if (value == 1) {
			return 'Aktif';
		} else {
			return 'Non Aktif';
		}
	}

	$(document).ready(function() {
		$('#myTable').DataTable({
			"pageLength": 10,
			"lengthChange": false
		});
	})

	$(document).ready(function() {
		$('#myTable2').DataTable({
			"pageLength": 10,
			"lengthChange": false
		});
	})
</script>
<?php $this->load->view('partials/footer.php') ?>
<?php $this->load->view('partials/js.php') ?>