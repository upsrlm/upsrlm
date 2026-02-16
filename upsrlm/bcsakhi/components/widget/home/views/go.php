<?php ?>
<div class="go table-responsive">
    <table class="table border go-table table-striped">
        <thead class="gotable-head">
            <tr>
                <th>S.No</th>
                <th style="width: 8%;" class="setwitdth">Date of Issue</th>
                <th>Title</th>
                <th>Download</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $no = 1;
            foreach ($model as $key => $go) {
            ?>
                <tr>
                    <td><?= $no ?></td>
                    <td style="font-weight: 800;"><?= $go['time'] ?></td>
                    <td><?= $go['title'] ?></td>
                    <td class="text-center"><a href=""><img src="/images/pdficon.png" alt="" width="40" ></a></td>
                </tr>

            <?php
                $no++;
            }
            ?>
        </tbody>
    </table>
</div>