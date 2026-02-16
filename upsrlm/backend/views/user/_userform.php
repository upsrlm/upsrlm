<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use common\models\User;
use kartik\date\DatePicker;
use kartik\password\PasswordInput;
?>
<div class='changepasswordform'>

    <?php
    $form = ActiveForm::begin([
                'id' => 'bdo-form',
                'options' => ['class' => 'form-horizontal', 'id' => 'user-form'],
                'fieldConfig' => [
                    'template' => "{label}\n<div>{input}</div>\n<div >{error}</div>",
                    'labelOptions' => ['class' => ' control-label'],
                ],
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
    ]);
    ?>
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-2">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>
        </div>
        <div class="col-xl-4 col-md-6 mb-2">
            <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => true, 'placeholder' => 'Mobile No']) ?>
        </div>
        <div class="col-xl-4 col-md-6 mb-2">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => 'Login']) ?>
        </div>
        <div class="col-xl-4 col-md-6 mb-2">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email Id']) ?>
        </div>
        <div class="col-xl-4 col-md-6 mb-2">
            <?=
            $form->field($model, 'password')->widget(PasswordInput::classname(), [
                'options' => ['placeholder' => 'Password'],
                'pluginOptions' => ['showMeter' => false]
            ]);
            ?>
        </div>
        <div class="col-xl-4 col-md-6 mb-2">
            <?php
            echo $form->field($model, 'role')->widget(kartik\select2\Select2::classname(), [
                'data' => $model->role_option,
                'size' => Select2::MEDIUM,
                'options' => ['placeholder' => 'Select Role', 'multiple' => FALSE],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-xl-4 col-md-6 mb-2">
            <div class="form-group">
                <div class="col-sm-offset-4 ">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-info py-2 px-3']) ?>
                </div>
            </div>
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