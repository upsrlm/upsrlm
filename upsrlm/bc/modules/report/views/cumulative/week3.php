<?php ?>
<table id='report' class="table  table-bordered tbl_sort">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">District</th>
            <th class="text-center">Partner agency</th>
            <th class="text-center bg-primary-600">Certified BC</th>
            <th colspan="4" class="text-center bg-danger-400">PVR</th>
            <th colspan="4" class="text-center bg-warning-800">BC-SHG assigned</th>
            <th colspan="4" class="text-center bg-warning-500">BC-SHG bank a/c verified</th>
            <th colspan="4" class="text-center bg-info-600">PFMS mapping</th>
            <th colspan="4" class="text-center bg-info-400">BC-support fund (SHG)</th>
            <th colspan="4" class="text-center  bg-primary-400">BC-support fund (BC ack.)</th>
            <th colspan="4" class="text-center bg-success-400">Handheld machine provided</th>
            <th colspan="4" class="text-center  bg-primary-400">Handheld machine acknowledged</th>
            <th class="text-center">BC-Bank txn</th>
            <th class="text-center">Data updated_on</th>
        </tr>  
   

    <?php
    foreach ($data->return_array as $key => $value) {
        $class = '';
        if ($key == 0) {
            ?>
             <tr>
                    <th><?= $value[0] ?></th>
                    <th><?= $value[1] ?></th>
                    <th><?= $value[2] ?></th>
                    <th class="text-center bg-primary-600" style="filter:opacity(80%);"><?= $value[3] ?></th>
                    <th class="text-center bg-danger-400"  style="filter:opacity(80%);"><?= $value[4] ?></th>
                    <th><?= $value[5] ?></th>
                    <th><?= $value[6] ?></th>
                    <th><?= $value[7] ?></th>
                    <th class="text-center bg-warning-800" style="filter:opacity(80%);"><?= $value[8] ?></th>
                    <th><?= $value[9] ?></th>
                    <th><?= $value[10] ?></th>
                    <th><?= $value[11] ?></th>
                    <th class="text-center bg-warning-500" style="filter:opacity(80%);"><?= $value[12] ?></th>
                    <th><?= $value[13] ?></th>
                    <th><?= $value[14] ?></th>
                    <th><?= $value[15] ?></th>
                    <th class="text-center bg-info-600" style="filter:opacity(80%);"><?= $value[16] ?></th>
                    <th><?= $value[17] ?></th>
                    <th><?= $value[18] ?></th>
                    <th><?= $value[19] ?></th>
                    <th class="text-center bg-info-400" style="filter:opacity(80%);"><?= $value[20] ?></th>
                    <th><?= $value[21] ?></th>
                    <th><?= $value[22] ?></th>
                    <th><?= $value[23] ?></th>
                    <th class="text-center  bg-primary-400" style="filter:opacity(80%);"><?= $value[24] ?></th>
                    <th><?= $value[25] ?></th>
                    <th><?= $value[26] ?></th>
                    <th><?= $value[27] ?></th>
                    <th class="text-center bg-success-400" style="filter:opacity(80%);"><?= $value[28] ?></th>
                    <th><?= $value[29] ?></th>
                    <th><?= $value[30] ?></th>
                    <th><?= $value[31] ?></th>
                    <th class="text-center  bg-primary-400" style="filter:opacity(80%);"><?= $value[32] ?></th>
                    <th><?= $value[33] ?></th>
                    <th><?= $value[34] ?></th>
                    <th><?= $value[35] ?></th>
                    <th><?= $value[36] ?></th>
                    <th><?= $value[37] ?></th>

                </tr>    </thead>

        <?php
        } else {

            if ($key == 1) {
                $class = 'font-weight-bold bg-primary-300';
                echo " <tbody>";
            }
            ?>
            <tr class="<?= $class ?>">
                <td><?= $value[0] ?></td>
                <td><?= $value[1] ?></td>
                <td><?= $value[2] ?></td>
                <td class="text-center bg-primary-600"  style="filter:opacity(80%);"><?= $value[3] ?></td>
                <td class="text-center bg-danger-400"  style="filter:opacity(80%);"><?= $value[4] ?></td>
                <td ><?= $value[5] ?></td>
                <td ><?= $value[6] ?></td>
                <td ><?= $value[7] ?></td>
                <td class="text-center bg-warning-800" style="filter:opacity(80%);"><?= $value[8] ?></td>
                <td><?= $value[9] ?></td>
                <td><?= $value[10] ?></td>
                <td><?= $value[11] ?></td>
                <td class="text-center bg-warning-500" style="filter:opacity(80%);"><?= $value[12] ?></td>
                <td><?= $value[13] ?></td>
                <td><?= $value[14] ?></td>
                <td><?= $value[15] ?></td>
                <td class="text-center bg-info-600" style="filter:opacity(80%);"><?= $value[16] ?></td>
                <td><?= $value[17] ?></td>
                <td><?= $value[18] ?></td>
                <td><?= $value[19] ?></td>
                <td class="text-center bg-info-400" style="filter:opacity(80%);"><?= $value[20] ?></td>
                <td><?= $value[21] ?></td>
                <td><?= $value[22] ?></td>
                <td><?= $value[23] ?></td>
                <td class="text-center  bg-primary-400" style="filter:opacity(80%);"><?= $value[24] ?></td>
                <td><?= $value[25] ?></td>
                <td><?= $value[26] ?></td>
                <td><?= $value[27] ?></td>
                <td class="text-center  bg-success-400" style="filter:opacity(80%);"><?= $value[28] ?></td>
                <td><?= $value[29] ?></td>
                <td><?= $value[30] ?></td>
                <td><?= $value[31] ?></td>
                <td class="text-center  bg-primary-400" style="filter:opacity(80%);"><?= $value[32] ?></td>
                <td><?= $value[33] ?></td>
                <td><?= $value[34] ?></td>
                <td><?= $value[35] ?></td>
                <td><?= $value[36] ?></td>
                <td><?= $value[37] ?></td>

            </tr>   
    <?php }
}
?>
</tbody>
</table>    