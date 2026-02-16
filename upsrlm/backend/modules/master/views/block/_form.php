<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\master\MasterBlock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-block-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'district_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sub_district_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'block_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'block_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
