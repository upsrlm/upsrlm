<?php ?>
<table id='report' class="table  table-bordered tbl_sort">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">District</th>
            <th class="text-center">Partner agency</th>
            <th class="text-center bg-primary-600">Certified BC</th>
            <th colspan="11" class="text-center bg-danger-400">PVR</th>
            <th colspan="11" class="text-center bg-warning-800">BC-SHG assigned</th>
            <th colspan="11" class="text-center bg-warning-500">BC-SHG bank a/c verified</th>
            <th colspan="11" class="text-center bg-info-600">PFMS mapping</th>
            <th colspan="11" class="text-center bg-info-400">BC-support fund (SHG)</th>
            <th colspan="11" class="text-center  bg-primary-400">BC-support fund (BC ack.)</th>
            <th colspan="11" class="text-center bg-success-400">Handheld machine provided</th>
            <th colspan="11" class="text-center  bg-primary-400">Handheld machine acknowledged</th>
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
                    <th><?= $value[8] ?></th>
                    <th><?= $value[9] ?></th>
                    <th><?= $value[10] ?></th>
                    <th><?= $value[11] ?></th>
                    <th><?= $value[12] ?></th>
                    <th><?= $value[13] ?></th>
                    <th><?= $value[14] ?></th>
                    <th class="text-center bg-warning-800" style="filter:opacity(80%);"><?= $value[15] ?></th>


                    <th><?= $value[16] ?></th>
                    <th><?= $value[17] ?></th>
                    <th><?= $value[18] ?></th>
                    <th><?= $value[19] ?></th>
                    <th><?= $value[20] ?></th>
                    <th><?= $value[21] ?></th>
                    <th><?= $value[22] ?></th>
                    <th><?= $value[23] ?></th>
                    <th><?= $value[24] ?></th>
                    <th><?= $value[25] ?></th>
                    <th class="text-center bg-warning-500" style="filter:opacity(80%);"><?= $value[26] ?></th>



                    <th><?= $value[27] ?></th>
                    <th><?= $value[28] ?></th>
                    <th><?= $value[29] ?></th>
                    <th><?= $value[30] ?></th>
                    <th><?= $value[31] ?></th>
                    <th><?= $value[32] ?></th>
                    <th><?= $value[33] ?></th>
                    <th><?= $value[34] ?></th>
                    <th><?= $value[35] ?></th>
                    <th><?= $value[36] ?></th>
                    <th class="text-center bg-info-600" style="filter:opacity(80%);"><?= $value[37] ?></th>

                    <th><?= $value[38] ?></th>
                    <th><?= $value[39] ?></th>
                    <th><?= $value[40] ?></th>
                    <th><?= $value[41] ?></th>
                    <th><?= $value[42] ?></th>
                    <th><?= $value[43] ?></th>
                    <th><?= $value[44] ?></th>
                    <th><?= $value[45] ?></th>
                    <th><?= $value[46] ?></th>
                    <th><?= $value[47] ?></th>
                    <th class="text-center bg-info-400" style="filter:opacity(80%);"><?= $value[48] ?></th>

                    <th><?= $value[49] ?></th>
                    <th><?= $value[50] ?></th>
                    <th><?= $value[51] ?></th>
                    <th><?= $value[52] ?></th>
                    <th><?= $value[53] ?></th>
                    <th><?= $value[54] ?></th>
                    <th><?= $value[55] ?></th>
                    <th><?= $value[56] ?></th>
                    <th><?= $value[57] ?></th>
                    <th><?= $value[58] ?></th>
                    <th class="text-center  bg-primary-400" style="filter:opacity(80%);"><?= $value[59] ?></th>


                    <th><?= $value[60] ?></th>
                    <th><?= $value[61] ?></th>
                    <th><?= $value[62] ?></th>
                    <th><?= $value[63] ?></th>
                    <th><?= $value[64] ?></th>
                    <th><?= $value[65] ?></th>
                    <th><?= $value[66] ?></th>
                    <th><?= $value[67] ?></th>
                    <th><?= $value[68] ?></th>
                    <th><?= $value[69] ?></th>
                    <th class="text-center bg-success-400" style="filter:opacity(80%);"><?= $value[70] ?></th>

                    <th><?= $value[71] ?></th>
                    <th><?= $value[72] ?></th>
                    <th><?= $value[73] ?></th>
                    <th><?= $value[74] ?></th>
                    <th><?= $value[75] ?></th>
                    <th><?= $value[76] ?></th>
                    <th><?= $value[77] ?></th>
                    <th><?= $value[78] ?></th>
                    <th><?= $value[79] ?></th>
                    <th><?= $value[80] ?></th>
                    <th class="text-center  bg-primary-400" style="filter:opacity(80%);"><?= $value[81] ?></th>

                    <th><?= $value[82] ?></th>
                    <th><?= $value[83] ?></th>
                    <th><?= $value[84] ?></th>
                    <th><?= $value[85] ?></th>
                    <th><?= $value[86] ?></th>
                    <th><?= $value[87] ?></th>
                    <th><?= $value[88] ?></th>
                    <th><?= $value[89] ?></th>
                    <th><?= $value[90] ?></th>
                    <th><?= $value[91] ?></th>
                    <th><?= $value[92] ?></th>
                    <th><?= $value[93] ?></th>
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
                <td class="text-center bg-primary-600" style="filter:opacity(80%);"><?= $value[3] ?></td>
                <td class="text-center bg-danger-400"  style="filter:opacity(80%);"><?= $value[4] ?></td>
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
                <td class="text-center bg-warning-800" style="filter:opacity(80%);"><?= $value[15] ?></td>


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
                <td class="text-center bg-warning-500" style="filter:opacity(80%);"><?= $value[26] ?></td>



                <td><?= $value[27] ?></td>
                <td><?= $value[28] ?></td>
                <td><?= $value[29] ?></td>
                <td><?= $value[30] ?></td>
                <td><?= $value[31] ?></td>
                <td><?= $value[32] ?></td>
                <td><?= $value[33] ?></td>
                <td><?= $value[34] ?></td>
                <td><?= $value[35] ?></td>
                <td><?= $value[36] ?></td>
                <td class="text-center bg-info-600" style="filter:opacity(80%);"><?= $value[37] ?></td>

                <td><?= $value[38] ?></td>
                <td><?= $value[39] ?></td>
                <td><?= $value[40] ?></td>
                <td><?= $value[41] ?></td>
                <td><?= $value[42] ?></td>
                <td><?= $value[43] ?></td>
                <td><?= $value[44] ?></td>
                <td><?= $value[45] ?></td>
                <td><?= $value[46] ?></td>
                <td><?= $value[47] ?></td>
                <td class="text-center bg-info-400" style="filter:opacity(80%);"><?= $value[48] ?></td>

                <td><?= $value[49] ?></td>
                <td><?= $value[50] ?></td>
                <td><?= $value[51] ?></td>
                <td><?= $value[52] ?></td>
                <td><?= $value[53] ?></td>
                <td><?= $value[54] ?></td>
                <td><?= $value[55] ?></td>
                <td><?= $value[56] ?></td>
                <td><?= $value[57] ?></td>
                <td><?= $value[58] ?></td>
                <td class="text-center  bg-primary-400" style="filter:opacity(80%);"><?= $value[59] ?></td>


                <td><?= $value[60] ?></td>
                <td><?= $value[61] ?></td>
                <td><?= $value[62] ?></td>
                <td><?= $value[63] ?></td>
                <td><?= $value[64] ?></td>
                <td><?= $value[65] ?></td>
                <td><?= $value[66] ?></td>
                <td><?= $value[67] ?></td>
                <td><?= $value[68] ?></td>
                <td><?= $value[69] ?></td>
                <td class="text-center bg-success-400" style="filter:opacity(80%);"><?= $value[70] ?></td>

                <td><?= $value[71] ?></td>
                <td><?= $value[72] ?></td>
                <td><?= $value[73] ?></td>
                <td><?= $value[74] ?></td>
                <td><?= $value[75] ?></td>
                <td><?= $value[76] ?></td>
                <td><?= $value[77] ?></td>
                <td><?= $value[78] ?></td>
                <td><?= $value[79] ?></td>
                <td><?= $value[80] ?></td>
                <td class="text-center  bg-primary-400" style="filter:opacity(80%);"><?= $value[81] ?></td>

                <td><?= $value[82] ?></td>
                <td><?= $value[83] ?></td>
                <td><?= $value[84] ?></td>
                <td><?= $value[85] ?></td>
                <td><?= $value[86] ?></td>
                <td><?= $value[87] ?></td>
                <td><?= $value[88] ?></td>
                <td><?= $value[89] ?></td>
                <td><?= $value[90] ?></td>
                <td><?= $value[91] ?></td>
                <td><?= $value[92] ?></td>
                <td><?= $value[93] ?></td>
            </tr>   
            <?php
        }
    }
    ?>
</tbody>
</table>    