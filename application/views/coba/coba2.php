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
            <?php foreach ($menu as $me) : ?>
                <li class="hover">
                    <a href="<?php echo base_url($me->link_menu);  ?>">
                        <i class="menu-icon <?= base_url($me->icon_class);  ?>"></i>
                        <span class="menu-text"> <?= $me->nama_menu ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul><!-- /.nav-list -->

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
                    <h1>
                        Penjualan

                    </h1>
                </div><!-- /.page-header -->

                <div class="row">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->

                        <button type="button" data-toggle="modal" data-target="#tampilPenjualan" class="btn btn-success"><i class="fa fa-print"> Penjualan</i></button>

                        <!-- Modal -->
                        <div class="modal fade" id="tampilPenjualan" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Penjualan</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <form>
                                                    <div class="col-md-3">

                                                    </div>
                                                    <div class="col-md-3 ">

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label for="inputPassword" class="col-sm-4 col-form-label">Faktur</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="inputPassword" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="inputPassword" class="col-sm-4 col-form-label">Tanggal</label>
                                                            <?php
                                                            $tgl = date("Y-m-d");
                                                            ?>
                                                            <div class="col-sm-8">
                                                                <input type="date" class="form-control" id="inputPassword" value="<?= $tgl ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="inputPassword" class="col-sm-4 col-form-label">Pelanggan</label>
                                                            <div class="col-sm-5">
                                                                <input type="text" class="form-control" id="inputPassword" name="fv_nmpelanggan_view" placeholder="">
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
                                                </form>
                                            </div>
                                        </div>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">nomor</th>
                                                    <th scope="col">Kode</th>
                                                    <th scope="col">Uraian Barang</th>
                                                    <th scope="col">Berat</th>
                                                    <th scope="col">Kadar</th>
                                                    <th scope="col">Harga Per Gram</th>
                                                    <th scope="col">Ongkos</th>
                                                    <th scope="col">Total Harga</th>
                                                    <th scope="col">Button</th>
                                                </tr>
                                            </thead>
                                            <tbody id="element_table">
                                                <tr>

                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <form>
                                                    <div class="col-md-3">
                                                        <a id="add_row" class="btn btn-primary pull-left">Tambah Baris</a>
                                                    </div>
                                                    <div class="col-md-3">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <div class="col-sm-1">
                                                            </div>
                                                            <label class="col-sm-3 col-form-label">Subtotal</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" readonly value="100.000">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-sm-1">
                                                            </div>
                                                            <label class="col-sm-3 col-form-label">GrandTotal</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" readonly value="100.000">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">Terbilang</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" readonly placeholder="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-save"> Simpan</i></button>

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
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th class="center">
                                                                    Ceklist
                                                                </th>
                                                                <th>
                                                                    Nama Pelanggan
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
                                                <!-- <button type="button" class="btn btn-primary action-select">Pilih</button> -->
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
                                                <form>
                                                    <div class="col-md-12">
                                                        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                                                        <div class="center">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered">
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
                                                                        <?php $i = 1;
                                                                        foreach ($barang as $s) : ?>
                                                                            <tr>
                                                                                <td class="check">
                                                                                    <input type="checkbox" class="check-barang" name="id[]" value="<?php echo $s->fn_id ?>">
                                                                                </td>
                                                                                <th scope="col"><?= $i++ ?></th>
                                                                                <td scope="row"><?= $s->fc_kdstock ?></td>
                                                                                <td scope="row"><?= $s->fv_nmbarang ?></td>
                                                                                <td scope="row"><?= $s->fc_kdkelompok ?></td>
                                                                                <td scope="row"><?= $s->fc_kdlokasi ?></td>
                                                                                <td scope="row"><?= $s->ff_berat ?></td>
                                                                                <td scope="row"><?= $s->fc_kadar ?></td>
                                                                                <td scope="row"><?= $s->fm_hargabeli ?></td>
                                                                                <td scope="row"><?= $s->fc_salesid ?></td>
                                                                                <td scope="row"><?= $s->fc_sts ?></td>
                                                                                <td scope="row"><?= $s->fd_date ?></td>
                                                                            </tr>
                                                                        <?php endforeach; ?>
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
                    </div><!-- /.row -->
                </div><!-- /.page-content -->
            </div>
        </div><!-- /.main-content -->
    </div>
</div>

<script>
    $(".check").on("click", function() {
        if ($(".check:checked").length < 2) {
            $('.action-select').prop('disabled', false);
        } else {
            $('.action-select').prop('disabled', true);
        }
    });

    $(document).ready(function() {
        var select_item = function() {
            $('#combination').val(
                $("#element_table select").map(function(index, element) {
                    return $(element).val();
                }).get().join("+")
            );
        };
        var add_row = function() {
            var new_row = $("<tr><td>" + ($("#element_table>tr").length) + "</td><td><input type='text' class='col-md-12' name'fc_kdstock_view' readonly></td><td><input type='text' class='col-md-12' name'fv_nmbarang_view' readonly></td><td><input type='text' class='col-md-12' name'fc_kdstock_view' readonly></td><td><input type='text' class='col-md-12' name'fc_kdstock_view' readonly></td><td><input type='text' class='col-md-12' name'fc_kdstock_view' readonly></td><td><input type='text' class='col-md-12' name'fc_kdstock_view' readonly></td><td><input type='text' class='col-md-12' name'fc_kdstock_view' readonly></><td><a id='delete_row' class='pull-right btn btn-danger'>Hapus Baris</a><a class='btn btn-primary' data-toggle='modal' data-target='#pilihbarang'>Pilih Barang</a></td></tr>").appendTo("#element_table");
            select_item();
            new_row.find('select').on('change', select_item);
            new_row.find("#delete_row").click(function() {
                $(this).parents("tr").remove();
                select_item();
            });
        };

        add_row();

        $("#add_row").click(add_row);

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
                $('[name="fv_nmpelanggan_view"]').val(result.fv_nmpelanggan);
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
</script>
<?php $this->load->view('partials/footer.php') ?>
<?php $this->load->view('partials/js.php') ?>