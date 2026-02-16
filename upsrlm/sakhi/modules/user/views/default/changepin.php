<?php

use yii\bootstrap4\Html;
use sakhi\widgets\ActiveMobileForm;

$this->title = 'पिन बदलें';
?>
<div class="card">

    <div class="col-lg-12">

        <div class='card-body'>
            <?php $form = ActiveMobileForm::begin(['id' => 'rest-pin-form', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  

            <div class='card'>
                <div class="col-lg-12">
                    <?php
                    echo $form->field($model, "new_pin")->widget(yii\widgets\MaskedInput::classname(), [
                        'mask' => '9999'
                    ]);
                    ?>
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?php
                    echo $form->field($model, "re_pin")->widget(yii\widgets\MaskedInput::classname(), [
                        'mask' => '9999'
                    ]);
                    ?>
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?php
                    echo $form->field($model, "current_pin")->widget(yii\widgets\MaskedInput::classname(), [
                        'mask' => '9999'
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group text-center">

                <?= $form->field($model, 'userid')->hiddenInput()->label(false); ?>
                <?= $form->field($model, 'old_pin')->hiddenInput()->label(false); ?>

                <?= Html::submitButton('सेव', ['class' => 'btn btn-sm btn-info form-control mt-2', 'name' => 'save_b', 'id' => 'save_b']) ?>
            </div>
            <?php ActiveMobileForm::end(); ?>
        </div>
    </div> 
</div>        


