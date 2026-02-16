<?php

use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use yii\widgets\DetailView;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-12" class="panel">
            <div class="panel-container show">
                <div class="panel-content">
                 <?php if(isset($call_log_model)){
                     
                 } else {
                     echo "No call available Yet"; 
                 } ?>
                </div>
            </div>

        </div>
    </div>
</div>











