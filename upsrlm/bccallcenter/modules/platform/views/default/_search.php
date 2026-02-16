<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\Select2;
?>
<div class="col-xl-12">
    <?php
    $form = ActiveForm::begin([
        'options' => [
            'data-pjax' => true,
            'id' => 'Searchform'
        ],
        'method' => 'get',
    ]);
    ?>
    <div class="row">
        <div class="col-md-2">
            <?=
            $form->field($model, 'customer_number')->textInput(['placeholder' => 'Mobile No.'])->label('Mobile No.')
            ?>
        </div>
        <div class="col-md-2">
            <?php
            echo $form->field($model, 'call_reason_id')->widget(Select2::classname(), [
                'data' => $model->callreasons,
                'options' => ['placeholder' => 'Call Reason'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Call Reason');
            ?>
        </div>
        <div class="col-md-2">
            <?php
            echo $form->field($model, 'default_call_scenario_id')->label('Default Call Scenario')->widget(Select2::classname(), [
                'data' => $model->defaulcallscenarios,
                'options' => ['placeholder' => 'Default Call Scenario'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-md-2">
            <?=
            $form->field($model, 'call_schedule_date')->dropDownList($model->scheduledates, ['prompt' => 'Schedule Dates'])->label('Schedule Dates')
            ?>
        </div>
        <div class="col-md-4 mt-4">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::button('Reset', ['class' => 'btn btn-danger', 'id' => 'reloads']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php
$js = <<<JS
$('#reloads').click(function() {
    location.reload();
});        
JS;
$this->registerJs($js);

$css = <<<cs
 .select2-selection__rendered {
    width: 180px !important;
}
cs;
$this->registerCss($css);
?>