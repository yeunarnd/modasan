<?php $this->load->view('partials/header.php') ?>
<?php
$koneksi =  mysqli_connect("localhost", "root", "", "modasan");
?>
<script type="text/javascript" src=" https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.js "></script>

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
        <!-- <ul class="nav nav-list">
            <?php foreach ($menu as $me) : ?>
                <li class="hover">
                    <a href="<?php echo base_url($me->link_menu);  ?>">
                        <i class="menu-icon <?= base_url($me->icon_class);  ?>"></i>
                        <span class="menu-text"> <?= $me->nama_menu ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul> -->
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

                        <i class="menu-icon <?= $rs->icon_class ?>"></i>
                        <span class="menu-text">
                            <?= $rs->nama_menu ?>
                        </span>

                        <b class="arrow fa fa-angle-down"></b>

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


                <div class="row">
                    <div class="col-md-3 col-xs-3">
                        <h2 style="color: #07A1C8;">
                            Laporan Harian
                        </h2>
                    </div>
                    <div class="col-md-3">
                        <h3>
                            <?php
                            if (isset($_GET['date'])) {
                                $hari = $_GET['date'];
                                $hari2 = date("d F Y", strtotime($hari));
                                echo $hari2;
                            } else {
                                // $hari = $_GET['date'];
                                $hari3 = date("d F Y");
                                echo $hari3;
                            }
                            ?>
                        </h3>
                        <!--                         
                        <?php
                        $today = date("Y-m-d");
                        $yesterday = date("Y-m-d", strtotime("-1 days"));
                        $tomorrow = date("Y-m-d", strtotime("+1 days"));
                        ?>
                        <form method="get">
                            <label>Tanggal</label>
                            <div class="row">
                                <div class="col-md-7">
                                    <input type="date" name="date" class="form-control" value="<?= $today ?>" />
                                </div>
                                <div class="col-md-5">
                                    <div>
                                        <button type="submit" class="btn-sm btn-primary"><i class=" ace-icon glyphicon glyphicon-search"></i>Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form> -->
                    </div><!-- /.page-header -->
                </div>
            </div>
            <div class="row">

                <!-- kadar 40% -->

                <div class="col-sm-2">
                    <h4 style="color: #07A1C8;">
                        Kadar 375%
                    </h4>
                    <h4 style="color: #07A1C8;">

                    </h4>
                </div>
                <div class="col-sm-3">
                    <!-- <h5>

                        <?php
                        if (isset($_GET['date'])) {
                            $hari = $_GET['date'];
                            $hari2 = date("d F Y", strtotime($hari));
                            echo $hari2;
                        } else {
                            // $hari = $_GET['date'];
                            $hari3 = date("d F Y");
                            echo $hari3;
                        }
                        ?>
                    </h5> -->
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table id="simple-table" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr class="titlerow">
                                    <th rowspan="2">Jenis</th>
                                    <th class="center" colspan="2" scope="colgroup">Belum Laku</th>
                                    <th class="center" colspan="2" scope="colgroup">Laku</th>
                                    <th class="center" colspan="2" scope="colgroup">Diambil</th>
                                    <th class="center" colspan="2" scope="colgroup">Tambahan</th>
                                    <th class="center" colspan="2" scope="colgroup">Total</th>
                                </tr>
                                <tr class="titlerow">
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Berat</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Berat</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Berat</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Berat</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Berat</th>
                                </tr>
                            </thead>
                            <?php
                            if (isset($_GET['date'])) {

                                $tgl = $_GET['date'];
                                $tgl2 = date("Y-m-d", strtotime($tgl . '-1 days'));
                                $tgl3 = date("Y-m-d", strtotime($tgl . '+1 days'));
                                $row = mysqli_query($koneksi, "SELECT COUNT(fc_kdkelompok) as row FROM tm_kelompok ");
                                $countrow = mysqli_fetch_array($row);
                                for ($i = 1; $i <= $countrow['row']; $i++) {
                                    $v = "00$i";
                                    // jenis barang
                                    $sql = mysqli_query($koneksi, "SELECT * FROM tm_kelompok where fc_kdkelompok = '$v'");
                                    $barang = mysqli_fetch_array($sql);
                                    //Kemarin
                                    $sql2 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tgl' and fc_kondisi = 0 and fc_kadar = 375),'0') As jumlah");
                                    $sql3 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tgl' and fc_kondisi = 0 and fc_kadar = 375),'0') As berat");
                                    $jumlah1 = mysqli_fetch_array($sql2);
                                    $berat1 = mysqli_fetch_array($sql3);
                                    //laku
                                    $sql4 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(td_invoice.fc_kdkelompok) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and td_invoice.fc_kdkelompok = '$v' and tm_invoice.fd_tglinv = '$tgl' and td_invoice.ff_kadar = 375 ),'0') As jumlah");
                                    $sql5 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(td_invoice.fn_berat) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and td_invoice.fc_kdkelompok = '$v' and tm_invoice.fd_tglinv = '$tgl' and td_invoice.ff_kadar = 375 ),'0') As berat");
                                    $jumlah2 = mysqli_fetch_array($sql4);
                                    $berat2 = mysqli_fetch_array($sql5);
                                    //diambil
                                    $sql6 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$tgl' and fc_kondisi = 1 and fc_kadar = 375),'0') As jumlah");
                                    $sql7 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$tgl' and fc_kondisi = 1 and fc_kadar = 375),'0') As berat");
                                    $jumlah3 = mysqli_fetch_array($sql6);
                                    $berat3 = mysqli_fetch_array($sql7);
                                    //tambahan
                                    $sql8 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$tgl' and fc_kondisi = 0 and fc_kadar = 375),'0') As jumlah");
                                    $sql9 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$tgl' and fc_kondisi = 0 and fc_kadar = 375),'0') As berat");
                                    $jumlah4 = mysqli_fetch_array($sql8);
                                    $berat4 = mysqli_fetch_array($sql9);
                                    //total
                                    $sql10 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tgl3' and fc_kondisi = 0 and fc_kadar = 375),'0') As jumlah");
                                    $sql11 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tgl3' and fc_kondisi = 0 and fc_kadar = 375),'0') As berat");
                                    $jumlah5 = mysqli_fetch_array($sql10);
                                    $berat5 = mysqli_fetch_array($sql11);
                            ?>
                                    <tr>
                                        <th scope="row"><?php echo $barang['fv_nmkelompok']  ?></th>
                                        <td><?php echo $jumlah1['jumlah'] ?> </td>
                                        <td><?php echo round($berat1['berat'], 2) ?></td>
                                        <td><?php echo $jumlah2['jumlah'] ?> </td>
                                        <td><?php echo round($berat2['berat'], 2) ?></td>
                                        <td><?php echo $jumlah3['jumlah'] ?> </td>
                                        <td><?php echo round($berat3['berat'], 2) ?></td>
                                        <td><?php echo $jumlah4['jumlah'] ?> </td>
                                        <td><?php echo round($berat4['berat'], 2) ?></td>
                                        <td><?php echo $jumlah5['jumlah'] ?> </td>
                                        <td><?php echo round($berat5['berat'], 2) ?></td>
                                    </tr>
                                <?php
                                }
                                //Kemarin
                                $sql12 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where  fd_date < '$tgl' and fc_kondisi = 0 and fc_kadar = 375),'0') As jumlah");
                                $sql13 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where  fd_date < '$tgl' and fc_kondisi = 0 and fc_kadar = 375),'0') As berat");
                                $jumlah6 = mysqli_fetch_array($sql12);
                                $berat6 = mysqli_fetch_array($sql13);
                                //laku
                                $sql14 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(td_invoice.fc_kdkelompok) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and  tm_invoice.fd_tglinv = '$tgl' and td_invoice.ff_kadar = 375 ),'0') As jumlah");
                                $sql15 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(td_invoice.fn_berat) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and  tm_invoice.fd_tglinv = '$tgl' and td_invoice.ff_kadar = 375 ),'0') As berat");
                                $jumlah7 = mysqli_fetch_array($sql14);
                                $berat7 = mysqli_fetch_array($sql15);
                                //diambil
                                $sql16 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where  fd_date = '$tgl' and fc_kondisi = 1 and fc_kadar = 375),'0') As jumlah");
                                $sql17 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where  fd_date = '$tgl' and fc_kondisi = 1 and fc_kadar = 375),'0') As berat");
                                $jumlah8 = mysqli_fetch_array($sql16);
                                $berat8 = mysqli_fetch_array($sql17);
                                //tambahan
                                $sql18 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where  fd_date = '$tgl' and fc_kondisi = 0 and fc_kadar = 375),'0') As jumlah");
                                $sql19 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where  fd_date = '$tgl' and fc_kondisi = 0 and fc_kadar = 375),'0') As berat");
                                $jumlah9 = mysqli_fetch_array($sql18);
                                $berat9 = mysqli_fetch_array($sql19);
                                //total
                                $sql20 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where  fd_date < '$tgl3' and fc_kondisi = 0 and fc_kadar = 375),'0') As jumlah");
                                $sql21 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where  fd_date < '$tgl3' and fc_kondisi = 0 and fc_kadar = 375),'0') As berat");
                                $jumlah10 = mysqli_fetch_array($sql20);
                                $berat10 = mysqli_fetch_array($sql21);
                                ?>
                                <tr>
                                    <th scope="row">Total</th>
                                    <th><?php echo $jumlah6['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat6['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah7['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat7['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah8['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat8['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah9['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat9['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah10['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat10['berat'], 2) ?> gram</th>
                                </tr>
                                <?php
                            } else {
                                $row = mysqli_query($koneksi, "SELECT COUNT(fc_kdkelompok) as row FROM tm_kelompok ");
                                $countrow = mysqli_fetch_array($row);
                                for ($i = 1; $i <= $countrow['row']; $i++) {
                                    $v = "00$i";
                                    // jenis barang
                                    $sql = mysqli_query($koneksi, "SELECT * FROM tm_kelompok where fc_kdkelompok = '$v'");
                                    $barang = mysqli_fetch_array($sql);
                                    //Kemarin
                                    $sql2 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$today' and fc_kondisi = 0 and fc_kadar = 375),'0') As jumlah");
                                    $sql3 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$today' and fc_kondisi = 0 and fc_kadar = 375),'0') As berat");
                                    $jumlah1 = mysqli_fetch_array($sql2);
                                    $berat1 = mysqli_fetch_array($sql3);
                                    //laku
                                    $sql4 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(td_invoice.fc_kdkelompok) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and td_invoice.fc_kdkelompok = '$v' and tm_invoice.fd_tglinv = '$today' and td_invoice.ff_kadar = 375 ),'0') As jumlah");
                                    $sql5 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(td_invoice.fn_berat) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and td_invoice.fc_kdkelompok = '$v' and tm_invoice.fd_tglinv = '$today' and td_invoice.ff_kadar = 375 ),'0') As berat");
                                    $jumlah2 = mysqli_fetch_array($sql4);
                                    $berat2 = mysqli_fetch_array($sql5);
                                    //diambil
                                    $sql6 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$today' and fc_kondisi = 1 and fc_kadar = 375),'0') As jumlah");
                                    $sql7 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$today' and fc_kondisi = 1 and fc_kadar = 375),'0') As berat");
                                    $jumlah3 = mysqli_fetch_array($sql6);
                                    $berat3 = mysqli_fetch_array($sql7);
                                    //tambahan
                                    $sql8 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$today' and fc_kondisi = 0 and fc_kadar = 375),'0') As jumlah");
                                    $sql9 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$today' and fc_kondisi = 0 and fc_kadar = 375),'0') As berat");
                                    $jumlah4 = mysqli_fetch_array($sql8);
                                    $berat4 = mysqli_fetch_array($sql9);
                                    //total
                                    $sql10 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tomorrow' and fc_kondisi = 0 and fc_kadar = 375),'0') As jumlah");
                                    $sql11 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tomorrow' and fc_kondisi = 0 and fc_kadar = 375),'0') As berat");
                                    $jumlah5 = mysqli_fetch_array($sql10);
                                    $berat5 = mysqli_fetch_array($sql11);

                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $barang['fv_nmkelompok']  ?></th>
                                        <td><?php echo $jumlah1['jumlah'] ?> </td>
                                        <td><?php echo round($berat1['berat'], 2) ?> </td>
                                        <td><?php echo $jumlah2['jumlah'] ?> </td>
                                        <td><?php echo round($berat2['berat'], 2) ?> </td>
                                        <td><?php echo $jumlah3['jumlah'] ?> </td>
                                        <td><?php echo round($berat3['berat'], 2) ?> </td>
                                        <td><?php echo $jumlah4['jumlah'] ?> </td>
                                        <td><?php echo round($berat4['berat'], 2) ?> </td>
                                        <td><?php echo $jumlah5['jumlah'] ?> </td>
                                        <td><?php echo round($berat5['berat'], 2) ?> </td>
                                    </tr>
                                <?php }

                                //kemarin
                                $sql12 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where  fd_date < '$today' and fc_kondisi = 0 and fc_kadar = 375),'0') As jumlah");
                                $sql13 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where   fd_date < '$today' and fc_kondisi = 0 and fc_kadar = 375),'0') As berat");
                                $jumlah6 = mysqli_fetch_array($sql12);
                                $berat6 = mysqli_fetch_array($sql13);
                                //laku
                                $sql14 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(td_invoice.fc_kdkelompok) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv  and tm_invoice.fd_tglinv = '$today' and td_invoice.ff_kadar = 375 ),'0') As jumlah");
                                $sql15 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(td_invoice.fn_berat) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv  and tm_invoice.fd_tglinv = '$today' and td_invoice.ff_kadar = 375 ),'0') As berat");
                                $jumlah7 = mysqli_fetch_array($sql14);
                                $berat7 = mysqli_fetch_array($sql15);
                                //diambil
                                $sql16 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where  fd_date = '$today' and fc_kondisi = 1 and fc_kadar = 375),'0') As jumlah");
                                $sql17 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where  fd_date = '$today' and fc_kondisi = 1 and fc_kadar = 375),'0') As berat");
                                $jumlah8 = mysqli_fetch_array($sql16);
                                $berat8 = mysqli_fetch_array($sql17);
                                //tambahan
                                $sql18 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where  fd_date = '$today' and fc_kondisi = 0 and fc_kadar = 375),'0') As jumlah");
                                $sql19 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where  fd_date = '$today' and fc_kondisi = 0 and fc_kadar = 375),'0') As berat");
                                $jumlah9 = mysqli_fetch_array($sql18);
                                $berat9 = mysqli_fetch_array($sql19);
                                //total
                                $sql20 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where  fd_date < '$tomorrow' and fc_kondisi = 0 and fc_kadar = 375),'0') As jumlah");
                                $sql21 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where  fd_date < '$tomorrow' and fc_kondisi = 0 and fc_kadar = 375),'0') As berat");
                                $jumlah10 = mysqli_fetch_array($sql20);
                                $berat10 = mysqli_fetch_array($sql21);
                                ?>
                                <tr>
                                    <th scope="row">Total</th>
                                    <th><?php echo $jumlah6['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat6['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah7['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat7['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah8['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat8['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah9['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat9['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah10['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat10['berat'], 2) ?> gram</th>
                                </tr>
                            <?php
                            }
                            ?>

                        </table>
                    </div>
                </div>

                <!-- KAdar 420% -->

                <div class="col-sm-12 col-xs-12">
                    <h4 style="color: #07A1C8;">
                        Kadar 420%
                    </h4>
                    <div class="table-responsive">
                        <table id="simple-table" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr class="titlerow">
                                    <th rowspan="2">Jenis</th>
                                    <th class="center" colspan="2" scope="colgroup">Belum Laku</th>
                                    <th class="center" colspan="2" scope="colgroup">Laku</th>
                                    <th class="center" colspan="2" scope="colgroup">Diambil</th>
                                    <th class="center" colspan="2" scope="colgroup">Tambahan</th>
                                    <th class="center" colspan="2" scope="colgroup">Total</th>

                                </tr>
                                <tr class="titlerow">
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Berat</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Berat</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Berat</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Berat</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Berat</th>
                                </tr>
                            </thead>
                            <?php
                            if (isset($_GET['date'])) {

                                $tgl = $_GET['date'];

                                $tgl2 = date("Y-m-d", strtotime($tgl . '-1 days'));
                                $tgl3 = date("Y-m-d", strtotime($tgl . '+1 days'));
                                $row = mysqli_query($koneksi, "SELECT COUNT(fc_kdkelompok) as row FROM tm_kelompok ");
                                $countrow = mysqli_fetch_array($row);
                                for ($i = 1; $i <= $countrow['row']; $i++) {
                                    $v = "00$i";
                                    // jenis barang
                                    $sql = mysqli_query($koneksi, "SELECT * FROM tm_kelompok where fc_kdkelompok = '$v'");
                                    $barang = mysqli_fetch_array($sql);
                                    //Kemarin
                                    $sql2 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tgl' and fc_kondisi = 0 and fc_kadar = 420),'0') As jumlah");
                                    $sql3 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tgl' and fc_kondisi = 0 and fc_kadar = 420),'0') As berat");
                                    $jumlah1 = mysqli_fetch_array($sql2);
                                    $berat1 = mysqli_fetch_array($sql3);
                                    //laku
                                    $sql4 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(td_invoice.fc_kdkelompok) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and td_invoice.fc_kdkelompok = '$v' and tm_invoice.fd_tglinv = '$tgl' and td_invoice.ff_kadar = 420 ),'0') As jumlah");
                                    $sql5 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(td_invoice.fn_berat) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and td_invoice.fc_kdkelompok = '$v' and tm_invoice.fd_tglinv = '$tgl' and td_invoice.ff_kadar = 420 ),'0') As berat");
                                    $jumlah2 = mysqli_fetch_array($sql4);
                                    $berat2 = mysqli_fetch_array($sql5);
                                    //diambil
                                    $sql6 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$tgl' and fc_kondisi = 1 and fc_kadar = 420),'0') As jumlah");
                                    $sql7 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$tgl' and fc_kondisi = 1 and fc_kadar = 420),'0') As berat");
                                    $jumlah3 = mysqli_fetch_array($sql6);
                                    $berat3 = mysqli_fetch_array($sql7);
                                    //tambahan
                                    $sql8 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$tgl' and fc_kondisi = 0 and fc_kadar = 420),'0') As jumlah");
                                    $sql9 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$tgl' and fc_kondisi = 0 and fc_kadar = 420),'0') As berat");
                                    $jumlah4 = mysqli_fetch_array($sql8);
                                    $berat4 = mysqli_fetch_array($sql9);
                                    //total
                                    $sql10 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tgl3' and fc_kondisi = 0 and fc_kadar = 420),'0') As jumlah");
                                    $sql11 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tgl3' and fc_kondisi = 0 and fc_kadar = 420),'0') As berat");
                                    $jumlah5 = mysqli_fetch_array($sql10);
                                    $berat5 = mysqli_fetch_array($sql11);
                            ?>
                                    <tr>
                                        <th scope="row"><?php echo $barang['fv_nmkelompok']  ?></th>
                                        <td><?php echo $jumlah1['jumlah'] ?> </td>
                                        <td><?php echo round($berat1['berat'], 2) ?> </td>
                                        <td><?php echo $jumlah2['jumlah'] ?> </td>
                                        <td><?php echo round($berat2['berat'], 2) ?> </td>
                                        <td><?php echo $jumlah3['jumlah'] ?> </td>
                                        <td><?php echo round($berat3['berat'], 2) ?> </td>
                                        <td><?php echo $jumlah4['jumlah'] ?> </td>
                                        <td><?php echo round($berat4['berat'], 2) ?> </td>
                                        <td><?php echo $jumlah5['jumlah'] ?> </td>
                                        <td><?php echo round($berat5['berat'], 2) ?> </td>
                                    </tr>
                                <?php
                                }
                                //Kemarin
                                $sql12 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where  fd_date < '$tgl' and fc_kondisi = 0 and fc_kadar = 420),'0') As jumlah");
                                $sql13 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where  fd_date < '$tgl' and fc_kondisi = 0 and fc_kadar = 420),'0') As berat");
                                $jumlah6 = mysqli_fetch_array($sql12);
                                $berat6 = mysqli_fetch_array($sql13);
                                //laku
                                $sql14 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(td_invoice.fc_kdkelompok) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and tm_invoice.fd_tglinv = '$tgl' and td_invoice.ff_kadar = 420 ),'0') As jumlah");
                                $sql15 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(td_invoice.fn_berat) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and tm_invoice.fd_tglinv = '$tgl' and td_invoice.ff_kadar = 420 ),'0') As berat");
                                $jumlah7 = mysqli_fetch_array($sql14);
                                $berat7 = mysqli_fetch_array($sql15);
                                //diambil
                                $sql16 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where  fd_date = '$tgl' and fc_kondisi = 1 and fc_kadar = 420),'0') As jumlah");
                                $sql17 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where  fd_date = '$tgl' and fc_kondisi = 1 and fc_kadar = 420),'0') As berat");
                                $jumlah8 = mysqli_fetch_array($sql16);
                                $berat8 = mysqli_fetch_array($sql17);
                                //tambahan
                                $sql18 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where  fd_date = '$tgl' and fc_kondisi = 0 and fc_kadar = 420),'0') As jumlah");
                                $sql19 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where  fd_date = '$tgl' and fc_kondisi = 0 and fc_kadar = 420),'0') As berat");
                                $jumlah9 = mysqli_fetch_array($sql18);
                                $berat9 = mysqli_fetch_array($sql19);
                                //total
                                $sql20 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where  fd_date < '$tgl3' and fc_kondisi = 0 and fc_kadar = 420),'0') As jumlah");
                                $sql21 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where  fd_date < '$tgl3' and fc_kondisi = 0 and fc_kadar = 420),'0') As berat");
                                $jumlah10 = mysqli_fetch_array($sql20);
                                $berat10 = mysqli_fetch_array($sql21);
                                ?>
                                <tr>
                                    <th scope="row">Total</th>
                                    <th><?php echo $jumlah6['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat6['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah7['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat7['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah8['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat8['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah9['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat9['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah10['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat10['berat'], 2) ?> gram</th>
                                </tr>
                                <?php

                            } else {
                                $row = mysqli_query($koneksi, "SELECT COUNT(fc_kdkelompok) as row FROM tm_kelompok ");
                                $countrow = mysqli_fetch_array($row);
                                for ($i = 1; $i <= $countrow['row']; $i++) {
                                    $v = "00$i";
                                    // jenis barang
                                    $sql = mysqli_query($koneksi, "SELECT * FROM tm_kelompok where fc_kdkelompok = '$v'");
                                    $barang = mysqli_fetch_array($sql);
                                    //Kemarin
                                    $sql2 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$today' and fc_kondisi = 0 and fc_kadar = 420),'0') As jumlah");
                                    $sql3 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$today' and fc_kondisi = 0 and fc_kadar = 420),'0') As berat");
                                    $jumlah1 = mysqli_fetch_array($sql2);
                                    $berat1 = mysqli_fetch_array($sql3);
                                    //laku
                                    $sql4 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(td_invoice.fc_kdkelompok) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and td_invoice.fc_kdkelompok = '$v' and tm_invoice.fd_tglinv = '$today' and td_invoice.ff_kadar = 420),'0') As jumlah");
                                    $sql5 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(td_invoice.fn_berat) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and td_invoice.fc_kdkelompok = '$v' and tm_invoice.fd_tglinv = '$today' and td_invoice.ff_kadar = 420 ),'0') As berat");
                                    $jumlah2 = mysqli_fetch_array($sql4);
                                    $berat2 = mysqli_fetch_array($sql5);
                                    //diambil
                                    $sql6 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$today' and fc_kondisi = 1 and fc_kadar = 420),'0') As jumlah");
                                    $sql7 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$today' and fc_kondisi = 1 and fc_kadar = 420),'0') As berat");
                                    $jumlah3 = mysqli_fetch_array($sql6);
                                    $berat3 = mysqli_fetch_array($sql7);
                                    //tambahan
                                    $sql8 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$today' and fc_kondisi = 0 and fc_kadar = 420),'0') As jumlah");
                                    $sql9 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$today' and fc_kondisi = 0 and fc_kadar = 420),'0') As berat");
                                    $jumlah4 = mysqli_fetch_array($sql8);
                                    $berat4 = mysqli_fetch_array($sql9);
                                    //total
                                    $sql10 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tomorrow' and fc_kondisi = 0 and fc_kadar = 420),'0') As jumlah");
                                    $sql11 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tomorrow' and fc_kondisi = 0 and fc_kadar = 420),'0') As berat");
                                    $jumlah5 = mysqli_fetch_array($sql10);
                                    $berat5 = mysqli_fetch_array($sql11);

                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $barang['fv_nmkelompok']  ?></th>
                                        <td><?php echo $jumlah1['jumlah'] ?> </td>
                                        <td><?php echo round($berat1['berat'], 2) ?></td>
                                        <td><?php echo $jumlah2['jumlah'] ?> </td>
                                        <td><?php echo round($berat2['berat'], 2) ?></td>
                                        <td><?php echo $jumlah3['jumlah'] ?> </td>
                                        <td><?php echo round($berat3['berat'], 2) ?></td>
                                        <td><?php echo $jumlah4['jumlah'] ?> </td>
                                        <td><?php echo round($berat4['berat'], 2) ?></td>
                                        <td><?php echo $jumlah5['jumlah'] ?> </td>
                                        <td><?php echo round($berat5['berat'], 2) ?></td>

                                    </tr>
                                <?php }
                                $sql12 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where   fd_date < '$today' and fc_kondisi = 0 and fc_kadar = 420),'0') As jumlah");
                                $sql13 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where   fd_date < '$today' and fc_kondisi = 0 and fc_kadar = 420),'0') As berat");
                                $jumlah6 = mysqli_fetch_array($sql12);
                                $berat6 = mysqli_fetch_array($sql13);
                                //laku
                                $sql14 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(td_invoice.fc_kdkelompok) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and   tm_invoice.fd_tglinv = '$today' and td_invoice.ff_kadar = 420),'0') As jumlah");
                                $sql15 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(td_invoice.fn_berat) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and   tm_invoice.fd_tglinv = '$today' and td_invoice.ff_kadar = 420 ),'0') As berat");
                                $jumlah7 = mysqli_fetch_array($sql14);
                                $berat7 = mysqli_fetch_array($sql15);
                                //diambil
                                $sql16 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where   fd_date = '$today' and fc_kondisi = 1 and fc_kadar = 420),'0') As jumlah");
                                $sql17 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where   fd_date = '$today' and fc_kondisi = 1 and fc_kadar = 420),'0') As berat");
                                $jumlah8 = mysqli_fetch_array($sql16);
                                $berat8 = mysqli_fetch_array($sql17);
                                //tambahan
                                $sql18 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where   fd_date = '$today' and fc_kondisi = 0 and fc_kadar = 420),'0') As jumlah");
                                $sql19 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where   fd_date = '$today' and fc_kondisi = 0 and fc_kadar = 420),'0') As berat");
                                $jumlah9 = mysqli_fetch_array($sql18);
                                $berat9 = mysqli_fetch_array($sql19);
                                //total
                                $sql20 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where   fd_date < '$tomorrow' and fc_kondisi = 0 and fc_kadar = 420),'0') As jumlah");
                                $sql21 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where   fd_date < '$tomorrow' and fc_kondisi = 0 and fc_kadar = 420),'0') As berat");
                                $jumlah10 = mysqli_fetch_array($sql20);
                                $berat10 = mysqli_fetch_array($sql21);
                                ?>
                                <tr>
                                    <th scope="row">Total</th>
                                    <th><?php echo $jumlah6['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat6['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah7['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat7['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah8['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat8['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah9['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat9['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah10['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat10['berat'], 2) ?> gram</th>
                                </tr>
                            <?php
                            }
                            ?>



                        </table>
                    </div>
                </div>

                <!-- Kadar 700 -->
                <div class="col-sm-12 col-xs-12">
                    <h4 style="color: #07A1C8;">
                        Kadar 700%
                    </h4>
                    <div class="table-responsive">
                        <table id="simple-table" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr class="titlerow">
                                    <th rowspan="2">Jenis</th>
                                    <th class="center" colspan="2" scope="colgroup">Belum Laku</th>
                                    <th class="center" colspan="2" scope="colgroup">Laku</th>
                                    <th class="center" colspan="2" scope="colgroup">Diambil</th>
                                    <th class="center" colspan="2" scope="colgroup">Tambahan</th>
                                    <th class="center" colspan="2" scope="colgroup">Total</th>

                                </tr>
                                <tr class="titlerow">
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Berat</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Berat</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Berat</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Berat</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Berat</th>
                                </tr>
                            </thead>
                            <?php
                            if (isset($_GET['date'])) {

                                $tgl = $_GET['date'];

                                $tgl2 = date("Y-m-d", strtotime($tgl . '-1 days'));
                                $tgl3 = date("Y-m-d", strtotime($tgl . '+1 days'));
                                $row = mysqli_query($koneksi, "SELECT COUNT(fc_kdkelompok) as row FROM tm_kelompok ");
                                $countrow = mysqli_fetch_array($row);
                                for ($i = 1; $i <= $countrow['row']; $i++) {
                                    $v = "00$i";
                                    // jenis barang
                                    $sql = mysqli_query($koneksi, "SELECT * FROM tm_kelompok where fc_kdkelompok = '$v'");
                                    $barang = mysqli_fetch_array($sql);
                                    //Kemarin
                                    $sql2 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tgl' and fc_kondisi = 0 and fc_kadar = 700),'0') As jumlah");
                                    $sql3 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tgl' and fc_kondisi = 0 and fc_kadar = 700),'0') As berat");
                                    $jumlah1 = mysqli_fetch_array($sql2);
                                    $berat1 = mysqli_fetch_array($sql3);
                                    //laku
                                    $sql4 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(td_invoice.fc_kdkelompok) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and td_invoice.fc_kdkelompok = '$v' and tm_invoice.fd_tglinv = '$tgl' and td_invoice.ff_kadar = 700 ),'0') As jumlah");
                                    $sql5 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(td_invoice.fn_berat) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and td_invoice.fc_kdkelompok = '$v' and tm_invoice.fd_tglinv = '$tgl' and td_invoice.ff_kadar = 700 ),'0') As berat");
                                    $jumlah2 = mysqli_fetch_array($sql4);
                                    $berat2 = mysqli_fetch_array($sql5);
                                    //diambil
                                    $sql6 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$tgl' and fc_kondisi = 1 and fc_kadar = 700),'0') As jumlah");
                                    $sql7 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$tgl' and fc_kondisi = 1 and fc_kadar = 700),'0') As berat");
                                    $jumlah3 = mysqli_fetch_array($sql6);
                                    $berat3 = mysqli_fetch_array($sql7);
                                    //tambahan
                                    $sql8 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$tgl' and fc_kondisi = 0 and fc_kadar = 700),'0') As jumlah");
                                    $sql9 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$tgl' and fc_kondisi = 0 and fc_kadar = 700),'0') As berat");
                                    $jumlah4 = mysqli_fetch_array($sql8);
                                    $berat4 = mysqli_fetch_array($sql9);
                                    //total
                                    $sql10 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tgl3' and fc_kondisi = 0 and fc_kadar = 700),'0') As jumlah");
                                    $sql11 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tgl3' and fc_kondisi = 0 and fc_kadar = 700),'0') As berat");
                                    $jumlah5 = mysqli_fetch_array($sql10);
                                    $berat5 = mysqli_fetch_array($sql11);
                            ?>
                                    <tr>
                                        <th scope="row"><?php echo $barang['fv_nmkelompok']  ?></th>
                                        <td><?php echo $jumlah1['jumlah'] ?> </td>
                                        <td><?php echo round($berat1['berat'], 2) ?> </td>
                                        <td><?php echo $jumlah2['jumlah'] ?> </td>
                                        <td><?php echo round($berat2['berat'], 2) ?> </td>
                                        <td><?php echo $jumlah3['jumlah'] ?> </td>
                                        <td><?php echo round($berat3['berat'], 2) ?> </td>
                                        <td><?php echo $jumlah4['jumlah'] ?> </td>
                                        <td><?php echo round($berat4['berat'], 2) ?> </td>
                                        <td><?php echo $jumlah5['jumlah'] ?> </td>
                                        <td><?php echo round($berat5['berat'], 2) ?> </td>
                                    </tr>
                                <?php
                                }
                                //Kemarin
                                $sql12 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where  fd_date < '$tgl' and fc_kondisi = 0 and fc_kadar = 700),'0') As jumlah");
                                $sql13 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where  fd_date < '$tgl' and fc_kondisi = 0 and fc_kadar = 700),'0') As berat");
                                $jumlah6 = mysqli_fetch_array($sql12);
                                $berat6 = mysqli_fetch_array($sql13);
                                //laku
                                $sql14 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(td_invoice.fc_kdkelompok) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and tm_invoice.fd_tglinv = '$tgl' and td_invoice.ff_kadar = 700 ),'0') As jumlah");
                                $sql15 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(td_invoice.fn_berat) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and tm_invoice.fd_tglinv = '$tgl' and td_invoice.ff_kadar = 700 ),'0') As berat");
                                $jumlah7 = mysqli_fetch_array($sql14);
                                $berat7 = mysqli_fetch_array($sql15);
                                //diambil
                                $sql16 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where  fd_date = '$tgl' and fc_kondisi = 1 and fc_kadar = 700),'0') As jumlah");
                                $sql17 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where  fd_date = '$tgl' and fc_kondisi = 1 and fc_kadar = 700),'0') As berat");
                                $jumlah8 = mysqli_fetch_array($sql16);
                                $berat8 = mysqli_fetch_array($sql17);
                                //tambahan
                                $sql18 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where  fd_date = '$tgl' and fc_kondisi = 0 and fc_kadar = 700),'0') As jumlah");
                                $sql19 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where  fd_date = '$tgl' and fc_kondisi = 0 and fc_kadar = 700),'0') As berat");
                                $jumlah9 = mysqli_fetch_array($sql18);
                                $berat9 = mysqli_fetch_array($sql19);
                                //total
                                $sql20 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where  fd_date < '$tgl3' and fc_kondisi = 0 and fc_kadar = 700),'0') As jumlah");
                                $sql21 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where  fd_date < '$tgl3' and fc_kondisi = 0 and fc_kadar = 700),'0') As berat");
                                $jumlah10 = mysqli_fetch_array($sql20);
                                $berat10 = mysqli_fetch_array($sql21);
                                ?>
                                <tr>
                                    <th scope="row">Total</th>
                                    <th><?php echo $jumlah6['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat6['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah7['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat7['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah8['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat8['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah9['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat9['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah10['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat10['berat'], 2) ?> gram</th>
                                </tr>
                                <?php

                            } else {
                                $row = mysqli_query($koneksi, "SELECT COUNT(fc_kdkelompok) as row FROM tm_kelompok ");
                                $countrow = mysqli_fetch_array($row);
                                for ($i = 1; $i <= $countrow['row']; $i++) {
                                    $v = "00$i";
                                    // jenis barang
                                    $sql = mysqli_query($koneksi, "SELECT * FROM tm_kelompok where fc_kdkelompok = '$v'");
                                    $barang = mysqli_fetch_array($sql);
                                    //Kemarin
                                    $sql2 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$today' and fc_kondisi = 0 and fc_kadar = 700),'0') As jumlah");
                                    $sql3 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$today' and fc_kondisi = 0 and fc_kadar = 700),'0') As berat");
                                    $jumlah1 = mysqli_fetch_array($sql2);
                                    $berat1 = mysqli_fetch_array($sql3);
                                    //laku
                                    $sql4 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(td_invoice.fc_kdkelompok) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and td_invoice.fc_kdkelompok = '$v' and tm_invoice.fd_tglinv = '$today' and td_invoice.ff_kadar = 700),'0') As jumlah");
                                    $sql5 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(td_invoice.fn_berat) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and td_invoice.fc_kdkelompok = '$v' and tm_invoice.fd_tglinv = '$today' and td_invoice.ff_kadar = 700 ),'0') As berat");
                                    $jumlah2 = mysqli_fetch_array($sql4);
                                    $berat2 = mysqli_fetch_array($sql5);
                                    //diambil
                                    $sql6 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$today' and fc_kondisi = 1 and fc_kadar = 700),'0') As jumlah");
                                    $sql7 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$today' and fc_kondisi = 1 and fc_kadar = 700),'0') As berat");
                                    $jumlah3 = mysqli_fetch_array($sql6);
                                    $berat3 = mysqli_fetch_array($sql7);
                                    //tambahan
                                    $sql8 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$today' and fc_kondisi = 0 and fc_kadar = 700),'0') As jumlah");
                                    $sql9 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$today' and fc_kondisi = 0 and fc_kadar = 700),'0') As berat");
                                    $jumlah4 = mysqli_fetch_array($sql8);
                                    $berat4 = mysqli_fetch_array($sql9);
                                    //total
                                    $sql10 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tomorrow' and fc_kondisi = 0 and fc_kadar = 700),'0') As jumlah");
                                    $sql11 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tomorrow' and fc_kondisi = 0 and fc_kadar = 700),'0') As berat");
                                    $jumlah5 = mysqli_fetch_array($sql10);
                                    $berat5 = mysqli_fetch_array($sql11);

                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $barang['fv_nmkelompok']  ?></th>
                                        <td><?php echo $jumlah1['jumlah'] ?> </td>
                                        <td><?php echo round($berat1['berat'], 2) ?></td>
                                        <td><?php echo $jumlah2['jumlah'] ?> </td>
                                        <td><?php echo round($berat2['berat'], 2) ?></td>
                                        <td><?php echo $jumlah3['jumlah'] ?> </td>
                                        <td><?php echo round($berat3['berat'], 2) ?></td>
                                        <td><?php echo $jumlah4['jumlah'] ?> </td>
                                        <td><?php echo round($berat4['berat'], 2) ?></td>
                                        <td><?php echo $jumlah5['jumlah'] ?> </td>
                                        <td><?php echo round($berat5['berat'], 2) ?></td>

                                    </tr>
                                <?php }
                                $sql12 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where   fd_date < '$today' and fc_kondisi = 0 and fc_kadar = 700),'0') As jumlah");
                                $sql13 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where   fd_date < '$today' and fc_kondisi = 0 and fc_kadar = 700),'0') As berat");
                                $jumlah6 = mysqli_fetch_array($sql12);
                                $berat6 = mysqli_fetch_array($sql13);
                                //laku
                                $sql14 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(td_invoice.fc_kdkelompok) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and   tm_invoice.fd_tglinv = '$today' and td_invoice.ff_kadar = 700),'0') As jumlah");
                                $sql15 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(td_invoice.fn_berat) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and   tm_invoice.fd_tglinv = '$today' and td_invoice.ff_kadar = 700 ),'0') As berat");
                                $jumlah7 = mysqli_fetch_array($sql14);
                                $berat7 = mysqli_fetch_array($sql15);
                                //diambil
                                $sql16 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where   fd_date = '$today' and fc_kondisi = 1 and fc_kadar = 700),'0') As jumlah");
                                $sql17 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where   fd_date = '$today' and fc_kondisi = 1 and fc_kadar = 700),'0') As berat");
                                $jumlah8 = mysqli_fetch_array($sql16);
                                $berat8 = mysqli_fetch_array($sql17);
                                //tambahan
                                $sql18 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where   fd_date = '$today' and fc_kondisi = 0 and fc_kadar = 700),'0') As jumlah");
                                $sql19 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where   fd_date = '$today' and fc_kondisi = 0 and fc_kadar = 700),'0') As berat");
                                $jumlah9 = mysqli_fetch_array($sql18);
                                $berat9 = mysqli_fetch_array($sql19);
                                //total
                                $sql20 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where   fd_date < '$tomorrow' and fc_kondisi = 0 and fc_kadar = 700),'0') As jumlah");
                                $sql21 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where   fd_date < '$tomorrow' and fc_kondisi = 0 and fc_kadar = 700),'0') As berat");
                                $jumlah10 = mysqli_fetch_array($sql20);
                                $berat10 = mysqli_fetch_array($sql21);
                                ?>
                                <tr>
                                    <th scope="row">Total</th>
                                    <th><?php echo $jumlah6['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat6['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah7['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat7['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah8['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat8['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah9['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat9['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah10['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat10['berat'], 2) ?> gram</th>
                                </tr>
                            <?php
                            }
                            ?>



                        </table>
                    </div>
                </div>

                <div class="col-sm-12 col-xs-12">
                    <h4 style="color: #07A1C8;">
                        Kadar 99.9%
                    </h4>
                    <div class="table-responsive">
                        <table id="simple-table" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr class="titlerow">
                                    <th rowspan="2">Jenis</th>
                                    <th class="center" colspan="2" scope="colgroup">Belum Laku</th>
                                    <th class="center" colspan="2" scope="colgroup">Laku</th>
                                    <th class="center" colspan="2" scope="colgroup">Diambil</th>
                                    <th class="center" colspan="2" scope="colgroup">Tambahan</th>
                                    <th class="center" colspan="2" scope="colgroup">Total</th>

                                </tr>
                                <tr class="titlerow">
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Berat</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Berat</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Berat</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Berat</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Berat</th>
                                </tr>
                            </thead>
                            <?php
                            if (isset($_GET['date'])) {

                                $tgl = $_GET['date'];

                                $tgl2 = date("Y-m-d", strtotime($tgl . '-1 days'));
                                $tgl3 = date("Y-m-d", strtotime($tgl . '+1 days'));
                                $row = mysqli_query($koneksi, "SELECT COUNT(fc_kdkelompok) as row FROM tm_kelompok ");
                                $countrow = mysqli_fetch_array($row);
                                for ($i = 1; $i <= $countrow['row']; $i++) {
                                    $v = "00$i";
                                    // jenis barang
                                    $sql = mysqli_query($koneksi, "SELECT * FROM tm_kelompok where fc_kdkelompok = '$v'");
                                    $barang = mysqli_fetch_array($sql);
                                    //Kemarin
                                    $sql2 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tgl' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As jumlah");
                                    $sql3 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tgl' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As berat");
                                    $jumlah1 = mysqli_fetch_array($sql2);
                                    $berat1 = mysqli_fetch_array($sql3);
                                    //laku
                                    $sql4 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(td_invoice.fc_kdkelompok) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and td_invoice.fc_kdkelompok = '$v' and tm_invoice.fd_tglinv = '$tgl' and td_invoice.ff_kadar = 99.9 ),'0') As jumlah");
                                    $sql5 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(td_invoice.fn_berat) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and td_invoice.fc_kdkelompok = '$v' and tm_invoice.fd_tglinv = '$tgl' and td_invoice.ff_kadar = 99.9 ),'0') As berat");
                                    $jumlah2 = mysqli_fetch_array($sql4);
                                    $berat2 = mysqli_fetch_array($sql5);
                                    //diambil
                                    $sql6 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$tgl' and fc_kondisi = 1 and fc_kadar = 99.9),'0') As jumlah");
                                    $sql7 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$tgl' and fc_kondisi = 1 and fc_kadar = 99.9),'0') As berat");
                                    $jumlah3 = mysqli_fetch_array($sql6);
                                    $berat3 = mysqli_fetch_array($sql7);
                                    //tambahan
                                    $sql8 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$tgl' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As jumlah");
                                    $sql9 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$tgl' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As berat");
                                    $jumlah4 = mysqli_fetch_array($sql8);
                                    $berat4 = mysqli_fetch_array($sql9);
                                    //total
                                    $sql10 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tgl3' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As jumlah");
                                    $sql11 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tgl3' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As berat");
                                    $jumlah5 = mysqli_fetch_array($sql10);
                                    $berat5 = mysqli_fetch_array($sql11);
                            ?>
                                    <tr>
                                        <th scope="row"><?php echo $barang['fv_nmkelompok']  ?></th>
                                        <td><?php echo $jumlah1['jumlah'] ?> </td>
                                        <td><?php echo round($berat1['berat'], 2) ?> </td>
                                        <td><?php echo $jumlah2['jumlah'] ?> </td>
                                        <td><?php echo round($berat2['berat'], 2) ?> </td>
                                        <td><?php echo $jumlah3['jumlah'] ?> </td>
                                        <td><?php echo round($berat3['berat'], 2) ?> </td>
                                        <td><?php echo $jumlah4['jumlah'] ?> </td>
                                        <td><?php echo round($berat4['berat'], 2) ?> </td>
                                        <td><?php echo $jumlah5['jumlah'] ?> </td>
                                        <td><?php echo round($berat5['berat'], 2) ?> </td>
                                    </tr>
                                <?php
                                }
                                //Kemarin
                                $sql12 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where  fd_date < '$tgl' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As jumlah");
                                $sql13 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where  fd_date < '$tgl' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As berat");
                                $jumlah6 = mysqli_fetch_array($sql12);
                                $berat6 = mysqli_fetch_array($sql13);
                                //laku
                                $sql14 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(td_invoice.fc_kdkelompok) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and tm_invoice.fd_tglinv = '$tgl' and td_invoice.ff_kadar = 99.9 ),'0') As jumlah");
                                $sql15 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(td_invoice.fn_berat) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and tm_invoice.fd_tglinv = '$tgl' and td_invoice.ff_kadar = 99.9 ),'0') As berat");
                                $jumlah7 = mysqli_fetch_array($sql14);
                                $berat7 = mysqli_fetch_array($sql15);
                                //diambil
                                $sql16 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where  fd_date = '$tgl' and fc_kondisi = 1 and fc_kadar = 99.9),'0') As jumlah");
                                $sql17 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where  fd_date = '$tgl' and fc_kondisi = 1 and fc_kadar = 99.9),'0') As berat");
                                $jumlah8 = mysqli_fetch_array($sql16);
                                $berat8 = mysqli_fetch_array($sql17);
                                //tambahan
                                $sql18 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where  fd_date = '$tgl' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As jumlah");
                                $sql19 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where  fd_date = '$tgl' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As berat");
                                $jumlah9 = mysqli_fetch_array($sql18);
                                $berat9 = mysqli_fetch_array($sql19);
                                //total
                                $sql20 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where  fd_date < '$tgl3' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As jumlah");
                                $sql21 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where  fd_date < '$tgl3' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As berat");
                                $jumlah10 = mysqli_fetch_array($sql20);
                                $berat10 = mysqli_fetch_array($sql21);
                                ?>
                                <tr>
                                    <th scope="row">Total</th>
                                    <th><?php echo $jumlah6['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat6['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah7['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat7['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah8['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat8['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah9['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat9['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah10['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat10['berat'], 2) ?> gram</th>
                                </tr>
                                <?php

                            } else {
                                $row = mysqli_query($koneksi, "SELECT COUNT(fc_kdkelompok) as row FROM tm_kelompok ");
                                $countrow = mysqli_fetch_array($row);
                                for ($i = 1; $i <= $countrow['row']; $i++) {
                                    $v = "00$i";
                                    // jenis barang
                                    $sql = mysqli_query($koneksi, "SELECT * FROM tm_kelompok where fc_kdkelompok = '$v'");
                                    $barang = mysqli_fetch_array($sql);
                                    //Kemarin
                                    $sql2 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$today' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As jumlah");
                                    $sql3 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$today' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As berat");
                                    $jumlah1 = mysqli_fetch_array($sql2);
                                    $berat1 = mysqli_fetch_array($sql3);
                                    //laku
                                    $sql4 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(td_invoice.fc_kdkelompok) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and td_invoice.fc_kdkelompok = '$v' and tm_invoice.fd_tglinv = '$today' and td_invoice.ff_kadar = 99.9),'0') As jumlah");
                                    $sql5 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(td_invoice.fn_berat) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and td_invoice.fc_kdkelompok = '$v' and tm_invoice.fd_tglinv = '$today' and td_invoice.ff_kadar = 99.9 ),'0') As berat");
                                    $jumlah2 = mysqli_fetch_array($sql4);
                                    $berat2 = mysqli_fetch_array($sql5);
                                    //diambil
                                    $sql6 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$today' and fc_kondisi = 1 and fc_kadar = 99.9),'0') As jumlah");
                                    $sql7 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$today' and fc_kondisi = 1 and fc_kadar = 99.9),'0') As berat");
                                    $jumlah3 = mysqli_fetch_array($sql6);
                                    $berat3 = mysqli_fetch_array($sql7);
                                    //tambahan
                                    $sql8 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$today' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As jumlah");
                                    $sql9 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date = '$today' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As berat");
                                    $jumlah4 = mysqli_fetch_array($sql8);
                                    $berat4 = mysqli_fetch_array($sql9);
                                    //total
                                    $sql10 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tomorrow' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As jumlah");
                                    $sql11 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where fc_kdkelompok = '$v' and fd_date < '$tomorrow' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As berat");
                                    $jumlah5 = mysqli_fetch_array($sql10);
                                    $berat5 = mysqli_fetch_array($sql11);

                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $barang['fv_nmkelompok']  ?></th>
                                        <td><?php echo $jumlah1['jumlah'] ?> </td>
                                        <td><?php echo round($berat1['berat'], 2) ?></td>
                                        <td><?php echo $jumlah2['jumlah'] ?> </td>
                                        <td><?php echo round($berat2['berat'], 2) ?></td>
                                        <td><?php echo $jumlah3['jumlah'] ?> </td>
                                        <td><?php echo round($berat3['berat'], 2) ?></td>
                                        <td><?php echo $jumlah4['jumlah'] ?> </td>
                                        <td><?php echo round($berat4['berat'], 2) ?></td>
                                        <td><?php echo $jumlah5['jumlah'] ?> </td>
                                        <td><?php echo round($berat5['berat'], 2) ?></td>

                                    </tr>
                                <?php }
                                $sql12 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where   fd_date < '$today' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As jumlah");
                                $sql13 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where   fd_date < '$today' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As berat");
                                $jumlah6 = mysqli_fetch_array($sql12);
                                $berat6 = mysqli_fetch_array($sql13);
                                //laku
                                $sql14 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(td_invoice.fc_kdkelompok) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and   tm_invoice.fd_tglinv = '$today' and td_invoice.ff_kadar = 99.9),'0') As jumlah");
                                $sql15 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(td_invoice.fn_berat) from td_invoice, tm_invoice where tm_invoice.fc_noinv = td_invoice.fc_noinv and   tm_invoice.fd_tglinv = '$today' and td_invoice.ff_kadar = 99.9 ),'0') As berat");
                                $jumlah7 = mysqli_fetch_array($sql14);
                                $berat7 = mysqli_fetch_array($sql15);
                                //diambil
                                $sql16 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where   fd_date = '$today' and fc_kondisi = 1 and fc_kadar = 99.9),'0') As jumlah");
                                $sql17 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where   fd_date = '$today' and fc_kondisi = 1 and fc_kadar = 99.9),'0') As berat");
                                $jumlah8 = mysqli_fetch_array($sql16);
                                $berat8 = mysqli_fetch_array($sql17);
                                //tambahan
                                $sql18 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where   fd_date = '$today' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As jumlah");
                                $sql19 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where   fd_date = '$today' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As berat");
                                $jumlah9 = mysqli_fetch_array($sql18);
                                $berat9 = mysqli_fetch_array($sql19);
                                //total
                                $sql20 = mysqli_query($koneksi, "SELECT IFNULL((select COUNT(fc_kdkelompok) from tm_stock where   fd_date < '$tomorrow' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As jumlah");
                                $sql21 = mysqli_query($koneksi, "SELECT IFNULL((select SUM(ff_berat) from tm_stock where   fd_date < '$tomorrow' and fc_kondisi = 0 and fc_kadar = 99.9),'0') As berat");
                                $jumlah10 = mysqli_fetch_array($sql20);
                                $berat10 = mysqli_fetch_array($sql21);
                                ?>
                                <tr>
                                    <th scope="row">Total</th>
                                    <th><?php echo $jumlah6['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat6['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah7['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat7['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah8['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat8['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah9['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat9['berat'], 2) ?> gram</th>
                                    <th><?php echo $jumlah10['jumlah'] ?> buah </th>
                                    <th><?php echo round($berat10['berat'], 2) ?> gram</th>
                                </tr>
                            <?php
                            }
                            ?>



                        </table>
                    </div>
                </div>

            </div>

        </div>



        <?php $this->load->view('partials/footer.php') ?>
        <?php $this->load->view('partials/js.php') ?>