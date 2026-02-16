<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-2">
        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xl-4 col-md-6 mb-2">
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xl-4 col-md-6 mb-2">
        <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xl-4 col-md-6 mb-2">
        
         <?= $form->field($model, 'status')->textInput() ?>
        </div>
        <div class="col-xl-4 col-md-6 mb-2">
        <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success py-2 px-3']) ?>
    </div>
        </div>
    </div>



   

   


    

    <?php ActiveForm::end(); ?>

</div>
