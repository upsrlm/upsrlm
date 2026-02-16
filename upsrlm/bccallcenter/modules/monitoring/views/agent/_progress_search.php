<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\Select2;
use common\models\master\MasterRole;

$caller_group_option = ['prompt' => 'Calling Agent Group'];
if (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
    $caller_group_option = ['prompt' => 'Calling Agent Group', 'disabled' => 'disabled'];
} elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN])) {
    $caller_group_option = ['prompt' => 'Calling Agent Group', 'disabled' => 'disabled'];
} elseif (in_array($user_model->role, [MasterRole::ROLE_ADMIN])) {
    
} else {
    
}
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
        <?php if ((in_array($user_model->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DBT_CALL_CENTER_MANAGER, MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN]))) { ?>

            <div class="col-xl-2 col-md-4">
                <?=
                $form->field($model, 'calling_agent_id')->dropDownList($model->callingagents, ['prompt' => 'Calling Agents'])->label('Calling Agents')
                ?>
            </div>
        <?php } ?>
        <div class="col-xl-2 col-md-4">
            <?=
            $form->field($model, 'calling_date')->dropDownList($model->callingdates, ['prompt' => 'Call Dates'])->label('Call Dates')
            ?>
        </div>

        <div class="col-md-4 innerBtn" >
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
?>