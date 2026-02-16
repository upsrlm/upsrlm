<?php

use yii\helpers\Html;
use yii\helpers\Url;
use sakhi\widgets\ActiveMobileForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
$this->title = 'बीसी सखी मानदेय';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clf-form">
    <div class="panel panel-default">

        <div class="col-lg-12">
            <div>
                <h2>बीसी सखी मानदेय <?php
                    if ($model->month == 1) {
                        echo date('F - Y', strtotime($model->bc_payment_model->month1));
                    }
                    if ($model->month == 2) {
                        echo date('F - Y', strtotime($model->bc_payment_model->month2));
                    }
                    if ($model->month == 3) {
                        echo date('F - Y', strtotime($model->bc_payment_model->month3));
                    }
                    if ($model->month == 4) {
                        echo date('F - Y', strtotime($model->bc_payment_model->month4));
                    }
                    if ($model->month == 5) {
                        echo date('F - Y', strtotime($model->bc_payment_model->month5));
                    }
                    if ($model->month == 6) {
                        echo date('F - Y', strtotime($model->bc_payment_model->month6));
                    }
                    ?></h2> 

            </div>
            <div class='panel-body'>
                <?php $form = ActiveMobileForm::begin(['id' => 'form-bc-ack_hon', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  

                <?php
                if ($model->month == 1) {
                    echo $this->render('_month1', [
                        'model' => $model,
                        'form' => $form,
                    ]);
                }
                if ($model->month == 2) {
                    echo $this->render('_month2', [
                        'model' => $model,
                        'form' => $form,
                    ]);
                }
                if ($model->month == 3) {
                    echo $this->render('_month3', [
                        'model' => $model,
                        'form' => $form,
                    ]);
                }
                if ($model->month == 4) {
                    echo $this->render('_month4', [
                        'model' => $model,
                        'form' => $form,
                    ]);
                }
                if ($model->month == 5) {
                    echo $this->render('_month5', [
                        'model' => $model,
                        'form' => $form,
                    ]);
                }
                if ($model->month == 6) {
                    echo $this->render('_month6', [
                        'model' => $model,
                        'form' => $form,
                    ]);
                }
                ?>
                <div class="form-group text-center">
                    <?= $form->field($model, 'bc_application_id')->hiddenInput()->label(false); ?>
                    <?= $form->field($model, 'month')->hiddenInput()->label(false); ?>
                    <?= Html::submitButton('सेव (save)', ['class' => 'btn btn-small btn-info', 'name' => 'save_b', 'id' => 'save_b']) ?>
                </div>
                <?php ActiveMobileForm::end(); ?>
            </div>
        </div>    
    </div>    

</div>
<?php
$style = <<< CSS
 img[src=""] {
        display: none;
    }  

CSS;
$this->registerCss($style);
?>
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