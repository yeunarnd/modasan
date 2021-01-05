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

                <img src="../assets/assets/avatars/user.jpg" alt="Jason's Photo" />
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
                        <img class="nav-user-photo" src="<?= base_url() ?>/assets/assets/avatars/user.jpg" alt="Jason's Photo" />
                        <span class="user-info">
                            <small>Welcome,</small>
                            <?= $this->session->userdata('fv_username') ?>
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
    <div class="main-content-inner">
        <div class="page-content">

            <!-- /section:settings.box -->
            <div class="page-header">
                <h2 style="color: #07A1C8;">
                    Sales
                    <button type="button" class="pull-right btn btn-primary">Refresh</button>
                </h2>
            </div><!-- /.page-header -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="center">
                        <div class="table-responsive" id="tampil">
                            <table id="myTable" class="display">
                                <thead>
                                    <tr>
                                        <th class="center">
                                            Check
                                        </th>
                                        <th scope="col">No</th>
                                        <th scope="col">Kode</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">No.Hp</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Jabatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo form_open('C_sales/delete'); ?>
                                    <?php $no = $this->uri->segment('3') + 1;
                                    foreach ($sales as $s) : ?>
                                        <tr>
                                            <td class="check">
                                                <input type="checkbox" class="check-item" id="id" name="id" value="<?php echo $s->fc_salesid ?>">
                                            </td>
                                            <th scope="row"><?= $no++ ?></th>
                                            <td scope="row"><?= $s->fc_salesid ?></td>
                                            <td scope="row"><?= $s->fv_nama ?></td>
                                            <td scope="row"><?= $s->fc_email ?></td>
                                            <td scope="row"><?= $s->fc_hp ?></td>
                                            <td scope="row"><?= $s->fc_aktif ?></td>
                                            <td scope="row"><?= $s->fv_mposisi ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <br>
                    <div class="center">
                        <div class="row">
                            <div class="col-md-1" style="margin-top: 5px">
                                <?php if ($cc == '1') { ?>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"> Tambah</i></button>
                                <?php } ?>
                            </div>
                            <div class="col-md-1" style="margin-top: 5px">
                                <?php if ($cu == '1') { ?>
                                    <button type="button" class="btn btn-success action-update"><i class="fa fa-edit"> Edit</i></button>
                                <?php } ?>
                            </div>
                            <div class="col-md-1" style="margin-top: 5px">
                                <?php if ($cd == '1') { ?>
                                    <button type="submit" id="delete" class="btn btn-danger diambil"><i class="fa fa-trash"> Hapus</i></button>
                                <?php } ?>
                            </div>
                            <?= form_close(); ?>
                            <div class="md-form active-purple active-purple-2 mb-3">
                            </div>

                        </div>

                        <div class="modal fade" id="tambah" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel"></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" action="<?= base_url('C_sales/save') ?>" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label for="kode" class="col-sm-2 col-form-label">Kode</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="fc_salesid" class="form-control" id="kode" placeholder="Kode" value="<?php echo $kode_sales ?>">
                                                    <?= form_error('fc_salesid', '<small class="text-danger pl-3">', '</small>') ?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="fv_nama" id="nama" placeholder="Nama">
                                                    <?= form_error('fv_nama', '<small class="text-danger pl-3">', '</small>') ?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-7">
                                                    <input type="email" class="form-control" name="fc_email" id="email" placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="no.hp" class="col-sm-2 col-form-label">No.hp</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="fc_hp" id="no.hp" placeholder="No.hp">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-sm-2 col-form-label">Sales</label>
                                                <div class="col-sm-7">
                                                    <select class="form-control" name="fc_aktif">
                                                        <option>--Pilih--</option>
                                                        <option value="Y">Aktif</option>
                                                        <option value="N">Non Aktif</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tanggal_lahir" class="col-sm-2 col-form-label">Tanggal
                                                    Lahir</label>
                                                <div class="col-sm-7">
                                                    <input type="date" name="fd_tgllahir" class="form-control" id="tanggal_lahir" placeholder="Tanggal Lahir">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                                                <div class="col-sm-7">
                                                    <select class="form-control" name="fc_kdposisi">
                                                        <option>--Pilih Jabatan--</option>
                                                        <?php foreach ($jabatan as $k) : ?>
                                                            <option value="<?= $k->fc_kdposisi ?>"><?= $k->fv_mposisi ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="col-md-1" style="margin-top: 5px">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"> Simpan</i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="modalresult" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel"></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <form method="post" action="<?= base_url('C_sales/update') ?>" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label for="kode" class="col-sm-2 col-form-label">Kode</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="fc_salesid_edit" class="form-control" id="kode" placeholder="Kode">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="fv_nama_edit" id="nama" placeholder="Nama">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="fc_email_edit" id="email" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="no.hp" class="col-sm-2 col-form-label">No.hp</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="fc_hp_edit" id="no.hp" placeholder="No.hp">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 col-form-label">Sales</label>
                                            <div class="col-sm-7">
                                                <select class="form-control" name="fc_aktif_edit">
                                                    <option>--Pilih--</option>
                                                    <option value="Y">Aktif</option>
                                                    <option value="N">Non Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tanggal_lahir" class="col-sm-2 col-form-label">Tanggal
                                                Lahir</label>
                                            <div class="col-sm-7">
                                                <input type="date" class="form-control" name="fd_tgllahir_edit" id="tanggal_lahir" placeholder="Tanggal Lahir">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                                            <div class="col-sm-7">
                                                <select class="form-control" name="fc_kdposisi_edit">
                                                    <?php foreach ($jabatan2 as $k) : ?>
                                                        <option value="<?= $k->fc_kdposisi ?>"><?= $k->fv_mposisi ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="col-md-1" style="margin-top: 5px">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-edit"> Edit</i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- PAGE CONTENT ENDS -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div>

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
                $('#modalresult').modal('show');
                $.ajax({
                    url: "<?php echo base_url('C_sales/ajax_edit/') ?>" + checkedValue,
                    type: "GET",
                    dataType: "JSON",
                    success: function(result) {
                        $('[name="fc_salesid_edit"]').val(result.fc_salesid);
                        $('[name="fv_nama_edit"]').val(result.fv_nama);
                        $('[name="fc_email_edit"]').val(result.fc_email);
                        $('[name="fc_hp_edit"]').val(result.fc_hp);
                        $('[name="fc_aktif_edit"]').val(result.fc_aktif);
                        $('[name="fd_tgllahir_edit"]').val(result.fd_tgllahir);
                        $('[name="fc_kdposisi_edit"]').val(result.fc_kdposisi);
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
        <script>
            $('#delete').click(function(e) {
                e.preventDefault();
                var arr = [];
                var checkedValue = $(".check-item:checked").val();
                console.log('checked', checkedValue);

                if (confirm('Apakah anda yakin akan menghapus data?')) {
                    $.ajax({
                        url: "<?php echo site_url('C_sales/delete') ?>/" + checkedValue,
                        type: "POST",
                        dataType: "JSON",
                        success: function(data) {
                            window.location.href = "<?php echo site_url('C_sales') ?>";
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log("error");
                        }
                    });
                }
            })
        </script>

        <script>
            var keyword = document.getElementById('keywoard');
            var search = document.getElementById('btn-search');
            var view = document.getElementById('tampil');

            // search.addEventListener('click', function() {
            //     alert('berhasil');
            // });
            keyword.addEventListener('keyup', function() {
                //objek ajax
                var ajax = new XMLHttpRequest();

                //cek kesiapan ajax
                ajax.onreadystatechange = function() {
                    if (ajax.readyState == 4 && ajax.status == 200) {
                        // view.innerHTML = ajax.responseText
                        alert('congrats');
                    }
                }

                ajax.open('POST', '<?php base_url('C_sales/search') ?>'.$ke, true);
                ajax.send();
            })
        </script>