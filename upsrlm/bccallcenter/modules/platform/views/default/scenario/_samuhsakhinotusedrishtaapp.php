<?php

use yii\helpers\html;
use common\models\master\MasterRole;
use common\models\dynamicdb\internalcallcenter\platform\CallingScenarioSamuhsakhinotusedrishtaapp;

$html = '';
if ($callingmodel->user) {
    if ($callingmodel->user->app_id == NULL) {
        if (isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
            $html .= Html::a('<i class="fal fa-sms" style="color:red"> </i> Send App link SMS', ['/shg/cst/sendcstapplink', 'mobile_no' => $callingmodel->user->username, 'user_id' => $callingmodel->user->id, 'cbo_shg_id' => $callingmodel->cbo_shg_id], [
                'title' => 'Send App link SMS',
                'target' => '_blank',
                'data-pjax' => "0",
                'class' => 'btn btn-sm btn-danger btn-block nothaveapplink',
                // 'data-confirm' => 'Are you sure you want to Send App link SMS?',
                // 'data-method' => 'POST',
            ]) . ' ';
        }
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
            <div class="col-md-9">
                <div class="col-md-12 form-group">
                    <?= Html::label('Rishta APP Install in Your Smart Phone ?', 'install_rishta_app', ['class' => 'label install_rishta_app font-weight-bold']) ?>
                    <?= Html::radioList($scenario_form . '[install_rishta_app]', [], [1 => 'Yes', 2 => 'No']) ?>
                </div>
                <div class="col-md-12 form-group rishtainstall">
                    <?= Html::label('Do you have Login ID ?', 'have_username', ['class' => 'label have_username font-weight-bold']) ?>
                    <?= Html::radioList($scenario_form . '[have_username]', [], [1 => 'Yes', 2 => 'No']) ?>
                </div>

                <div class="col-md-12 form-group rishtainstall">
                    <?= Html::label('Do you have PIN?', 'have_otp_pin', ['class' => 'label have_otp_pin font-weight-bold']) ?>
                    <?= Html::radioList($scenario_form . '[have_otp_pin]', [], [1 => 'Yes', 2 => 'No']) ?>
                </div>

                <div class="col-md-12 form-group smart_phone">
                    <?= Html::label('Smart Phone availaibility', 'smart_phone', ['class' => 'label smart_phone font-weight-bold']) ?>
                    <?= Html::radioList($scenario_form . '[smart_phone]', [], CallingScenarioSamuhsakhinotusedrishtaapp::smartphoneavailaibilityoption()) ?>
                </div>

                <div class="col-md-12 form-group have_app_link">
                    <?= Html::label('Do you have Rishta APP link?', 'have_app_link', ['class' => 'label have_app_link font-weight-bold']) ?>
                    <?= Html::radioList($scenario_form . '[have_app_link]', [], [1 => 'Yes', 2 => 'No']) ?>
                </div>

            </div>
            <div class="col-md-3">
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
        $(".rishtainstall").css("display","none");
        $(".nothavepin").css("display","none");
        $(".smart_phone").css("display","none");
        $(".have_app_link").css("display","none");
        $(".nothaveapplink").css("display","none");
        $(".call_purpose_complete_no_option").css("display","none");
        
        if($('input[type=radio][name="CallingListForm[call_status]"]:checked').val()=='10'){
            $('input[name="{$scenario_form}[install_rishta_app]"]').prop('required', true);
            $('input[name="scenario_form[call_purpose_complete]"]').prop('required', true);
        } 


        if($('input[type=radio][name="{$scenario_form}[install_rishta_app]"]:checked').val() === '1'){
            $(".rishtainstall").css("display","block");
        }

        if($('input[type=radio][name="{$scenario_form}[call_purpose_complete]"]:checked').val() === '2'){
            $(".call_purpose_complete_no_option").css("display","block");
        }

        $('input[type=radio][name="{$scenario_form}[install_rishta_app]"]').change(function() {
            if($(this).val() =='1'){
                $(".rishtainstall").css("display","block");
                $(".smart_phone").css("display","none");
                $(".have_app_link").css("display","none");
                $('input[name="{$scenario_form}[smart_phone]"]').prop('checked', false);
                $('input[name="{$scenario_form}[have_app_link]"]').prop('checked', false);

                $('input[name="{$scenario_form}[have_username]"]').prop('required', true);
                $('input[name="{$scenario_form}[have_otp_pin]"]').prop('required', true);
                $('input[name="{$scenario_form}[smart_phone]"]').prop('required', false);
            }else{
                $(".rishtainstall").css("display","none");
                $('input[name="{$scenario_form}[have_username]"]').prop('checked', false);
                $('input[name="{$scenario_form}[have_otp_pin]"]').prop('checked', false);

                $('input[name="{$scenario_form}[have_username]"]').prop('required', false);
                $('input[name="{$scenario_form}[have_otp_pin]"]').prop('required', false);
                $('input[name="{$scenario_form}[smart_phone]"]').prop('required', true);
                $(".smart_phone").css("display","block");
            }
            $(".nothavepin").css("display","none");
            $(".nothaveapplink").css("display","none");

        });

        $('input[type=radio][name="{$scenario_form}[have_otp_pin]"]').change(function() {
            if($(this).val() =='1'){
                $(".nothavepin").css("display","none");
            }else{
                $(".nothavepin").css("display","block");
            }
        });

        $('input[type=radio][name="{$scenario_form}[have_app_link]"]').change(function() {
            if($(this).val() =='1'){
                $(".nothaveapplink").css("display","none");
            }else{
                $(".nothaveapplink").css("display","block");
            }
        });

        $('input[type=radio][name="{$scenario_form}[smart_phone]"]').change(function() {
            if($(this).val() =='1' || $(this).val() =='3'){
                $(".have_app_link").css("display","block");
                $('input[name="{$scenario_form}[have_app_link]"]').prop('required', true);
            }else{
                $(".have_app_link").css("display","none");
                $('input[name="{$scenario_form}[have_app_link]"]').prop('checked', false);
                $('input[name="{$scenario_form}[have_app_link]"]').prop('required', false);
                $(".nothaveapplink").css("display","none");
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
                    $('input[name="{$scenario_form}[install_rishta_app]"]').prop('required', true);
                    $('input[name="scenario_form[call_purpose_complete]"]').prop('required', true);
                }else{
                    uncheckedinternalfomrelement();
                }
            }
            
        });

        function uncheckedinternalfomrelement(){
            $('input[name="scenario_form[install_rishta_app]"]').prop('checked', false);
            $('input[name="scenario_form[have_username]"]').prop('checked', false);
            $('input[name="scenario_form[have_otp_pin]"]').prop('checked', false);
            $('input[name="scenario_form[smart_phone]"]').prop('checked', false);
            $('input[name="scenario_form[have_app_link]"]').prop('checked', false);
            $('input[name="scenario_form[call_purpose_complete]"]').prop('checked', false);
            $('input[name="scenario_form[call_purpose_complete_no_reason]"]').prop('checked', false);
            $(".call_purpose_complete_no_option").css("display","none");

            $('input[name="{$scenario_form}[install_rishta_app]"]').prop('required', false);
            $('input[name="scenario_form[call_purpose_complete]"]').prop('required', false);
            $('input[name="scenario_form[call_purpose_complete_no_reason]"]').prop('required', false);
            $('input[name="{$scenario_form}[have_app_link]"]').prop('required', false);
            $('input[name="{$scenario_form}[have_username]"]').prop('required', false);
            $('input[name="{$scenario_form}[have_otp_pin]"]').prop('required', false);
            $('input[name="{$scenario_form}[smart_phone]"]').prop('required', false);
        }
    });
JS;
$this->registerJs($js);
?>