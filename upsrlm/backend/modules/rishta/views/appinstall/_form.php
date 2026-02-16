<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AppDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="app-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imei_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'os_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'manufacturer_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'os_version')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'firebase_token')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'app_version')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_of_install')->textInput() ?>

    <?= $form->field($model, 'date_of_uninstall')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
