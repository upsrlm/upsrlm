<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CboVoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cbo-vo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'state_code') ?>

    <?= $form->field($model, 'state_name') ?>

    <?= $form->field($model, 'division_code') ?>

    <?= $form->field($model, 'division_name') ?>

    <?php // echo $form->field($model, 'district_code') ?>

    <?php // echo $form->field($model, 'district_name') ?>

    <?php // echo $form->field($model, 'block_code') ?>

    <?php // echo $form->field($model, 'block_name') ?>

    <?php // echo $form->field($model, 'gram_panchayat_code') ?>

    <?php // echo $form->field($model, 'gram_panchayat_name') ?>

    <?php // echo $form->field($model, 'name_of_vo') ?>

    <?php // echo $form->field($model, 'date_of_formation') ?>

    <?php // echo $form->field($model, 'no_of_shg_connected') ?>

    <?php // echo $form->field($model, 'bank_account_no_of_the_vo') ?>

    <?php // echo $form->field($model, 'name_of_bank') ?>

    <?php // echo $form->field($model, 'branch') ?>

    <?php // echo $form->field($model, 'branch_code_or_ifsc') ?>

    <?php // echo $form->field($model, 'date_of_opening_the_bank_account') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
