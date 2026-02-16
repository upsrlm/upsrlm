<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model bc\models\NotificationTemplateSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notification-template-search">

    <?php
    $form = ActiveForm::begin([
                'options' => [
                    'class' => 'form-inline',
                    'data-pjax' => true,
                    'id' => 'Searchform'
                ],
                'method' => 'get',
    ]);
    ?>
    <div class="row">
<div class="col-xl-2 col-md-4 mb-2">
<?= $form->field($model, 'id') ?>
</div>
<div class="col-xl-2 col-md-4 mb-2">
<?= $form->field($model, 'name') ?>
</div>
<div class="col-xl-3 col-md-4 mb-2">
<?= $form->field($model, 'acknowledge')->radioList([1 => 'yes', 0 => 'No'])->label('Acknowledge'); ?>
</div>
<div class="col-xl-3 col-md-4 mb-2">
<?= $form->field($model, 'visible')->radioList([1 => 'yes', 0 => 'No'])->label('Visible'); ?>
</div>
<div class="col-xl-2 col-md-4 mb-2">
<?= Html::submitButton('Search', ['class' => 'btn btn-primary py-2 px-3']) ?>
</div>
</div>

 

 
  
  


    <div class="form-group">
        
    </div>

    <?php ActiveForm::end(); ?>

</div>
