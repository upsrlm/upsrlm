<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $model app\modules\shg\models\Shg */
/* @var $form yii\widgets\ActiveForm */
$optiongp = ['placeholder' => 'Select GP', 'multiple' => FALSE];
$optionvill = ['placeholder' => 'Select GP', 'multiple' => FALSE];
$optionhamlet = ['maxlength' => true];
$optionname = ['maxlength' => true];
$optioncode = ['maxlength' => true];
$optionmember = ['maxlength' => true];
$optionchname = ['maxlength' => true];
$optionchmno = ['maxlength' => true];
$optionsename = ['maxlength' => true];
$optionsemno = ['maxlength' => true];
$optiontrname = ['maxlength' => true];
$optiontmno = ['maxlength' => true];
if (isset($model->shg_model)) {
    if ($model->shg_model->verify_shg_location == '1') {
        $optiongp = ['placeholder' => 'Select GP', 'multiple' => FALSE, 'disabled' => 'disabled'];
        $optionvill = ['placeholder' => 'Select GP', 'multiple' => FALSE, 'disabled' => 'disabled'];
        $optionhamlet = ['maxlength' => true, 'readonly' => 'readonly'];
    }
    if ($model->shg_model->verify_shg_name == '1') {
        $optionname = ['maxlength' => true, 'readonly' => 'readonly'];
    }
    if ($model->shg_model->verify_shg_members == '1') {
        $optionmember = ['maxlength' => true, 'readonly' => 'readonly'];
    }
    if ($model->shg_model->verify_shg_code == '1') {
        $optioncode = ['maxlength' => true, 'readonly' => 'readonly'];
    }
    if ($model->shg_model->verify_chaire_person_mobile_no == '1') {
        $optionchname = ['maxlength' => true, 'readonly' => 'readonly'];
        $optionchmno = ['maxlength' => true, 'readonly' => 'readonly'];
    }
    if ($model->shg_model->verify_secretary_mobile_no == '1') {
        $optionsename = ['maxlength' => true, 'readonly' => 'readonly'];
        $optionsemno = ['maxlength' => true, 'readonly' => 'readonly'];
    }
    if ($model->shg_model->verify_treasurer_mobile_no == '1') {
        $optiontrname = ['maxlength' => true, 'readonly' => 'readonly'];
        $optiontmno = ['maxlength' => true, 'readonly' => 'readonly'];
    }
    $optionchname = ['maxlength' => true, 'readonly' => 'readonly'];
    $optionchmno = ['maxlength' => true, 'readonly' => 'readonly'];
    $optionsename = ['maxlength' => true, 'readonly' => 'readonly'];
    $optionsemno = ['maxlength' => true, 'readonly' => 'readonly'];
    $optiontrname = ['maxlength' => true, 'readonly' => 'readonly'];
    $optiontmno = ['maxlength' => true, 'readonly' => 'readonly'];
}
?>

<div class="shg-form">
    <div class="panel-tag">
        <span style="color:#478fca !important">Notice: <b>ये सभी सूचनाएं मेरे स्वयं के द्वारा सत्यापित की हुई है I सूचनाओं के प्रावधान में किसी भी त्रुटि की जवाबदेही सम्बद्ध होगी </b>I</span>
    </div>
    <?php $form = ActiveForm::begin(['id' => 'form-clf', 'enableAjaxValidation' => false, 'enableClientValidation' => true, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
    <div class="row">
        <div class="col-lg-6">    
            <?php
            echo $form->field($model, 'gram_panchayat_code')->widget(kartik\select2\Select2::classname(), [
                'data' => $model->gp_option,
                'size' => Select2::MEDIUM,
                'options' => $optiongp,
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>

            <?php
            echo $form->field($model, 'village_code')->widget(DepDrop::classname(), [
                'data' => $model->village_option,
                'options' => $optionvill,
                'pluginOptions' => [
                    'placeholder' => 'SelectVillage',
                    'depends' => ['shgform-gram_panchayat_code'],
                    'url' => Url::to(['/ajax/getvillage']),
                ],
            ]);
            ?> 

            <?= $form->field($model, 'hamlet')->textInput($optionhamlet) ?>

            <?= $form->field($model, 'name_of_shg')->textInput($optionname) ?>
            <?= $form->field($model, 'shg_code')->textInput($optioncode) ?>

            <?= $form->field($model, 'no_of_members')->textInput($optionmember) ?>
        </div>
        <div class="col-lg-6">    
            <?= $form->field($model, 'chaire_person_name')->textInput($optionchname) ?>

            <?= $form->field($model, 'chaire_person_mobile_no')->textInput($optionchmno) ?>

            <?= $form->field($model, 'secretary_name')->textInput($optionsename) ?>

            <?= $form->field($model, 'secretary_mobile_no')->textInput($optionsemno) ?>

            <?= $form->field($model, 'treasurer_name')->textInput($optiontrname) ?>

            <?= $form->field($model, 'treasurer_mobile_no')->textInput($optiontmno) ?>
        </div>   
    </div> 

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
