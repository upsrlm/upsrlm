<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\shg\models\Shg */

$this->title = 'verification of profile ' . $model->user_model->name;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>

            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <?php
                    $form = ActiveForm::begin(
                                    [
                                        'id' => 'verify-profile',
                                        'enableAjaxValidation' => true,
//                                'enableClientValidation' => false,
                                        'action' => '/user/verify?userid=' . $model->user_id,
                                        'validationUrl' => '/user/verifyvalidate?userid=' . $model->user_id,
                                        'options' => ['enctype' => 'multipart/form-data']
                    ]);
                    ?>  

                    <div class="row">

                        <div class="col-lg-12">
                            <?= $form->field($model, 'verification_status1')->radioList($model->option); ?> 
                        </div>
                        <div class="col-lg-12">
                            <?= $form->field($model, 'verification_status2')->radioList($model->option); ?> 
                        </div>
                        <div class="col-lg-12">
                            <?= $form->field($model, 'verification_status3')->radioList($model->option); ?> 
                        </div>
                        <div class="col-lg-12">
                            <?= $form->field($model, 'verification_status4')->radioList($model->option); ?> 
                        </div>
                        <div class="col-lg-12">
                            <?= $form->field($model, 'verification_status5')->radioList($model->option); ?> 
                        </div>

                        <div class="col-lg-12">
                            <?= $form->field($model, 'user_id')->hiddenInput([])->label('') ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>     
        </div>
    </div>  
</div> 