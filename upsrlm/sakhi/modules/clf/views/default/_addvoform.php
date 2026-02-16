<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
?>

<div class="clf-form">
    <?php $form = ActiveForm::begin(['id' => 'add-clf-vo', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
    <div class="row">
        <?php
        echo $form->field($model, 'cbo_vo_ids')->widget(Select2::classname(), [
            'data' => $model->vo_option,
            'options' => ['placeholder' => 'सभी संबद्ध विलेज आर्गेनाइजेशन (ग्राम संगठन) को चुने', 'multiple' => TRUE],
            'showToggleAll' => false,
        ])->label('सभी संबद्ध विलेज आर्गेनाइजेशन (ग्राम संगठन) को चुने');
        ?>   

    </div>
    <div class="form-group text-center">
        <?= Html::submitButton('सेव', ['class' => 'btn btn-info btn-lg', 'name' => 'save_b', 'id' => 'save_b']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>