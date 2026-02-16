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
    if ($model->shg_model->verify_shg_code == '1' and $model->shg_model->shg_code) {
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
    if ($model->shg_model->is_bc == '1' or $model->shg_model->bc_user_id) {
        $optiongp = ['placeholder' => 'Select GP', 'multiple' => FALSE, 'disabled' => 'disabled'];
        $optionvill = ['placeholder' => 'Select GP', 'multiple' => FALSE, 'disabled' => 'disabled'];
        $optionhamlet = ['maxlength' => true, 'readonly' => 'readonly'];
        $optionname = ['maxlength' => true, 'readonly' => 'readonly'];
    }
}
?>

<div class="shg-form">
    <div class="col-lg-12"> 
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
                        'depends' => ['shgnewform-gram_panchayat_code'],
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
                <?php
                if (isset($model->shg_member_model)) {
                    foreach ($model->shg_member_model as $i => $member) {
                        $optionname = ['maxlength' => true];
                        $optionmno = ['size' => 10];
                        if ($member->user_id or $member->verified == 1) {
                            $optionname = ['maxlength' => true, 'readonly' => 'readonly'];
                            $optionmno = ['size' => 10, 'readonly' => 'readonly'];
                        }
                        if ($model->shg_model->verify_chaire_person_mobile_no == '1' and $member->role == 1) {
                            $optionname = ['maxlength' => true, 'readonly' => 'readonly'];
                            $optionmno = ['size' => 10, 'readonly' => 'readonly'];
                        }
                        if ($model->shg_model->verify_secretary_mobile_no == '1' and $member->role == 2) {
                            $optionname = ['maxlength' => true, 'readonly' => 'readonly'];
                            $optionmno = ['size' => 10, 'readonly' => 'readonly'];
                        }
                        if ($model->shg_model->verify_treasurer_mobile_no == '1' and $member->role == 3) {
                            $optionname = ['maxlength' => true, 'readonly' => 'readonly'];
                            $optionmno = ['size' => 10, 'readonly' => 'readonly'];
                        }
                        if ($model->shg_model->ch_user_id == '1' and $member->role == 1) {
                            $optionname = ['maxlength' => true, 'readonly' => 'readonly'];
                            $optionmno = ['size' => 10, 'readonly' => 'readonly'];
                        }
                        if ($model->shg_model->se_user_id == '1' and $member->role == 2) {
                            $optionname = ['maxlength' => true, 'readonly' => 'readonly'];
                            $optionmno = ['size' => 10, 'readonly' => 'readonly'];
                        }
                        if ($model->shg_model->te_user_id == '1' and $member->role == 3) {
                            $optionname = ['maxlength' => true, 'readonly' => 'readonly'];
                            $optionmno = ['size' => 10, 'readonly' => 'readonly'];
                        }
                        if ($model->shg_model->verify_mobile_no == '1') {
                            $optionname = ['maxlength' => true, 'readonly' => 'readonly'];
                            $optionmno = ['size' => 10, 'readonly' => 'readonly'];
                        }
                        ?>


                        <?php echo $form->field($member, "[$i]name")->textInput($optionname)->label($member->name_lable) ?>
                        <?php echo $form->field($member, "[$i]mobile")->textInput($optionmno)->label($member->mobile_lable) ?>
                        <div style="display:none">
                            <?php echo $form->field($member, "[$i]old_name")->textInput()->label($member->name_lable) ?>
                            <?php echo $form->field($member, "[$i]old_mobile")->textInput()->label($member->mobile_lable) ?>
                            <?php echo $form->field($member, "[$i]id")->hiddenInput(['value' => $member->id])->label('') ?>  
                            <?php echo $form->field($member, "[$i]role")->hiddenInput(['value' => $member->role])->label('') ?>

                        </div>

                        <?php
                    }
                }
                ?>

            </div>   
        </div> 
        <?php
        if (isset($model->shg_model->id)) {
            $t = true;
            $member = \common\models\dynamicdb\cbo_detail\CboMembers::find()->where(['status' => 1, 'cbo_type' => 1, 'cbo_id' => $model->shg_model->id])->count();
            ?>
            <?php
            if ($member == 0) {
                echo $form->field($model, 'repeated_error')->checkbox();
            }
            ?> 
        <?php } ?>
        <div class="form-group text-center">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
