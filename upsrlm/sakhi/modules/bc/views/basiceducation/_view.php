<?php

use yii\helpers\Html;
?>
<div class="card mb-2 p-2">
    <div class="card-body">
        <h5 class="font-weight-bold mb-1 h6">नाम : <?= $model->name_of_beneficiary ?></h5>
        <div class="font-weight-bold mb-1 h6">मोबाइल न0 : <?= $model->mobile_no ?> </div>
        <div class="font-weight-bold mb-1 h6">पेमेंट डेट : <?= $model->payment_date ?> </div>
        <small class="text-muted">
            <?php
            if ($model->payment_acknowledge == '0') {
                echo Html::a('<span class="fal fa-check-circle"> शिक्षा भुगतान पावती भरें</span>', ['/bc/basiceducation/ackpayment', 'dbt_beneficiary_basic_education_payment_id' => $model->id], [
                    'data-pjax' => "0",
                    'class' => 'btn btn-sm btn-info float-left mt-2',
                ]) . ' ';
            } else {
                echo "<h5>शिक्षा भुगतान पावती प्राप्त हुआ</h5>";
            }
            ?>


        </small>
    </div>
</div>