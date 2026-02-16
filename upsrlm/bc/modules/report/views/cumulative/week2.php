<?php ?>
<table id='report' class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">District</th>
            <th class="text-center">Partner agency</th>
            <th class="text-center bg-success-900">Certified BC</th>
            <th colspan="3" class="text-center bg-info-300">PVR</th>
            <th colspan="3" class="text-center bg-warning-300">BC-SHG assigned</th>
            <th colspan="3" class="text-center bg-primary-300">BC-SHG bank a/c verified</th>
            <th colspan="3" class="text-center bg-success-500">PFMS mapping</th>
            <th colspan="3" class="text-center bg-danger-300">BC-support fund (SHG)</th>
            <th colspan="3" class="text-center bg-danger-400">BC-support fund (BC ack.)</th>
            <th colspan="3" class="text-center bg-info-500">Handheld machine provided</th>
            <th colspan="3" class="text-center bg-info-600">Handheld machine acknowledged</th>
            <th class="text-center">BC-Bank txn</th>
            <th class="text-center">Data updated_on</th>
        </tr>  
    </thead>
    <tbody>
        <?php
        foreach ($data->return_array as $key => $value) {
            $class = '';
            if ($key == 1) {
                $class = 'font-weight-bold bg-warning-100';
            }
            ?>
            <tr class="<?= $class ?>">
                <td><?= $value[0] ?></td>
                <td><?= $value[1] ?></td>
                <td><?= $value[2] ?></td>
                <td><?= $value[3] ?></td>
                <td><?= $value[4] ?></td>
                <td><?= $value[5] ?></td>
                <td><?= $value[6] ?></td>
                <td><?= $value[7] ?></td>
                <td><?= $value[8] ?></td>
                <td><?= $value[9] ?></td>
                <td><?= $value[10] ?></td>
                <td><?= $value[11] ?></td>
                <td><?= $value[12] ?></td>
                <td><?= $value[13] ?></td>
                <td><?= $value[14] ?></td>
                <td><?= $value[15] ?></td>
                <td><?= $value[16] ?></td>
                <td><?= $value[17] ?></td>
                <td><?= $value[18] ?></td>
                <td><?= $value[19] ?></td>
                <td><?= $value[20] ?></td>
                <td><?= $value[21] ?></td>
                <td><?= $value[22] ?></td>
                <td><?= $value[23] ?></td>
                <td><?= $value[24] ?></td>
                <td><?= $value[25] ?></td>
                <td><?= $value[26] ?></td>
                <td><?= $value[27] ?></td>
                <td><?= $value[28] ?></td>
                <td><?= $value[29] ?></td>
            </tr>   
        <?php } ?>
    </tbody>
</table>    