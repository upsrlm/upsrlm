<?php

use yii\helpers\Html;
use yii\helpers\Url;
use sakhi\widgets\ActiveMobileForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

$this->title = 'ओटीटी और मनोरंजन ';
$app = new \sakhi\components\App();
$option = [];
?>
<div class='card'>
    <div class="col-lg-12">
        <div class="text-center"> 
            <h3>
                <?= $this->title ?>
            </h3>
        </div>
    </div>
    <div class="col-lg-12">

        <div class='card-body'>

            <div class='card'>
                <div class="col-lg-12">   
                    <?php
                    echo Html::activeLabel($model, "sec6_you_currently_able_watch_ott_id", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->sec6youcurrentlyablewatchottf ?>

                </div>
            </div>

            <div class='card'>
                <div class="col-lg-12">    
                    <?php
                    echo Html::activeLabel($model, "sec6_entertainment_low_cost_id", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->sec6entertainmentlowcostf ?>
                </div>
            </div>

            <div class="form-group text-center">

                <a href="<?= '/online/fb/form' ?>" class="btn btn-dark"><i class="fal fa fa-arrow-left" aria-hidden="true"></i><span> वापस</span> </a> 
            </div>     
        </div>
    </div>    
</div>  

<?php
$style1 = <<< CSS
 .card {
    margin-bottom: 5px !important;
}
.bold_lable {
  font-weight: bold !important;  
}
CSS;
$this->registerCss($style1);
?>