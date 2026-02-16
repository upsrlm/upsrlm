<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;

$this->title = 'Upload PVR';
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                <div class="panel-toolbar">

                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <?php
                    $form = ActiveForm::begin([
                                'enableClientValidation' => TRUE,
                                'enableAjaxValidation' => false,
                                'options' => ['class' => 'form-horizontal', 'id' => 'upload-form', 'enctype' => 'multipart/form-data'],
                                'fieldConfig' => [
                                    'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-lg-3\">{error}</div>",
                                    'labelOptions' => ['class' => 'col-md-3 control-label'],
                                ],
                    ]);
                    ?>
                    <?php
                    echo $form->field($model, 'pvr_upload_file_name')->widget(\kartik\widgets\FileInput::classname(), [
                        'options' => ['multiple' => false, 'accept' => 'image/*'],
                        'pluginOptions' => [
                            'showPreview' => false,
                            'showCaption' => true,
                            'showCancel' => FALSE,
                            'showRemove' => true,
                            'showUpload' => false,
                        ]
                    ]);
                    ?>

                    <div class="form-group">
                        <div class="col-lg-offset-5 col-lg-11">
                            <?= Html::submitButton('Upload', ['id' => 'buttonsave', 'class' => 'btn btn-info', 'value' => 'save', 'name' => 'save']) ?>

                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div
    </div>
</div













