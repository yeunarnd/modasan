<?php $this->load->view('partials/header.php') ?>
<!-- <link rel="stylesheet" type="text/css" href="http://www.rsigondanglegi.com/laris/assets/public/themes/admin-lte/plugin/datatables/media/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="http://www.rsigondanglegi.com/laris/assets/public/themes/admin-lte/plugin/datatables/extensions/Responsive/css/responsive.bootstrap.min.css"> -->
<!-- <link href="<?php echo base_url('assets') ?>/table/bootstrap-table.css" rel="stylesheet">
<script src="<?php echo base_url('assets') ?>/table/bootstrap-table.js"></script> -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<link href="http://www.rsigondanglegi.com/laris/assets/table/bootstrap-table.css" rel="stylesheet">
<script src="<?php echo base_url('assets') ?>/assets/js/sprintf.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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
                        <img class="nav-user-photo" src="<?php base_url() ?>assets/assets/avatars/user.jpg" alt="Jason's Photo" />
                        <span class="user-info">
                            <small>Welcome,</small>
                            Jason
                        </span>

                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="#">
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



    <!-- /section:basics/sidebar.horizontal -->
    <div class="main-content">
        <div class="main-content-inner">
            <div class="page-content">

                <!-- /section:settings.box -->
                <div class="page-header">
                    <h2 style="color: #07A1C8;">
                        Pembelian

                    </h2>
                </div><!-- /.page-header -->

                <div class="row">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->

                        <button type="button" data-toggle="modal" data-target="#tampilPembelian" class="btn btn-success"><i class="fa fa-print"> Pembelian</i></button>

                        <div class="modal fade" id="tampilPembelian" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="exampleModalLabel">Pembelian</h3>
                                    </div>
                                    <div class="modal-body">
                                        <form method='post' action='<?php echo base_url('C_pembelian/simpan_pembelian') ?>'>
                                            <div class="row">

                                                <div class=" col-md-3">
                                                    <label for="form-field-9">No Faktur Lama</label>
                                                    <button type="button" onclick="faktur()" class="btn btn-success"><i class="fa fa-search"></i> Cari No Faktur Lama</i></button>

                                                </div>
                                                <div class="col-md-3 ">
                                                    <label for="form-field-9">Transaksi Terdahulu</label>
                                                    <input id="tags" type="text" name="fc_noinv_view" class="form-control">
                                                    <span id="invoice_penjualan"></span>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="inputPassword" class="col-sm-4 col-form-label">Faktur</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" name="no_faktur_penjualan" class=" form-control" id="no_nota" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputPassword" class="col-sm-4 col-form-label">Tanggal</label>
                                                        <?php
                                                        $tgl = date("Y-m-d");
                                                        ?>
                                                        <div class="col-sm-8">
                                                            <input type="date" class="form-control" name="fd_tglinv_view" id="inputPassword" value="<?= $tgl ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputPassword" class="col-sm-4 col-form-label">Kode Penjual</label>
                                                        <div class="col-sm-5">
                                                            <input type="text" class="form-control" id="inputPassword" name="fc_kdpel_view" readonly>
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
                                                    <div class="form-group row">
                                                        <label for="inputPassword" class="col-sm-4 col-form-label">Nama Penjual</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" name="fv_nmpelanggan_view" id="inputPassword" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputPassword" class="col-sm-4 col-form-label">Alamat Penjual</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" name="f_alamat_view" id="inputPassword" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">

                                                    <table id="pembayaran_hutang_table_det" data-toggle="table" data-select-item-name="toolbar1" data-sort-name="id_jurnal" data-sort-order="desc">
                                                        <thead>
                                                            <tr>
                                                                <th data-formatter="runningFormatter" data-align="right">No.</th>
                                                                <th data-field="Id|fc_kdstock" data-sortable="true" data-formatter="kodestok">Kode</th>
                                                                <th data-field="fv_nmbarang" data-sortable="true">Uraian Barang</th>
                                                                <th data-field="fn_berat|Id" data-sortable="true" data-formatter="berat">Berat</th>
                                                                <th data-field="ff_kadar|Id" data-sortable="true" data-formatter="kadar">Kadar</th>
                                                                <th data-field="Id|fm_price" data-sortable="true" data-formatter="hargalama">Harga Lama</th>
                                                                <th data-field="Id" data-sortable="true" data-formatter="kondisi">Kondisi</th>
                                                                <th data-field="Id" data-sortable="true" data-formatter="potongan">Potongan</th>
                                                                <th data-field="Id" data-sortable="true" data-formatter="hargabeli">Harga Beli</th>
                                                            </tr>
                                                        </thead>
                                                    </table><br />
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div>
                                                    <!-- <button type="button" class="btn-sm btn-primary" data-toggle="modal" data-target="#pilihbarang">
                                                        <i class="ace-icon glyphicon glyphicon-plus"> Pilih Barang</i>
                                                    </button> -->
                                                    <!-- <button type="button" class="btn-sm btn-primary" id="BarisBaru">
                                                        <i class="ace-icon glyphicon glyphicon-plus"> Baris Baru</i>
                                                    </button> -->
                                                </div>

                                            </div>
                                            <div class="col-md-3">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="form-group row">
                                                        <div class="col-sm-1">
                                                        </div>
                                                        <label class="col-sm-3 col-form-label">Subtotal</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="SubTotalBayar" name='SubTotalBayar' readonly>
                                                            <input type="hidden" class="form-control" id="SubTotalBayar2" name='SubTotalBayar2' readonly>
                                                            <input type="hidden" class="form-control" id="TotalPotongan" name='TotalPotongan'>
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
                                                            <input type="text" class="form-control" readonly placeholder="" name="terbilang" id="terbilang">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary ">Simpan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="modal fade" id="tampilFaktur" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Faktur</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="col-md-12 center">

                                                <table id="pembayaran_hutang_table" class="tabelfaktur" data-toggle="table" data-select-item-name="toolbar1" data-sort-name="id_jurnal" data-sort-order="desc" data-pagination="true" data-search="true">
                                                    <thead>
                                                        <tr>
                                                            <th data-formatter="runningFormatter" data-align="right">No.</th>
                                                            <th data-field="fc_noinv" data-sortable="true">Faktur</th>
                                                            <th data-field="tanggal" data-sortable="true">Tanggal</th>
                                                            <th data-field="fv_nmpelanggan" data-sortable="true">Pelanggan</th>
                                                            <th data-field="fm_grandtotal" data-sortable="true">Grand Total</th>
                                                            <th data-field="fc_sts" data-sortable="true" data-formatter="get_status">Status</th>
                                                            <th data-field="fc_noinv" data-formatter="actiondetail">Action</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="modal-footer">
                                    <button type="submit" data-dismiss="modal" class="btn btn-primary action-select">Pilih</button>
                                </div> -->
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
                                                <table id="mytable8" class="display">
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
                                                                        <input type="checkbox" class="check-pelanggan" value="<?= $p->fc_kdpel ?>" />
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
                                            <button type="button" data-dismiss="modal" class="btn btn-primary action-pelanggan">Pilih</button>
                                            <!-- <button type="button" class="btn btn-primary action-select">Pilih</button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- PAGE CONTENT ENDS -->
                    </div>

                    <div class="modal fade" id="tambahpelanggan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pelanggan</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <form method="post" action="<?= base_url('C_pembelian/save_datapelanggan') ?>" enctype="multipart/form-data">
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
                    </div>
                </div>
                <!-- PAGE CONTENT ENDS -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>
