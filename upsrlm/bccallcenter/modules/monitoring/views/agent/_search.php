<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\Select2;
?>
<div class="col-xl-12 mb-3">
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
            <?= $form->field($model, 'caller_group_id')->dropDownList($model->callergroups, ['prompt' => 'Caller Group'])->label('Caller Group');            ?>
        </div>
        <div class="col-md-2">
            <?=
            $form->field($model, 'calling_agent_id')->dropDownList($model->callingagents, ['prompt' => 'Calling Agents'])->label('Calling Agents')
            ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'default_call_scenario_id')->dropDownList($model->callscneario, ['prompt' => 'Call Scenario'])->label('Call Scenario');            ?>
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
$('form') . on('change', function() {
        $(this) . closest('form') . submit();
    });  
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