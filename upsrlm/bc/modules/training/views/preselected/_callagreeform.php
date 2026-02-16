<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use yii\widgets\DetailView;

$this->title = 'Agree for training';
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">

            <div class="panel-container show">
                <div class="panel-content">
                    <?php
                    $form = ActiveForm::begin([
                                'enableClientValidation' => FALSE,
                                'enableAjaxValidation' => TRUE,
                                'options' => ['class' => 'form-horizontal', 'id' => 'approve-form', 'enctype' => 'multipart/form-data'],
                                'fieldConfig' => [
                                    'template' => "{label}\n<div class=\"col-lg-6\">{input}{error}</div>",
                                    'labelOptions' => ['class' => 'col-md-6 control-label'],
                                ],
                    ]);
                    ?>
                    <div class="row">

                        <div class="col-lg-6">

                            <?=
                            DetailView::widget([
                                'model' => $model->srlm_bc_application_model,
                                'attributes' => [
                                    'name',
                                    'guardian_name',
                                    'mobile_number',
                                    'age',
                                    [
                                        'attribute' => 'OTP Verified mobile no',
                                        'enableSorting' => false,
                                        'format' => 'html',
                                        'contentOptions' => ['style' => 'width: 60%'],
                                        'value' => function ($model) {
                                            return $model->user != null ? $model->user->mobile_no : '';
                                        },
                                    ],
                                ],
                            ])
                            ?> 
                        </div>
                        <div class="col-lg-6">

                            <?php
                            echo DetailView::widget([
                                'model' => $model->srlm_bc_application_model,
                                'attributes' => [
                                    [
                                        'attribute' => 'reading_skills',
                                        'label' => 'Education',
                                        'format' => 'html',
                                        'value' => $model->srlm_bc_application_model->readingskills != null ? $model->srlm_bc_application_model->readingskills->name_eng : '',
                                    ],
                                    [
                                        'attribute' => 'address',
                                        'enableSorting' => false,
                                        'format' => 'html',
                                        'contentOptions' => ['style' => 'width: 60%'],
                                        'value' => function ($model) {
                                            return $model->fulladdress;
                                        },
                                    ],
                                ],
                            ])
                            ?> 
                        </div>
                    </div>  

                    <div class="col-lg-8">
                        <?php echo $form->field($model, 'agree')->radioList($model->agree_option)->label("Call Status"); ?> 



                    </div>

                    <div class="form-group pt-2">
                        <div class="col-lg-offset-3 col-lg-11">
                            <?= Html::submitButton('Submit', ['id' => 'buttonsave', 'class' => 'btn btn-info', 'value' => 'save', 'name' => 'save']) ?>

                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>

        </div>
    </div>
</div>












