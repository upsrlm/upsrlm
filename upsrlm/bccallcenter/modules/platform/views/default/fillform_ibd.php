 <?php

    use yii\bootstrap4\Html;
    use yii\bootstrap4\ActiveForm;

    $this->title = 'Active Call';
    ?>
 <?php
    $form = ActiveForm::begin([
        'enableClientValidation' => FALSE,
        'enableAjaxValidation' => TRUE,
        'validationUrl' => $model->action_validate_url,
        'options' => ['class' => 'form-horizontal', 'id' => 'approve-form', 'enctype' => 'multipart/form-data'],
    ]);
    ?>
 <div class="row">
     <div class="col-xl-12">
         <div id="panel-1" class="panel">
             <div class="panel-container show">
                 <div class="panel-content">
                     <?php
                        if ($model->calling_model->rishtashgmemberdetail) {
                            echo $this->render('_memberprofile', ['model' => $model->calling_model->rishtashgmemberdetail]);
                        }
                        ?>

                     <?php if ($model->callHistorydataProvider->models) {
                            echo $this->render('_callhistory', ['dataProvider' => $model->callHistorydataProvider]);
                        } ?>
                     <div class="col-lg-12 callrecivied mb-3">
                         <?php
                            echo $form->field(
                                $model,
                                'agent_call_received',
                                ['wrapperOptions' => ['style' => 'display:inline-block']]
                            )
                                ->inline(true)->hiddenInput()->label(false);
                            ?>
                     </div>

                     <div class="col-lg-12 conection mb-3">
                         <?php
                            echo $form->field(
                                $model,
                                'connection_status',
                                ['wrapperOptions' => ['style' => 'display:inline-block']]
                            )
                                ->inline(true)->hiddenInput();
                            ?>
                     </div>
                     <div class="col-lg-12">
                         <div class="connection_status_1">
                             <?php
                                echo $form->field(
                                    $model,
                                    'call_status',
                                    ['wrapperOptions' => ['style' => 'display:inline-block']]
                                )
                                    ->inline(true)->radioList($model->call_status_option);
                                ?>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <div class="row callend">
     <?php if ($model->calling_model->callscneraio) : ?>
         <div class="col-xl-12">
             <div id="panel-1" class="panel">
                 <div class="panel-container show">
                     <div class="panel-content">
                         <div class="col-lg-12">
                             <?php
                                echo $this->render('scenario/' . $model->scenario_form_file, ['callingmodel' => $model->calling_model, 'scneario' => $model->calling_model->callscneraio]);
                                echo $form->field($model, 'default_call_scenario_id')->hiddenInput()->label(false);
                                echo $form->field($model, 'scenario_form_id')->hiddenInput()->label(false);
                                echo $form->field($model, 'scenario_form_file')->hiddenInput()->label(false);
                                ?>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     <?php endif; ?>

     <div class="col-xl-12">
         <div id="panel-1" class="panel">
             <div class="panel-container show">
                 <div class="panel-content">
                     <div class="col-lg-12 mb-3">
                         <p class="font-weight-bold">Call End Report</p>
                         <?php
                            echo $form->field(
                                $model,
                                'call_quality',
                                ['wrapperOptions' => ['style' => 'display:inline-block']]
                            )
                                ->inline(true)->radioList($model->call_quality_option);
                            ?>

                         <?php
                            echo $form->field(
                                $model,
                                'call_outcome',
                                ['wrapperOptions' => ['style' => 'display:inline-block']]
                            )
                                ->inline(true)->radioList($model->call_outcome_option);
                            ?>
                         <?php
                            // echo $form->field(
                            //     $model,
                            //     'call_again',
                            //     ['wrapperOptions' => ['style' => 'display:inline-block']]
                            // )
                            //     ->inline(true)->radioList($model->call_again_option);
                            ?>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <div class="row">
     <div class="col-xl-12">
         <div id="panel-1" class="panel">
             <div class="panel-container show">
                 <div class="panel-content">
                     <div class="col-lg-12 mb-2">
                         <div class="form-group pt-2">
                             <div style="display:none">
                                 <?= $form->field($model, 'calling_agent_id')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'caller_group_id')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'log_id')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'call_start_time')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'call_end_time')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'rishta_shg_member_id')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'cbo_shg_id')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'cbo_vo_id')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'member_mobile')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'member_role')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'member_name')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'member_user_id')->hiddenInput()->label(false); ?>
                             </div>
                             <?= Html::submitButton('Submit', ['id' => 'buttonsave', 'class' => 'btn btn-info', 'value' => 'save', 'name' => 'save']) ?>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <?php ActiveForm::end(); ?>
 <?php
    $js = <<<JS
    $(document).ready(function() {
        $(".conection").css("display","none");
        $(".connection_status_1").css("display","none");
        $(".callend").css("display","none");
         
        if($('input[type=radio][name="CallingListForm[agent_call_received]"]:checked').val() === '1'){
            $(".conection").css("display","block");
        }

        if($('input[type=radio][name="CallingListForm[connection_status]"]:checked').val() === '1'){
            $(".connection_status_1").css("display","block");
        }

        if($('input[type=radio][name="CallingListForm[call_status]"]:checked').val()=='10' || $('input[type=radio][name="CallingListForm[call_status]"]:checked').val()=='12'){
            $(".callend").css("display","block");
        }  
          
        $('input[type=radio][name="CallingListForm[agent_call_received]"]').change(function() {
            if($(this).val() =='1') {
                $(".conection").css("display","block");
            }else{
                $(".conection").css("display","none");
                $(".connection_status_1").css("display","none");
                $(".callend").css("display","none");
                $('input[name="CallingListForm[connection_status]"]').prop('checked', false);
                $('input[name="CallingListForm[call_status]"]').prop('checked', false);
                $('input[name="CallingListForm[call_quality]"]').prop('checked', false);
                $('input[name="CallingListForm[call_outcome]"]').prop('checked', false);
                $('input[name="CallingListForm[call_again]"]').prop('checked', false);
            }
        });

        $('input[type=radio][name="CallingListForm[connection_status]"]').change(function() {        
            if($(this).val() =='1') {
                $(".connection_status_1").css("display","block");
            }else{
                $('input[name="CallingListForm[call_status]"]').prop('checked', false);
                $('input[name="CallingListForm[call_quality]"]').prop('checked', false);
                $('input[name="CallingListForm[call_outcome]"]').prop('checked', false);
                $('input[name="CallingListForm[call_again]"]').prop('checked', false);
                $('input[type=checkbox]').prop('checked', false);
                $(".connection_status_1").css("display","none");
            }
        });


        $('input[type=radio][name="CallingListForm[call_status]"]').change(function() {
            if($(this).val() =='12' || $(this).val() =='10'){
                $(".callend").css("display","block");
            }else{
                $(".callend").css("display","none");
                $('input[name="CallingListForm[call_quality]"]').prop('checked', false);
                $('input[name="CallingListForm[call_outcome]"]').prop('checked', false);
                $('input[name="CallingListForm[call_again]"]').prop('checked', false);
            }
        });
    
    }); 

    $('#approve-form').on('beforeSubmit', function (e) {
        var form = $(this);
        var submit = form.find(':submit');
        submit.html('<span class="fa fa-spin fa-spinner"></span> Wait...');
        submit.prop('disabled', true);

    });          
JS;
    $this->registerJs($js);
    ?>