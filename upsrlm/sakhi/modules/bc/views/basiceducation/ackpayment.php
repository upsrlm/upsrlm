<?php

use yii\helpers\Html;
use yii\helpers\Url;
use sakhi\widgets\ActiveMobileForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

$this->title = 'Basic Education/ शिक्षा DBT remit की प्राप्ति';

$this->params['breadcrumbs'][] = $this->title;
?>


<div class="row margin-set">
    <div class="col-xl-12 p-0">
        <div id="panel-1" class="panel">
            <div class="card-title mb-0 p-2 border-bottom">
                <h2 class="mb-0"><?= $this->title ?></h2>   
            </div>
            <div class='panel-body mt-2 label-set'>
                <?php $form = ActiveMobileForm::begin(['id' => 'form-ack_payment', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>
                <div class='card px-2'>
                    <div class="col-lg-12">
                        <?= $form->field($model, 'dbt_remit')->radioList([1 => 'हाँ', 2 => 'नहीं'], ['separator' => '']); ?>
                    </div>
                </div>
                <div class='card px-2'>
                    <div class="col-lg-12">
                        <?= $form->field($model, 'withdrawn_any_amount_after_receiving_dbt')->radioList([1 => 'हाँ', 2 => 'नहीं'], ['separator' => '']); ?>
                    </div>
                </div>
                <div class='card px-2'>
                    <div class="col-lg-12">
                        <?= $form->field($model, 'for_educational_purpose_only')->radioList([1 => 'हाँ', 2 => 'नहीं', 3 => 'पता नहीं'], ['separator' => '']); ?>
                    </div>
                </div>
                <div class='card px-2' >
                    <div class="col-lg-12">
                        <?php
                        echo $form->field($model, 'get_monthyear')->widget(kartik\select2\Select2::classname(), [
                            'data' => $model->get_monthyear_option,
                            'size' => Select2::MEDIUM,
                            'options' => ['placeholder' => 'आपके बैंक खाते में डीबीटी कब remit हुई चयन करें', 'multiple' => FALSE],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <div class='card px-2'>
                    <div class="col-lg-12">
                        <?= $form->field($model, 'shg_member')->radioList([1 => 'हाँ', 2 => 'नहीं'], ['separator' => '']); ?>
                    </div>
                </div>
                <div class="form-group text-center">
                    <?= $form->field($model, 'dbt_beneficiary_basic_education_payment_id')->hiddenInput()->label(false); ?>

                    <?= Html::submitButton('सेव (save)', ['class' => 'btn btn-small btn-info', 'name' => 'save_b', 'id' => 'save_b']) ?>
                </div>
                <?php ActiveMobileForm::end(); ?>
            </div>
        </div>
    </div>
</div>


<style>
.col-lg-12 {
    padding-right: 0.5rem;
    padding-left: 0.5rem;
}

.card .card-body {
    padding: 0px
}

.card-body .card {
    margin: 5px 0px
}

.card-body .card> :last-child,
.card-group> :last-child {
    margin-bottom: 10px;
    margin-top: 5px;
}

.form-group:last-child,
.form-group:only-child {
    margin-bottom: 10px;
}
</style>