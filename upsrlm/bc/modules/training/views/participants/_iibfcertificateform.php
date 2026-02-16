<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;

$this->title = 'Upload IIBF Certificate Photo';
?>
<div class="panel panel-default">  

    <div class='panel-body'>
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
        echo $form->field($model, 'iibf_photo_file_name')->widget(\kartik\widgets\FileInput::classname(), [
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













