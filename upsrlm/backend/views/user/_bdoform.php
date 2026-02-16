<?php

use yii\bootstrap4\Html;
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
                    'template' => "{label}\n<div >{input}</div>\n<div >{error}</div>",
                    'labelOptions' => ['class' => ' control-label'],
                ],
                'enableAjaxValidation' => false,
                'enableClientValidation' => false,
    ]);
    ?>
    <div class="row">
        <div class="col-xl-3 col-md-4 mb-3">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>
        </div>
        <div class="col-xl-3 col-md-4 mb-3">
        <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => true, 'placeholder' => 'Mobile No']) ?>
        </div>
        <div class="col-xl-3 col-md-4 mb-3">
        <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => 'Login']) ?>
        </div>
        <div class="col-xl-3 col-md-4 mb-3">

        <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email Id']) ?>
        </div>
        <div class="col-xl-3 col-md-4 mb-3">
        <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
        <div class="col-xl-3 col-md-4 mb-3">
        <?php
    echo $form->field($model, "block_code")->widget(Select2::classname(), [
        'data' => $model->block_option,
        'options' => ['placeholder' => 'Select block', 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

        </div>
        <div class="col-xl-3 col-md-4 mb-3" style="margin-top:27px;">
        <?= Html::submitButton('Save', ['class' => 'btn btn-info','style'=>'padding:7px 20px;']) ?>
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