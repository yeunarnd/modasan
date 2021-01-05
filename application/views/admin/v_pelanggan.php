<?php $this->load->view('partials/header.php') ?>

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
                        Pelanggan
                        <button type="button" class="pull-right btn btn-primary">Refresh</button>
                    </h2>
                </div><!-- /.page-header -->
                <!-- asasasasasasas -->
                <div class="row">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->

                        <div class="center">
                            <div class="table-responsive">
                                <table id="myTable" class="display">
                                    <thead>
                                        <tr>
                                            <th class="center">
                                                Checklist
                                            </th>
                                            <th scope="col">No </th>
                                            <th scope="col">Kode </th>
                                            <th scope="col">Nama </th>
                                            <th scope="col">Alamat </th>
                                            <th scope="col">No. Telp </th>
                                            <th scope="col">Keterangan </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo form_open('C_pelanggan/delete'); ?>
                                        <?php $no = $this->uri->segment('3') + 1;
                                        foreach ($pelanggan->result() as $p) : ?>
                                            <tr>
                                                <td class="check">
                                                    <input type="checkbox" class="check-item" name="id" id="id" value="<?php echo $p->fc_kdpel ?>">
                                                </td>
                                                <th scope="row"><?= $no++; ?></th>
                                                <td><?= $p->fc_kdpel; ?></td>
                                                <td><?= $p->fv_nmpelanggan; ?></td>
                                                <td><?= $p->f_alamat; ?></td>
                                                <td><?= $p->fc_telp; ?></td>
                                                <td><?= $p->f_keterangan; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-1" style="margin-top: 5px;">
                                    <?php if ($cc == '1') { ?>
                                        <a href="" data-toggle="modal" data-target="#tambahpelanggan" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                                    <?php } ?>
                                </div>
                                <div class="col-md-1" style="margin-top: 5px; margin-left: 20px;">
                                    <?php if ($cu == '1') { ?>
                                        <button type="button" class="btn btn-success action-update"><i class="fa fa-edit"></i> Edit</button>
                                    <?php } ?>
                                </div>
                                <div class="col-md-1" style="margin-top: 5px;">
                                    <?php if ($cd == '1') { ?>
                                        <button type="submit" id="delete" class="btn btn-danger diambil"><i class="fa fa-trash"></i> Hapus</button>
                                    <?php } ?>
                                </div>
                                <?= form_close(); ?>

                                <!-- ISI DISINI -->
                                <div class="modal fade" id="tambahpelanggan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog ">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Tambah Pelanggan</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <form method="post" action="<?= base_url('C_pelanggan/save') ?>" enctype="multipart/form-data">
                                                            <div class="col-md-12">
                                                                <div class="form-group row">
                                                                    <label for="kode" class="col-sm-4 col-form-label">Kode</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" name="fc_kdpel" class="form-control" id="kode" value="<?php echo $kode_pelanggan ?>" placeholder="Kode">
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

                                <div class="modal fade" id="editpelanggan" tabindex="-1">
                                    <div class="modal-dialog ">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Pelanggan</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <form method="post" action="<?= base_url('C_pelanggan/update') ?>" enctype="multipart/form-data">
                                                            <div class="col-md-12">
                                                                <div class="form-group row">
                                                                    <label for="kode" class="col-sm-4 col-form-label">Kode</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" name="fc_kdpel_edit" class="form-control" id="kode" placeholder="Kode">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="inputPassword" class="col-sm-4 col-form-label">Nama</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" name="fv_nmpelanggan_edit" class="form-control" id="inputPassword" placeholder="Nama">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="inputPassword" class="col-sm-4 col-form-label">Alamat</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" name="f_alamat_edit" class="form-control" id="inputPassword" placeholder="Alamat">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="inputPassword" class="col-sm-4 col-form-label">No Hp</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" name="fc_telp_edit" class="form-control" id="inputPassword" placeholder="No Hp">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="inputPassword" class="col-sm-4 col-form-label">No KTP</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" name="fc_noktp_edit" class="form-control" id="inputPassword" placeholder="No KTP">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="inputPassword" class="col-sm-4 col-form-label">Keterangan</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" name="f_keterangan_edit" class="form-control" id="inputPassword" placeholder="Keterangan">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- <div class="modal-footer">
                                                                <div class="col-md-1" style="margin-top: 5px"> -->
                                                            <button type="submit" class="btn btn-primary"><i class="fa fa-edit"> Edit</i></button>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->
</div>
</div><!-- /.main-content -->



<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "pageLength": 100,
            "lengthChange": false
        });
    })
    $(".check-item").on("click", function() {
        if ($(".check-item:checked").length < 2) {
            $('.action-update').prop('disabled', false);
            $('.diambil').prop('disabled', false);
        } else {
            $('.diambil').prop('disabled', true);
            $('.action-update').prop('disabled', true);
        }
    });

    $('#delete').click(function(e) {
        e.preventDefault();
        var arr = [];
        var checkedValue = $(".check-item:checked").val();
        console.log('checked', checkedValue);

        if (confirm('Apakah anda yakin akan menghapus data?')) {
            $.ajax({
                url: "<?php echo site_url('C_pelanggan/delete') ?>/" + checkedValue,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    window.location.href = "<?php echo site_url('C_pelanggan') ?>";
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("error");
                }
            });
        }
    })

    $(document).ready(function() { // Ketika halaman sudah siap (sudah selesai di load)
        $("#check-all").click(function() { // Ketika user men-cek checkbox all
            if ($(this).is(":checked")) // Jika checkbox all diceklis
                $(".check-item").prop("checked", true); // ceklis semua checkbox siswa dengan class "check-item"
            else // Jika checkbox all tidak diceklis
                $(".check-item").prop("checked", false); // un-ceklis semua checkbox siswa dengan class "check-item"
        });

    });

    $('.action-update').click(function(e) {
        e.preventDefault();
        var arr = [];
        var checkedValue = $(".check-item:checked").val();
        console.log('checked', checkedValue);
        // jQuery.noConflict();
        $('#editpelanggan').modal('show');
        $.ajax({
            url: "<?php echo base_url('C_pelanggan/ajax_edit2/') ?>" + checkedValue,
            type: "GET",
            dataType: "JSON",
            success: function(result) {
                $('[name="fc_kdpel_edit"]').val(result.fc_kdpel);
                $('[name="fv_nmpelanggan_edit"]').val(result.fv_nmpelanggan);
                $('[name="f_alamat_edit"]').val(result.f_alamat);
                $('[name="fc_telp_edit"]').val(result.fc_telp);
                $('[name="fc_noktp_edit"]').val(result.fc_noktp);
                $('[name="f_keterangan_edit"]').val(result.f_keterangan);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Data Eror');
            }
        })

        // $('input.check-item:checked').each(function() {
        //     arr.push($(this).val());
        // });

        // var action = $(this).attr('data-href') + '/' + arr.join("-");
        // window.location.href = action;

    });
</script>
<?php $this->load->view('partials/footer.php') ?>
<?php $this->load->view('partials/js.php') ?>