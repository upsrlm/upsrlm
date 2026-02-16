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
?>

<div class="bc-form">
    <div class="panel-tag">
        <span style="color:#478fca !important">Notice: <b>ये सभी सूचनाएं मेरे स्वयं के द्वारा सत्यापित की हुई है I सूचनाओं के प्रावधान में किसी भी त्रुटि की जवाबदेही सम्बद्ध होगी </b>I</span>
    </div>
    <?php $form = ActiveForm::begin(['id' => 'form-bc', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
    <div class="row">
        <div class="col-lg-4"> 
            <?php
            echo $form->field($model, 'district_code')->widget(kartik\select2\Select2::classname(), [
                'data' => $model->district_option,
                'size' => Select2::MEDIUM,
                'options' => ['placeholder' => 'Select District', 'multiple' => FALSE],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
            <?php
            echo $form->field($model, 'block_code')->widget(DepDrop::classname(), [
                'data' => $model->block_option,
                'options' => ['placeholder' => 'Select Block', 'multiple' => FALSE],
                'pluginOptions' => [
                    'allowClear' => true,
                    'depends' => ['addrsethicertifiedbcform-district_code'],
                    'url' => Url::to(['/ajaxbc/block']),
                ],
            ]);
            ?>
            <?php
            echo $form->field($model, 'gram_panchayat_code')->widget(DepDrop::classname(), [
                'data' => $model->gp_option,
                
                'options' => ['placeholder' => 'Select GP', 'multiple' => FALSE],
                'pluginOptions' => [
                    'allowClear' => true,
                    'depends' => ['addrsethicertifiedbcform-district_code','addrsethicertifiedbcform-block_code'],
                    'url' => Url::to(['/ajaxbc/gp']),
                    
                ],
            ]);
            ?>

            <?php
            echo $form->field($model, 'village_code')->widget(DepDrop::classname(), [
                'data' => $model->village_option,
                'options' => ['placeholder' => 'Select Village', 'multiple' => FALSE],
                'pluginOptions' => [
                    'placeholder' => 'Select Village',
                    'depends' => ['addrsethicertifiedbcform-gram_panchayat_code'],
                    'url' => Url::to(['/ajaxbc/village']),
                ],
            ]);
            ?> 

            <?= $form->field($model, 'hamlet')->textInput(['maxlength' => true]) ?>


        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'sur_name')->textInput() ?>
            <?= $form->field($model, 'age')->textInput(['maxlength' => true]) ?>

        </div>   
        <div class="col-lg-4">
            <?=
            $form->field($model, 'cast')->widget(kartik\select2\Select2::classname(), [
                'data' => $model->cast_option,
                'size' => Select2::MEDIUM,
                'options' => ['placeholder' => 'Select Social Category', 'multiple' => FALSE],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?> 

            <?= $form->field($model, 'mobile_number')->textInput(['maxlength' => true]) ?>

            <?=
            $form->field($model, 'reading_skills')->widget(kartik\select2\Select2::classname(), [
                'data' => [1 => 'Class 10 pass'],
                'size' => Select2::MEDIUM,
                'options' => ['placeholder' => 'Select Education', 'multiple' => FALSE],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?> 
            <?= $form->field($model, 'certificate_code')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'guardian_name')->textInput(['maxlength' => true]) ?>
        </div>  
    </div> 

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
