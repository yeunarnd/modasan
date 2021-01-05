<table class="table table-bordered">
    <thead>
        <tr>
            <th class="center">
                <input type="checkbox" id="check-all" />
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
        foreach ($search as $s) : ?>
            <tr>
                <td class="check">
                    <input type="checkbox" class="check-item" id="sales" name="fc_salesid[]" value="<?php echo $s->fc_salesid ?>">
                </td>
                <th scope="row"><?= $no++ ?></th>
                <td scope="row"><?= $s->fc_salesid ?></td>
                <td scope="row"><?= $s->fv_nama ?></td>
                <td scope="row"><?= $s->fc_email ?></td>
                <td scope="row"><?= $s->fc_hp ?></td>
                <td scope="row"><?= $s->fc_aktif ?></td>
                <td scope="row"><?= $s->fc_kdposisi ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>