<?php

use \yii\bootstrap4\ActiveForm;

$app = new \sakhi\components\App();

?>
<div class="subheader" style="text-align: center">
    <h3 class="subheader-title">
        Enter Amount
    </h3>
</div>
<br />
<?php $form = ActiveForm::begin(); ?>
<div class="row form">

    <div class="form-group col-md-4">
        <?= $form->field($model, 'amount')->textInput(['type' => 'number', 'placeholder' => 'Amount', 'min' => 1])->label('Enter Amount') ?>
    </div>

    <div class="col-md-12">
        <div class="button_bg">
            <div class="form row text-centerd-flex justify-content-center">
                <div class="form_btn">
                    <?= $form->field($model, 'cbo_shg_id')->hiddenInput()->label(false) ?>
                    <?= \yii\helpers\Html::submitButton('Make a Payment', ['class' => 'btn btn-primary']) ?>

                </div>
            </div>
        </div>
    </div>

</div>


<?php ActiveForm::end(); ?>