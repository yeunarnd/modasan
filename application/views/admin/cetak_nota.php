<?php $this->load->view('partials/header.php') ?>



<!-- /section:basics/sidebar.horizontal -->
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <!-- /section:settings.box -->
            <!-- <div class="page-header"> -->
            <div class="row">
                <div class="col-xs-1"></div>
                <div class="col-xs-6 col-sm-5">
                    <br>
                    <br>
                    <a style="font-family: times new roman; font-size: 35px; font-style: bold;">
                        <img src="<?= base_url('assets/img/logo_modasan.png') ?>" width="70" />
                        -M O D A S A N-
                    </a>
                </div>
                <div class=" col-xs-4 col-sm-6">
                    <div class="">
                        <form>
                            <div class="row">
                                <label class="col-xs-3 control-label no-padding-right" for="form-field-1">Nama</label>

                                <div class="col-xs-9">
                                    <input type="text" id="form-field-1" placeholder="" value="<?= $nota->fv_nmpelanggan ?>" readonly class=" col-sm-5" />
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-xs-3 control-label no-padding-right" for="form-field-1">Alamat</label>

                                <div class="col-xs-9">
                                    <input type="text" id="form-field-1" placeholder="" value="<?= $nota->f_alamat ?>" readonly class="col-xs-7 col-sm-5" />
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-xs-3 control-label no-padding-right" for="form-field-1">No. Telp</label>

                                <div class="col-xs-9">
                                    <input type="text" id="form-field-1" placeholder="" readonly value="<?= $nota->fc_telp ?>" class=" col-sm-5" />
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div><!-- /.span -->
            <div class="row">
                <div class="col-xs-12" style="margin-top: 30px;">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="row">
                        <div class="col-xs-12">
                            <table id="simple-table" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Jenis Barang</th>
                                        <th>Gambar</th>
                                        <th>Kadar</th>
                                        <th>Berat</th>
                                        <th>Ongkos</th>
                                        <th>Harga Pergram</th>
                                        <th>Harga Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($barang as $brg) : ?>
                                        <tr>
                                            <td><?= $brg->fv_nmbarang ?></td>
                                            <td><img src="<?= base_url('assets/img/foto_barang/' . $brg->f_foto) ?>" width="70"></td>
                                            <td><?= $brg->fc_kadar ?>%</td>
                                            <td><?= $brg->ff_berat ?> gram</td>
                                            <td>Rp.<?= number_format($brg->fm_ongkos); ?></td>
                                            <td>Rp.<?= number_format($brg->fm_price); ?></td>
                                            <td>Rp.<?= number_format($brg->fm_subtot); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                        </div>

                        <div class="col-xs-9">
                            <label class="col-xs-2" for="form-field-1">Terbilang</label>
                            <input class="col-xs-10" type="text" id="form-field-1" value="<?= $nota->fv_terbilang ?>" placeholder="" />
                        </div>
                        <div class="col-xs-3">
                            <label for="">Total </label>
                            <input type="text" id="form-field-1" class="no-padding-right" value="Rp.<?= number_format($nota->fm_grandtotal); ?>" placeholder="" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 20px;">
                <div class="col-xs-12" style="margin-left: 10%;">
                    <input type="text" style="color: red;" readonly class="col-xs-3 center" value="Jual di potong 5% - tukar tambah 4%">
                </div>
            </div>
            <div class="row" style="margin-top: 15px;">
                <div class="col-xs-8">
                    <p>Perhiasan Rusak&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ...................</p>
                    <p>Perhiasan Tidak Sepasang : ..................</p>
                    <h3 style="margin-top: 40px; font-family: Brush Script MT;">Terima Kasih Atas Kunjungan dan Kepercayaan Anda</h3>
                </div>
                <div class="col-xs-4">
                    <h5>Malang, <?php echo date("d F Y", strtotime($nota->fd_tglinv)) ?></h5>
                    <img src="<?php echo base_url() ?>assets/img/modasan.jpg" width="150">
                    <p>............................................</p>
                </div>
            </div>


            <div class="row" style="margin-top: 20px;">
                <div class="col-xs-4">
                    <input type="text" class="col-xs-10" value="Open Daily: 09.00-20.00" readonly />
                </div>
                <div class="col-xs-5">
                    <h5><i class="fa fa-instagram"></i> Modasan_Gold / Modasan_Butik</h5>
                </div>
                <div class="col-sx-3">
                    <h5><i class="fa fa-facebook"></i> Modasan 20/9/2019</h5>
                </div>
                <!-- </div> -->

            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>


</div>
<script>
    window.onload = function(event) {
        window.print();
	};

    window.onafterprint = function(){
		 window.location.href = "<?php echo base_url('C_penjualan') ?>";
	};
</script>
<!-- <script>
        $.ajax({
            url: "<?php echo base_url('C_penjualan/simpan_penjualan/') ?>",
            type: "POST",
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
</script> -->

<?php $this->load->view('partials/js.php') ?>