

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\GeneralModel;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;

$options = ['placeholder' => 'Select District', 'style' => 'width:250px'];
if (!$model->center_model->IsNewRecord) {
    $options = ['placeholder' => 'Select District', 'disabled' => 'disabled', 'style' => 'width:250px'];
}
?>
<div class="form">            
    <?php
    $form = ActiveForm::begin([
                'enableClientValidation' => true,
                    // 'options' => ['class' => 'form-horizontal'],
//                                'fieldConfig' => [
//                                    'template' => "{label}\n<div class=\"col-sm-6\">{input}</div><div class=\"col-sm-3\">{error}</div>",
//                                    'labelOptions' => ['class' => 'col-sm-3 control-label'],
//                                ],
    ]);
    ?>


    <div class="col-md-6">
<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?=
        $form->field($model, 'district_code')->widget(Select2::classname(), [
            'data' => $model->district_option,
            'options' => $options,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>                     </div>

    <div class="col-xs-12">
<?= $form->field($model, 'venue')->textarea(['maxlength' => true]) ?>
    </div>


    <div class="col-md-12">
        <div class="text-center">
<?= Html::submitButton('<i class="fa fa-save"></i> Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>
</div>





