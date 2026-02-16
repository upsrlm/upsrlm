

<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;

$options = ['placeholder' => 'Select District', 'style' => 'width:250px'];
if (!$model->batch_model->IsNewRecord) {
    $options = ['placeholder' => 'Select District', 'disabled' => 'disabled', 'style' => 'width:250px'];
}
?>
<div class="form">            
    <?php
    $form = ActiveForm::begin([
                'enableClientValidation' => true,
    ]);
    ?>


    <div class="col-md-4">
        <?= $form->field($model, 'batch_name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
        <?=
        $form->field($model, 'district_code')->widget(Select2::classname(), [
            'data' => $model->district_option,
            'options' => $options,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>                     
    </div>

    <div class="col-md-4">
        <div style="margin-top: 15px">
            <?= Html::submitButton('<i class="fa fa-save"></i> Add Participant', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>





