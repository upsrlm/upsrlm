<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use common\models\User;
use kartik\date\DatePicker;
use kartik\password\PasswordInput;
use common\models\master\MasterRole;
?>
<div class='changepasswordform'>

    <?php
    $form = ActiveForm::begin([
                'id' => 'bdo-form',
                'options' => ['class' => 'form-horizontal', 'id' => 'user-form'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div >{error}</div>",
                    'labelOptions' => ['class' => 'col-md-3 control-label'],
                ],
                'enableAjaxValidation' => true,
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
    echo $form->field($model, 'district_code')->widget(kartik\select2\Select2::classname(), [
        'data' => $model->district_option,
        'size' => Select2::MEDIUM,
        'options' => ['placeholder' => 'Select District', 'multiple' => TRUE],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?> 
    <?php
    if (isset(Yii::$app->user->identity) and !in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
        echo $form->field($model, 'master_partner_bank_id')->widget(Select2::classname(), [
            'data' => $model->bank_option,
            'options' => ['placeholder' => 'Select Partner agencies', 'style' => 'width:200px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Partner agencies');
    }else{
       echo $form->field($model, 'master_partner_bank_id')->hiddenInput()->label(''); 
    }
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