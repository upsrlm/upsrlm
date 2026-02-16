<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\NoticeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notice-search">

  <?php
    $form = ActiveForm::begin([
                'layout' => 'inline',
                'options' => [
                    'data-pjax' => true,
                    'id' => 'Searchform'
                ],
                'method' => 'get',
    ]);
    ?>
    <div class="row">
<div class="col-xl-2 col-md-4 mb-2">
<?= $form->field($model, 'title') ?>
</div>
<div class="col-xl-2 col-md-4 mb-2">
<?= $form->field($model, 'issued_by') ?>
</div>
<div class="col-xl-2 col-md-4 mb-2">
<?= Html::submitButton('Search', ['class' => 'btn btn-primary','style' => 'padding:7px 20px;']) ?>
</div>

</div>

    <?php ActiveForm::end(); ?>

</div>
