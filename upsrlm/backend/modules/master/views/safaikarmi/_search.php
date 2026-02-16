<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\master\SafaiKarmiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="safai-karmi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 's_no') ?>

    <?= $form->field($model, 'district') ?>

    <?= $form->field($model, 'block') ?>

    <?= $form->field($model, 'gram_panchyat') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'age') ?>

    <?php // echo $form->field($model, 'mobile_no') ?>

    <?php // echo $form->field($model, 'alternative_mobile_no') ?>

    <?php // echo $form->field($model, 'district_code') ?>

    <?php // echo $form->field($model, 'block_code') ?>

    <?php // echo $form->field($model, 'gram_panchayat_code') ?>

    <?php // echo $form->field($model, 'role') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'mobile_status') ?>

    <?php // echo $form->field($model, 'ctc_click_count') ?>

    <?php // echo $form->field($model, 'ibd') ?>

    <?php // echo $form->field($model, 'ibd_date') ?>

    <?php // echo $form->field($model, 'ibd_datetime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
