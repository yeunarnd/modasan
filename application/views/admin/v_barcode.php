<style>
.other {background-color: #e7e7e7; color: black;} 
</style>
<table>
<tr>
<td colspan="3" style="background-color: #e7e7e7;"><?php echo $nama_tokone ?></td>
</tr>
<tr>
<td style="background-color: #e7e7e7;"><?php echo $kode_stock ?></td>
<td style="background-color: #e7e7e7;"><?php echo $berat ?></td>
<td style="background-color: #e7e7e7;"><?php echo $kadar ?></td>
</tr>
<tr>
<td colspan="2" style="background-color: #e7e7e7;"><?php echo $nama_barang ?></td>
<td style="background-color: #e7e7e7;"><?php echo $kelompok ?></td>
</tr>
<tr>
<td style="background-color: #e7e7e7;" colspan="3"><?php echo $lokasi ?></td>
</tr>
<tr>
<td style="background-color: #e7e7e7;" colspan="3"><img src="<?php echo base_url('C_barang/Barcode/'.$barcode)?>" /></td>
</tr>
</table>
