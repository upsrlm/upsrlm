<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\modules\shg\models\Shg */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shg-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php // $form->field($model, 'gram_panchayat_code')->textInput() ?>

    <?php
    echo $form->field($model, 'gram_panchayat_code')->widget(kartik\select2\Select2::classname(), [
        'data' => $model->gp_option,
        'size' => Select2::MEDIUM,
        'options' => ['placeholder' => 'Select GP', 'multiple' => FALSE],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?php //$form->field($model, 'village_code')->textInput()  ?>

    <?php
    echo $form->field($model, 'village_code')->widget(DepDrop::classname(), [
        'data' => $model->village_option,
        'options' => ['placeholder' => 'Select Village', 'multiple' => FALSE],
        'pluginOptions' => [
            'placeholder' => 'SelectVillage',
            'depends' => ['shgform-gram_panchayat_code'],
            'url' => Url::to(['/ajax/getvillage']),
        ],
    ]);
    ?> 

    <?= $form->field($model, 'hamlet')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_of_shg')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_of_members')->textInput() ?>

    <?= $form->field($model, 'chaire_person_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'chaire_person_mobile_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'secretary_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'secretary_mobile_no')->textInput() ?>

    <?= $form->field($model, 'treasurer_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'treasurer_mobile_no')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
