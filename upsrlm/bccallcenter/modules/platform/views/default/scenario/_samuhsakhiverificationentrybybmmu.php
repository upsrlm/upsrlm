<?php

use common\models\dynamicdb\cbo_detail\master\CboMasterMemberDesignation;
use yii\helpers\html;

if ($callingmodel->member_role == CboMasterMemberDesignation::SHG_CHAIRPERSON) {
    $else_having_smart_phone_option = [CboMasterMemberDesignation::SHG_SECRETARY => 'Secretary', CboMasterMemberDesignation::SHG_TREASURER => 'Treasurer', 0 => 'No one Have'];
}
if ($callingmodel->member_role == CboMasterMemberDesignation::SHG_SECRETARY) {
    $else_having_smart_phone_option = [CboMasterMemberDesignation::SHG_CHAIRPERSON => 'Chairperson', CboMasterMemberDesignation::SHG_TREASURER => 'Treasurer', 0 => 'No one Have'];
}
if ($callingmodel->member_role == CboMasterMemberDesignation::SHG_TREASURER) {
    $else_having_smart_phone_option = [CboMasterMemberDesignation::SHG_CHAIRPERSON => 'Chairperson', CboMasterMemberDesignation::SHG_SECRETARY => 'Secretary', 0 => 'No one Have'];
}
$scenario_form = $scneario->form_id;
?>
<div class="row">
    <div class="col-md-12">
        <p class="font-weight-bold">Calling Scneario : <?= $scneario->call_scenario ?></p>
        <?= $scneario->scenario_description ?>
    </div>
    <div class="col-md-12 form-group">
        <?= Html::label('समूह का नाम, नाम व फ़ोन नम्बर सत्यापित करें', 'shg_name_and_other_verify', ['class' => 'label shg_name_and_other_verify font-weight-bold']) ?>
        <?= Html::radioList($scenario_form . '[shg_name_and_other_verify]', [], [1 => 'Yes', 2 => 'No']) ?>
    </div>

    <div class="col-md-12">
        <div class="form-group mb-3">
            <?= Html::label('Call Purpose Achived? (कॉल उद्देश्य प्राप्त हुआ?)', 'call_purpose_complete', ['class' => 'label call_purpose_complete font-weight-bold']) ?>
            <?=
            Html::radioList($scenario_form . '[call_purpose_complete]', [], [
                1 => 'Yes (हां )',
                2 => 'No (नहीं)'
            ])
            ?>
        </div>

        <div class="form-group call_purpose_complete_no_option">
            <?= Html::label('If Call Purpose not Achived Select a sutaible reason (यदि नहीं तो – तो उपयुक्त कारण चुनें -)', 'call_purpose_complete_no_reason', ['class' => 'label call_purpose_complete_no_reason font-weight-bold']) ?>
            <?=
            Html::radioList($scenario_form . '[call_purpose_complete_no_reason]', [], [
                1 => 'Not a Member of SHG Anymore (एसएचजी की सदस्य नहीं है )',
                99 => 'Other (अन्य)'
            ])
            ?>
        </div>
    </div>
</div>


<?php
$js = <<<JS
    $(document).ready(function() {
        $(".userhavemobile").css("display","none");
        $(".smart_phone").css("display","none");
        $(".call_purpose_complete_no_option").css("display","none");
         
         if($('input[type=radio][name="CallingListForm[call_status]"]:checked').val()=='10'){
            $('input[name="{$scenario_form}[shg_name_and_other_verify]"]').prop('required', true);
            $('input[name="scenario_form[call_purpose_complete]"]').prop('required', true);
        }  

         if($('input[type=radio][name="{$scenario_form}[call_purpose_complete]"]:checked').val() === '2'){
            $(".call_purpose_complete_no_option").css("display","block");
        }

        
        $('input[type=radio][name="{$scenario_form}[shg_name_and_other_verify]"]').change(function() {
            if($(this).val() =='1'){
                $(".smart_phone").css("display","block");
                $('input[name="scenario_form[smart_phone]"]').prop('required', true);
            }else{
                $(".userhavemobile").css("display","none");
                $(".smart_phone").css("display","none");
                $('input[name="{$scenario_form}[smart_phone]"]').prop('checked', false);
                $('input[name="{$scenario_form}[agree_download_rishta_app]"]').prop('checked', false);
                $('input[name="scenario_form[smart_phone]"]').prop('required', false);

            }
        });

        $('input[type=radio][name="{$scenario_form}[smart_phone]"]').change(function() {
            if($(this).val() =='1'){
                $(".userhavemobile").css("display","block");
                $('input[name="scenario_form[agree_download_rishta_app]"]').prop('required', true);

            }else{
                if($(this).val() =='2'){
                   $(".userhavemobile").css("display","block");
                }else{
                    $(".else_having_smart_phone").css("display","none");
                }
               
                $('input[name="{$scenario_form}[agree_download_rishta_app]"]').prop('checked', false);
                $('input[name="scenario_form[agree_download_rishta_app]"]').prop('required', false);

            }
        });

       


        $('input[type=radio][name="{$scenario_form}[call_purpose_complete]"]').change(function() {
            if($(this).val() =='2'){
                $(".call_purpose_complete_no_option").css("display","block");
                $('input[name="scenario_form[call_purpose_complete_no_reason]"]').prop('required', true);
            }else{
                $(".call_purpose_complete_no_option").css("display","none");
                $('input[name="scenario_form[call_purpose_complete_no_reason]"]').prop('checked', false);
                $('input[name="scenario_form[call_purpose_complete_no_reason]"]').prop('required', false);
            }
        });

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
                    $('input[name="{$scenario_form}[shg_name_and_other_verify]"]').prop('required', true);
                    $('input[name="scenario_form[call_purpose_complete]"]').prop('required', true);
                }else{
                    uncheckedinternalfomrelement();
                }
            }
            
        });

        function uncheckedinternalfomrelement(){
            $('input[name="{$scenario_form}[shg_name_and_other_verify]"]').prop('checked', false);
            $('input[name="{$scenario_form}[smart_phone]"]').prop('checked', false);
            $('input[name="{$scenario_form}[agree_download_rishta_app]"]').prop('checked', false);
            $('input[name="scenario_form[call_purpose_complete]"]').prop('checked', false);
            $('input[name="scenario_form[call_purpose_complete_no_reason]"]').prop('checked', false);
            $(".call_purpose_complete_no_option").css("display","none");
            $('input[name="{$scenario_form}[shg_name_and_other_verify]"]').prop('required', false);
            $('input[name="scenario_form[call_purpose_complete]"]').prop('required', false);
            $('input[name="scenario_form[call_purpose_complete_no_reason]"]').prop('required', false);
            $('input[name="scenario_form[agree_download_rishta_app]"]').prop('required', false);
            $('input[name="scenario_form[smart_phone]"]').prop('required', false);
        }
    });
JS;
$this->registerJs($js);
?>