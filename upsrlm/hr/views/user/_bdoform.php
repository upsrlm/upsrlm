<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use common\models\User;
use kartik\date\DatePicker;
use kartik\password\PasswordInput;
use kartik\select2\Select2;
?>
<div class='changepasswordform'>

    <?php
    $form = ActiveForm::begin([
                'id' => 'bdo-form',
                'options' => ['class' => 'form-horizontal', 'id' => 'bdo-form'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div >{error}</div>",
                    'labelOptions' => ['class' => 'col-md-3 control-label'],
                ],
                'enableAjaxValidation' => false,
                'enableClientValidation' => false,
    ]);
    ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>
    <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => true, 'placeholder' => 'Mobile No']) ?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => 'Login']) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email Id']) ?>
    <?=
    $form->field($model, 'password')->widget(PasswordInput::classname(), [
        'pluginOptions' => ['showMeter' => false]
    ]);
    ?>
    <?php
    echo $form->field($model, "block_code")->widget(Select2::classname(), [
        'data' => $model->block_option,
        'options' => ['placeholder' => 'Select block', 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>


    <div class="form-group">
        <div class="col-sm-offset-4 ">
<?= Html::submitButton('Save', ['class' => 'btn btn-info']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>

</div>        
<?php
$css = <<<css
   div.required label.control-label:after {
    content: " *";
    color: red;
}
css;
$this->registerCss($css);
?>