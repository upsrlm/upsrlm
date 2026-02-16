<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use dosamigos\tinymce\TinyMce;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model frontend\models\Notice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notice-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
    <div class="col-lg-6"?>
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>  
        <?= $form->field($model, 'media_by')->textInput(['maxlength' => true]) ?>   
        <?= $form->field($model, 'type')->dropDownList($model->type_option, ['prompt' => 'Type']) ?>
    </div>
    <div class="col-lg-6">
        <?=
        $form->field($model, 'date')->widget(\yii\widgets\MaskedInput::className(), [
            'clientOptions' => ['alias' => 'dd-mm-yyyy']
        ])
        ?>
        <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?> 
        
        <?=
        $form->field($model, 'file')->widget(FileInput::classname(), [
            'options' => ['accept' => 'pdf/*'],
            'pluginOptions' => [
                'showPreview' => false,
                'showCaption' => true,
                'showRemove' => false,
                'showUpload' => false,
                'initialPreview' => [
                ],
                'overwriteInitial' => true,
            ],
        ]);
        ?>
    </div>

    </div>    

    <div class="col-lg-12">
        <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
