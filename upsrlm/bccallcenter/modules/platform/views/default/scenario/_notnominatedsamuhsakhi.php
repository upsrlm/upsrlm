<?php

use yii\helpers\html;
use common\models\master\MasterRole;
use common\models\dynamicdb\internalcallcenter\platform\CallingScenarioNotnominatedsamuhsakhi;

$html = '';
if ($callingmodel->user) {
    if ($callingmodel->user != NULL) {
        if (isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
            $html .= Html::a('<i class="fal fa-bar" style="color:red"> </i> Reset Menu', ['/shg/user/resetmenu', 'user_id' => $callingmodel->user->id], [
                'title' => 'Reset Menu',
                'target' => '_blank',
                'data-pjax' => "0",
                'class' => 'btn btn-sm btn-danger btn-block menunotshowing',
                // 'data-confirm' => 'Are you sure you want to Reset Menu?',
                // 'data-method' => 'POST',
            ]) . ' ';
        }

        // if (isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
        //     $html .= Html::a('<i class="fal fa-sms" style="color:red"> </i> Send PIN SMS', ['/shg/cst/sendpin', 'user_id' => $callingmodel->user->id], [
        //         'title' => 'Send PIN SMS',
        //         'target' => '_blank',
        //         'data-pjax' => "0",
        //         'class' => 'btn btn-sm btn-danger btn-block nothavepin',
        //         // 'data-confirm' => 'Are you sure you want to Send PIN SMS?',
        //         // 'data-method' => 'POST',
        //     ]) . ' ';
        // }
    }
} else {
    $html .= 'User Info Not Found';
}
$scenario_form = $scneario->form_id;

?>


<div class="row">
    <div class="col-md-12">
        <p class="font-weight-bold">Calling Scneario : <?= $scneario->call_scenario ?></p>
        <p><?= $scneario->scenario_description ?></p>
        <div class="row">
            <div class="col-md-10">
                <div class="mb-3 form-group">
                    <?= Html::label('Samuh Sakhi Not Nominated in Rishta APP Ask Why? (समूह सखी को रिश्ता ऐप में नामित नहीं किया गया है , पूछें क्यों?)', 'samuh_sakhi_not_nominated', ['class' => 'label samuh_sakhi_not_nominated font-weight-bold']) ?>
                    <?= Html::radioList($scenario_form . '[samuh_sakhi_not_nominated]', [], CallingScenarioNotnominatedsamuhsakhi::notnominatedoption()) ?>
                </div>

                <div class="form-group rishtainstall mb-3">
                    <?php // Html::label('Do you have PIN?', 'have_otp_pin', ['class' => 'label have_otp_pin']) 
                    ?>
                    <?php // Html::radioList($scenario_form . '[have_otp_pin]', [], [1 => 'Yes', 2 => 'No']) 
                    ?>
                </div>

            </div>
            <div class="col-md-2">
                <?= $html ?>
            </div>

            <div class="col-md-12">
                <div class="form-group mb-3">
                    <?= Html::label('Call Purpose Achived? (कॉल उद्देश्य प्राप्त हुआ?)', 'call_purpose_complete', ['class' => 'label call_purpose_complete font-weight-bold']) ?>
                    <?= Html::radioList($scenario_form . '[call_purpose_complete]', [], [
                        1 => 'Yes (हां )',
                        2 => 'No (नहीं)'
                    ]) ?>
                </div>

                <div class="form-group call_purpose_complete_no_option">
                    <?= Html::label('If Call Purpose not Achived Select a sutaible reason (यदि नहीं तो – तो उपयुक्त कारण चुनें -)', 'call_purpose_complete_no_reason', ['class' => 'label call_purpose_complete_no_reason font-weight-bold']) ?>
                    <?= Html::radioList($scenario_form . '[call_purpose_complete_no_reason]', [], [
                        1 => 'Not a Member of SHG Anymore (एसएचजी की सदस्य नहीं है )',
                        99 => 'Other (अन्य)'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>


<?php
$js = <<<JS
    $(document).ready(function() {
        $(".menunotshowing").css("display","none");
        $(".nothavepin").css("display","none");
        $(".call_purpose_complete_no_option").css("display","none");
        

         if($('input[type=radio][name="CallingListForm[call_status]"]:checked').val()=='10'){
            $('input[name="{$scenario_form}[samuh_sakhi_not_nominated]"]').prop('required', true);
            $('input[name="scenario_form[call_purpose_complete]"]').prop('required', true);
        }  


        if($('input[type=radio][name="{$scenario_form}[samuh_sakhi_not_nominated]"]:checked').val() === '2'){
            $(".menunotshowing").css("display","block");
        }

        if($('input[type=radio][name="{$scenario_form}[call_purpose_complete]"]:checked').val() === '2'){
            $(".call_purpose_complete_no_option").css("display","block");
        }

        $('input[type=radio][name="{$scenario_form}[samuh_sakhi_not_nominated]"]').change(function() {
            if($(this).val() =='2'){
                $(".menunotshowing").css("display","block");
            }else{
                $(".menunotshowing").css("display","none");
            }
        });

        $('input[type=radio][name="{$scenario_form}[have_otp_pin]"]').change(function() {
            if($(this).val() =='1'){
                $(".nothavepin").css("display","none");
            }else{
                $(".nothavepin").css("display","block");
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
                    $('input[name="scenario_form[samuh_sakhi_not_nominated]"]').prop('required', true);
                    $('input[name="scenario_form[call_purpose_complete]"]').prop('required', true);
                }else{
                    uncheckedinternalfomrelement();
                }
            }
            
        });

        function uncheckedinternalfomrelement(){
            $('input[name="scenario_form[samuh_sakhi_not_nominated]"]').prop('checked', false);
            $('input[name="scenario_form[call_purpose_complete]"]').prop('checked', false);
            $('input[name="scenario_form[call_purpose_complete_no_reason]"]').prop('checked', false);
            $(".menunotshowing").css("display","none");
            $(".nothavepin").css("display","none");
            $(".call_purpose_complete_no_option").css("display","none");
            
            $('input[name="scenario_form[samuh_sakhi_not_nominated]"]').prop('required', false);
            $('input[name="scenario_form[call_purpose_complete]"]').prop('required', false);
            $('input[name="scenario_form[call_purpose_complete_no_reason]"]').prop('required', false);
        }
    });
JS;
$this->registerJs($js);
?>