</div><!-- /.main-content -->

<div class="modal fade" id="pilihbarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Barang</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <form>
                            <div class="col-md-12">

                                <div class="center">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="tableBarang" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th class="check">
                                                        <div class="center">
                                                            <input type="checkbox" id="check-all">
                                                        </div>
                                                    </th>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Kode</th>
                                                    <th scope="col">Nama</th>
                                                    <th scope="col">Kelompok</th>
                                                    <th scope="col">Lokasi</th>
                                                    <th scope="col">Berat Gram</th>
                                                    <th scope="col">Kadar %</th>
                                                    <th scope="col">Harga Beli</th>
                                                    <th scope="col">Sales</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Tanggal</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <button type="button" data-dismiss="modal" class="btn btn-primary action-barang">Simpan</button>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- PAGE CONTENT ENDS -->
</div><!-- /.col -->


<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
    <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
</a>
</div><!-- /.main-container -->
<script>
    let dataBarang;
    var table2;



    function faktur() {
        $('#tampilFaktur').modal('show');
        $('#pembayaran_hutang_table').bootstrapTable('refresh', {
            url: '<?php echo base_url() ?>C_pembelian/get_list_penjualan/'
        });
        // var $pembayaran_hutang_table = $('#penjualan_table');
        // $pembayaran_hutang_table.bootstrapTable('refresh', {
        //     url: '<?php echo base_url() ?>C_pembelian/get_list_penjualan/'
        // });
    }

    function myFunction() {
        console.log('iki');
    }

    $(document).ready(function() {
        // $('#pembayaran_hutang_table').DataTable({
        //     "pageLength": 10,
        //     "lengthChange": false

        // });

        // getDataBarang();
        // BarisBaru();
        //detail_barang();
        // $('html, body').animate({
        //     scrollTop: 0
        // }, 0);
        $.ajax({
            url: "<?php echo base_url() . 'C_pembelian/max_nota'; ?>",
            dataType: 'json',
            method: 'POST',
            success: function(json) {
                var d = "<?php echo $day ?>";
                var m = "<?php echo $month ?>";
                var y = "<?php echo $years ?>";

                if (json.maxs == null) {
                    max = 'PB' + '' + y + '' + m + '' + d + '-' + '00000';
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

                var invoice = 'PB' + '' + y + '' + m + '' + d + '-' + kodene;
                console.log('invoice' + invoice);
                $('#no_nota').val(invoice);
            }
        });
    });


    function runningFormatter(value, row, index) {
        return index + 1;
    }

    function get_status(value) {
        if (value == '1') {
            return 'Terjual';
        }
    }

    function actiondetail(value, row, index) {
        return '<div class="btn-group" role="group" aria-label="..."><a href="#" onclick="detailnya( \'' + row.fc_noinv + '\')" type="button" class="btn btn-primary"><span aria-hidden="true"></span>Pilih</a></div>';
    }

    function detailnya(fc_noinv) {
        $('#pembayaran_hutang_table_det').bootstrapTable('refresh', {
            url: '<?php echo base_url() ?>C_pembelian/get_list_penjualan_det/' + fc_noinv
        });
        $.ajax({
            url: "<?php echo base_url('C_pembelian/tampil_faktur2/') ?>" + fc_noinv,
            type: "GET",
            dataType: "JSON",
            success: function(result) {
                $('[name="fc_noinv_view"]').val(result.fc_noinv);
                $('#invoice_penjualan').html('<b>No Pelanggan: </b>' + result.fc_kdpel + '<br />' + '<b>Pelanggan: </b>' + result.fv_nmpelanggan + '<br />' + '<b>Alamat: </b>' + result.f_alamat + '<br />' + '<b>No Telp: </b>' + result.fc_telp);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Data Eror');
            }
        })
        $('#tampilFaktur').modal('hide');
    }


    function hargalama(value, row, index) {
        return '<input type="text" class="form-control hargalama' + row.Id + '" value="' + row.fm_price + '" name="hargalama[]" id="hargalama" onkeyup="potongan_harga(' + row.Id + ')">';
    }

    function kondisi(value, row, index) {
        return '<input name="kondisi[]" type="text" class="form-control kondisi' + row.Id + '" value="" id_kondisi>';
    }

    function potongan(value, row, index) {
        return '<input name="potongan[]" type="text" class="form-control potongan' + row.Id + '" id="potongan" value="" onkeyup="potongan_harga(' + row.Id + ')">';
    }

    function berat(value, row, index) {
        return '<input name="berat_emas[]" type="text" class="form-control berat_emas' + row.Id + '" value="' + row.fn_berat + '" >';
    }

    function kadar(value, row, index) {
        return '<input name="kadar_emas[]" type="text" class="form-control kadar_emas' + row.Id + '" value="' + row.ff_kadar + '" >';
    }

    function hargabeli(value, row, index) {
        return '<input name="hargabeli[]" type="text" class="form-control hargabeli' + row.Id + '" id="hargabeli" value="">';
    }

    function kodestok(value, row, index) {
        return '' + row.fc_kdstock + '<input name="kode_stok[]" type="hidden" class="form-control kode_stok' + row.Id + '" value="' + row.fc_kdstock + '" id="kode_stok"><input name="Id[]" type="hidden" class="form-control Id' + row.Id + '" value="' + row.Id + '" id="Idne">';
    }

    function potongan_harga(Id) {
        var harga_lama = $(".hargalama" + Id).val();
        console.log(harga_lama);
        var potongan = $(".potongan" + Id).val();
        console.log(potongan);

        var harga_beli = parseInt(harga_lama) - parseInt(potongan);
        console.log(harga_beli);
        if (!isNaN(harga_beli)) {
            $('.hargabeli' + Id).val(harga_beli);
        }
        var Total = 0;
        var TotalPotongan = 0;
        $('#pembayaran_hutang_table_det tbody tr').each(function() {
            if ($(this).find('td:nth-child(9) input').val() > 0) {
                var SubTotal = $(this).find('td:nth-child(9) input').val();
                console.log('salah' + SubTotal);
                Total = parseInt(Total) + parseInt(SubTotal);

            }
        });

        $('#pembayaran_hutang_table_det tbody tr').each(function() {
            if ($(this).find('td:nth-child(8) input#potongan').val() > 0) {
                var SubTotalPotongan = $(this).find('td:nth-child(8) input#potongan').val();
                TotalPotongan = parseInt(TotalPotongan) + parseInt(SubTotalPotongan);
            }
        });

        $('#TotalBayar').val(Total);
        $('#SubTotalBayar').val(Total);

        $('#TotalBayar2').val(Total);
        $('#SubTotalBayar2').val(Total);

        $('#TotalPotongan').val(TotalPotongan);

        $('#terbilang').val(sayit(Total));
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





    $(".check").on("click", function() {
        if ($(".check:checked").length < 2) {
            $('.action-select').prop('disabled', false);
        } else {
            $('.action-select').prop('disabled', true);
        }
    });


    $('.action-select').click(function(e) {
        e.preventDefault();
        var arr = [];
        var checkedValue = $(".check:checked").val();
        console.log('checked', checkedValue);
        $('#tampilPembelian').modal('show');
        $.ajax({
            url: "<?php echo base_url('C_pembelian/tampil_faktur/') ?>" + checkedValue,
            type: "GET",
            dataType: "JSON",
            success: function(result) {
                $('[name="fc_noinv_view"]').val(result.fc_noinv);
                $('[name="fd_tglinv_view"]').val(result.fd_tglinv);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Data Eror');
            }
        })
    });


    $('.action-barang').click(function(e) {
        e.preventDefault();
        var arr = [];
        var checkedValue = $(".check-barang:checked").val();
        console.log('checked', checkedValue);
        $('#tampilPembelian').modal('show');
        $.ajax({
            url: "<?php echo base_url('C_pembelian/tampil_barang/') ?>" + checkedValue,
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
                $('[name="fm_hargabeli_view"]').val(result.fm_hargabeli)
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Data Eror');
            }
        })
    });

    $(function() {

        var set_number = function() {
            var table = $().length + 1;

            $('#no').val(table);
        }

        set_number();

        $('#add_data').click(function(e) {
            e.preventDefault();
            $('#tampilPembelian').modal('show');
            var no = $('#no').val();
            var fc_kdstock = $('#fc_kdstock').val();
            var fv_nmbarang = $('#fv_nmbarang').val();
            var ff_berat = $('#ff_berat').val();
            var fc_kadar = $('#fc_kadar').val();
            var fm_hargajual = $('#fm_hargajual').val();
            var fm_ongkos = $('#fm_ongkos').val();
            var fm_hargabeli = $('#fm_hargabeli').val();
            var fm_total = parseInt($('#fm_hargajual').val()) + parseInt($('#fm_ongkos').val())


            $('#data-table tbody:last-child').append(

                '<tr>' +
                '<td>' + no + '</td>' +
                '<td>' + fc_kdstock + '</td>' +
                '<td>' + fv_nmbarang + '</td>' +
                '<td>' + ff_berat + '</td>' +
                '<td>' + fc_kadar + '</td>' +
                '<td>' + fm_hargajual + '</td>' +
                '<td>' + '<input type="text" name=""  class="form-control" >' + '</td>' +
                '<td>' + fm_ongkos + '</td>' +
                '<td>' + '<input type="text" name=""  class="form-control" >' + '</td>' +
                '<td id="fm_total">' + fm_total + '</td>' +
                '</tr>'
            );
        });
    })

    $('.action-pelanggan').click(function(e) {
        e.preventDefault();
        var arr = [];
        var checkedValue = $(".check-pelanggan:checked").val();
        console.log('checked', checkedValue);
        $('#tampilPembelian').modal('show');
        $.ajax({
            url: "<?php echo base_url('C_pembelian/tampil_pelanggan/') ?>" + checkedValue,
            type: "GET",
            dataType: "JSON",
            success: function(result) {
                $('[name="fc_kdpel_view"]').val(result.fc_kdpel);
                $('[name="fv_nmpelanggan_view"]').val(result.fv_nmpelanggan);
                $('[name="f_alamat_view"]').val(result.f_alamat);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Data Eror');
            }
        })
    });


    // var table = document.getElementById("data-table"),
    //     sumHsl = 0;
    // for (var t = 1; t < table.rows.length; t++) {
    //     sumHsl = sumHsl + parseInt(table.rows[t].cells[5].innerHTML);

    // }
    // document.getElementById("hasil").innerHTML = sumHsl;
    // console.log(sumHsl);

    function sum() {
        var txtFirstNumberValue = document.getElementsById('fm_hargajual').value;
        var txtSecondNumberValue = document.getElementsById('fm_ongkos').value;
        var result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue);
        if (!isNaN(result)) {
            document.getElementById('fm_total').value = result;
        }
    }

    $('#save')



    // $(document).ready(function() {

    // })
</script>
<script>
    $(document).ready(function() {

        $('#mytable8').DataTable({
            "pageLength": 10,
            "lengthChange": false

        });
        table.destroy();
    })
</script>

<?php $this->load->view('partials/footer.php') ?>
<?php $this->load->view('partials/js.php') ?>