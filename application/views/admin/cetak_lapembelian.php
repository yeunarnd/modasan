<?php $this->load->view('partials/header.php') ?>
<?php
$koneksi =  mysqli_connect("localhost", "root", "", "tokoemas");
?>
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <!-- /section:settings.box -->
            <div class="page-header">
                <h1>
                    Laporan Pembelian
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-xs-12 col-sm-3">
                    <div class="widget-box">
                        <div class="widget-body">
                            <div class="widget-main">
                                <?php
                                $today = date("Y-m-d");
                                $yesterday = date("Y-m-d", strtotime("-1 days"));
                                ?>
                                <form method="get">
                                    <label>Mulai Tanggal</label>
                                    <input type="date" name="startdate" class="form-control" value="<?= $yesterday ?>" />
                                    <label>S/D Tanggal</label>
                                    <input type="date" name="enddate" class="form-control" value="<?= $today ?>" />

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-xs-12 col-sm-3">
                    <?php
                    if (isset($_GET['startdate'])) {
                        $tgl = $_GET['startdate'];
                        $tgl2 = $_GET['enddate'];
                        $sql = mysqli_query($koneksi, "SELECT * FROM t_belimst WHERE fd_tglbeli between '$tgl' AND '$tgl2'");
                        $sql2 = mysqli_query($koneksi, "SELECT SUM(fm_total) as gtotal FROM t_belimst  WHERE  fd_tglbeli between '$tgl' AND '$tgl2'");
                        $sql3 = mysqli_query($koneksi, "SELECT SUM(fm_total) as stotal FROM t_belimst  WHERE  fd_tglbeli between '$tgl' AND '$tgl2'");
                        $sql4 = mysqli_query($koneksi, "SELECT  SUM(fn_berat) as berat FROM t_belimst, t_belidtl WHERE t_belimst.fc_nobeli=t_belidtl.fc_nobeli and  fd_tglbeli between '$tgl' AND '$tgl2'");
                        $sql5 = mysqli_query($koneksi, "SELECT COUNT(fc_nobeli) as transaksi FROM t_belimst WHERE fd_tglbeli between '$tgl' AND '$tgl2'");
                        $gtotal = mysqli_fetch_array($sql2);
                        $stotal = mysqli_fetch_array($sql3);
                        $berat = mysqli_fetch_array($sql4);
                        $tran = mysqli_fetch_array($sql5);
                    }

                    // } else if (isset($_GET['shift'])){
                    //     $shift = $_GET['shift'];
                    //     $sql = mysqli_query($koneksi, "SELECT * FROM tb_transaksi WHERE shift = '$shift' ");
                    else {
                        $sql = mysqli_query($koneksi, "SELECT * FROM t_belimst");
                        $sql2 = mysqli_query($koneksi, "SELECT SUM(fm_total) as gtotal FROM t_belimst ");
                        $sql3 = mysqli_query($koneksi, "SELECT SUM(fm_total) as stotal FROM t_belimst  ");
                        $sql4 = mysqli_query($koneksi, "SELECT  SUM(fn_berat) as berat FROM t_belimst, t_belidtl WHERE t_belimst.fc_nobeli=t_belidtl.fc_nobeli ");
                        $sql5 = mysqli_query($koneksi, "SELECT COUNT(fc_nobeli) as transaksi FROM t_belimst ");
                        $gtotal = mysqli_fetch_array($sql2);
                        $stotal = mysqli_fetch_array($sql3);
                        $berat = mysqli_fetch_array($sql4);
                        $tran = mysqli_fetch_array($sql5);
                    }
                    ?>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <form>
                        <div>
                            <label for="form-field-8">Transaksi</label>
                            <input type="text" class="form-control" value="<?php echo $tran['transaksi'] ?>">
                        </div>
                        <div>
                            <label for=" form-field-9">Berat</label>
                            <input type="text" class="form-control" value="<?php echo number_format($berat['berat']) ?> KG">
                        </div>
                    </form>
                </div>
                <div class=" col-xs-12 col-sm-3">
                    <form>
                        <div>
                            <label for="form-field-8">Grand Total</label>
                            <input type="text" class="form-control" value="Rp. <?php echo number_format($gtotal['gtotal']) ?>">
                        </div>
                        <div>
                            <label for=" form-field-9">Sub Total</label>
                            <input type="text" class="form-control" value="Rp. <?php echo number_format($stotal['stotal']) ?>">
                        </div>
                    </form>
                </div>
            </div>
            <div class=" row">
                <div class="col-xs-12" style="margin-top: 30px;">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="row">
                        <div class="col-xs-12">
                            <table id="simple-table" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr class="titlerow">
                                        <th>No</th>
                                        <th>Detail</th>
                                        <th>Subtotal</th>
                                        <th>Potongan</th>
                                        <th>Grand Total</th>
                                        <th>Berat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    while ($lp = mysqli_fetch_array($sql)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $lp['fc_nobeli'] ?></td>
                                            <td><?php echo $lp['fc_kdpel'] ?></td>
                                            <td>Rp. <?php echo number_format($lp['fm_subtot']);  ?></td>
                                            <td><?php echo $lp['fm_pot'] ?></td>
                                            <td>Rp. <?php echo number_format($lp['fm_total']);  ?></td>
                                            <td><?php echo $lp['fc_kdpel'] ?></td>


                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div><!-- /.main-container -->
</div>

<script>
window.print();
</script>
<?php $this->load->view('partials/js.php') ?>