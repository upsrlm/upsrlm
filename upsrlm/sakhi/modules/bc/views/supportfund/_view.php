<?php

use Yii;
use common\models\master\MasterRole;
use yii\helpers\Html;
use kartik\widgets\SwitchInput;
use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this);
$arr=[1 => 'हाँ', 2 => 'नहीं'];
?>
<div class="card mb-2 h4 mt-1">
    <div class="panel-content_cstm card-body ">
        <div class="font-weight-bold mb-1">इस दिन/ सप्ताह/ माह कितना वापस चुकाया: <?= $model->retrun_amount ? $model->retrun_amount : '' ?></div>
        <div class="font-weight-bold mb-1">कितना बकाया था : <?= $model->due_amount ? $model->due_amount : '' ?> </div>
        <div class="font-weight-bold mb-1">इस इंस्टॉलमेंट के बाद कितना बकाया रहा : <?= $model->due_after_installment ? $model->due_after_installment : '' ?> </div>
        <div class="font-weight-bold mb-1">क्या समूह ने वापसी प्राप्त की है : <?= $model->shg_has_received_refund ? $arr[$model->shg_has_received_refund] : '' ?> </div>
        <div class="font-weight-bold mb-1">पूरा ऋण वापस करने में कितने दिन सप्ताह/ महीने बचे हैं : <?= $model->time_left_full_loan_repay ? $model->time_left_full_loan_repay : '' ?> </div>
        <div class="font-weight-bold mb-1">दिनांक : <?= $model->date ?> </div>
        
    </div>
</div>
