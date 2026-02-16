<?php

use yii\helpers\html;
use common\models\dynamicdb\internalcallcenter\platform\CallingScenarioMissedcall;

$scenario_form = $scneario->form_id;
?>
<div class="row">
    <div class="col-md-12">
        <p class="font-weight-bold">Calling Scneario : <?= $scneario->call_scenario ?></p>
        <?= $scneario->scenario_description ?>
    </div>

    <div class="col-md-12 form-group mt-3">
        <?= Html::label('Ask reason for Call?', 'missedcall_reason', ['class' => 'label missedcall_reason form-label font-weight-bold']) ?>
        <?= Html::radioList($scenario_form . '[missedcall_reason]', [], CallingScenarioMissedcall::missedcallreasonoption()) ?>
    </div>

    <div class="col-md-12 form-group have_query">
        <?= Html::label('Type Query If have', 'have_query', ['class' => 'label have_query form-label font-weight-bold']) ?>
        <div class="col-md-7">
            <?= Html::textarea($scenario_form . '[have_query]', '', ['max' => 500, 'row' => 2, 'col' => 6, 'class' => 'form-control']) ?>
        </div>
    </div>
</div>


<?php
$js = <<<JS
    $(document).ready(function() {

         if($('input[type=radio][name="CallingListForm[call_status]"]:checked').val()=='10'){
            $('input[name="scenario_form[missedcall_reason]"]').prop('required', true);
        }

        // Rest Element Values of This Form
        $('form').change(function(e)
        {
            var changedFieldset = $(e.target).parents('fieldset');
            var inputElement =changedFieldset.prevObject[0];
            if(inputElement.name =='CallingListForm[agent_call_received]'){
                var agentCallReceived = $('input[type=radio][name="CallingListForm[agent_call_received]"]:checked').val();
                if(agentCallReceived!='1'){
                    uncheckedinternalfomrelement();
                }
            }

            if(inputElement.name =='CallingListForm[connection_status]'){
                var connectionStatus = $('input[type=radio][name="CallingListForm[connection_status]"]:checked').val();
                if(connectionStatus!='1'){
                    uncheckedinternalfomrelement();
                }
            }

            if(inputElement.name =='CallingListForm[call_status]'){
                var callStatus = $('input[type=radio][name="CallingListForm[call_status]"]:checked').val();
                if(callStatus=='10'){
                    $('input[name="{$scenario_form}[missedcall_reason]"]').prop('required', true);
                }else{
                    uncheckedinternalfomrelement();
                }
            }
            
        });

        function uncheckedinternalfomrelement(){
            $('input[name="{$scenario_form}[missedcall_reason]"]').prop('checked', false);
            $('textarea[name="{$scenario_form}[have_query]"]').val("");
            $('input[name="{$scenario_form}[missedcall_reason]"]').prop('required', false);

        }
    });
JS;
$this->registerJs($js);
?>