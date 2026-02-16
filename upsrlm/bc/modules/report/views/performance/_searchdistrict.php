<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use kartik\widgets\DateTimePicker;
//use kartik\date\DatePicker;
use kartik\widgets\DatePicker;
use common\models\base\GenralModel;
use common\models\User;
use common\models\master\MasterRole;
?>
<div class="srlm-search">

    <div class="row">
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'master_partner_bank_id')->widget(Select2::classname(), [
                'data' => $model->bank_option,
                'options' => ['placeholder' => 'All Partner Bank', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('District');
            ?>
        </div>

        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'certified_bc_rating')->widget(Select2::classname(), [
                'data' => [0 => 0, 10 => 10],
                'options' => ['placeholder' => 'Certified Rating', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Certified Rating');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'certified_bc_unwilling_rating')->widget(Select2::classname(), [
                'data' => [0 => 0, 5 => 5],
                'options' => ['placeholder' => 'Certified Unwilling Rating', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Certified Rating');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'upsrlm_payment_of_bc_support_fund_rating')->widget(Select2::classname(), [
                'data' => [0 => 0, 10 => 10],
                'options' => ['placeholder' => 'Payment of BC support fund Rating', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Certified Rating');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'upsrlm_payment_of_bc_honorarium_rating')->widget(Select2::classname(), [
                'data' => [0 => 0,10 => 10],
                'options' => ['placeholder' => 'Payment of BC honorarium Rating', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Certified Rating');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'partner_agency_avg_no_of_working_days_rating')->widget(Select2::classname(), [
                'data' => [0 => 0, 10 => 10],
                'options' => ['placeholder' => 'Ave. no. working days/ month Rating', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Certified Rating');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'partner_agency_avg_no_of_txn_rating')->widget(Select2::classname(), [
                'data' => [0 => 0, 5 => 5],
                'options' => ['placeholder' => 'Ave. no. of txn./ month Rating', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Certified Rating');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'partner_agency_avg_com_earning_rating')->widget(Select2::classname(), [
                'data' => [0 => 0, 5 => 5, 10 => 10],
                'options' => ['placeholder' => 'Ave. commission earning/ month  Rating', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Certified Rating');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;margin-left:10px']) ?>
        </div>
    </div>

</div>
<?php
$css = <<<cs
 .select2-selection__rendered {
    width: 200px !important;
}
cs;
$this->registerCss($css);
?>