<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
?>
<table class="table table-striped table-bordered table-condensed table-hover kv-grid-table kv-table-wrap">
    <thead class="kv-table-header grid-data">
        <tr>
            <th data-col-seq="1">हैंडहेल्ड मशीन से सम्बंधित कोई समस्या</th>
            <th data-col-seq="2">फ्रॉड ट्रांसक्शन से  सम्बंधित कोई समस्या</th>
            <th data-col-seq="3">बैंक से सम्बंधित कोई समस्या</th>
            <th data-col-seq="4">BC  सखी के कमीशन पेमेंट भुगतान से सम्बंधित कोई समस्या</th>

        </tr>
    </thead> 
    <tbody>
        <tr>
            <td><?=isset($model->hdhtmls) ? $model->hdhtmls : '' ?></td>
            <td><?=isset($model->fthtmls) ? $model->fthtmls : '' ?></td>
            <td><?=isset($model->pwbhtmls) ? $model->pwbhtmls : '' ?></td>
            <td><?=isset($model->pcbhtmls) ? $model->pcbhtmls  : ''?></td> 
        </tr>   
    </tbody> 
</table>