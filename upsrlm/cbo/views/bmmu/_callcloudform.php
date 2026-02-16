<?php

use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use yii\widgets\DetailView;
use common\models\master\MasterRole;

$this->title = 'Verify';
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">

            <div class="panel-container show">
                <div class="panel-content">
                    <?php
                    $form = ActiveForm::begin([
                                'enableClientValidation' => FALSE,
                                'enableAjaxValidation' => TRUE,
                                'options' => ['class' => 'form-horizontal', 'id' => 'approve-form', 'enctype' => 'multipart/form-data'],
                    ]);
                    ?>
                    <div class="row">

                        <div class="col-lg-5">

                            <?=
                            DetailView::widget([
                                'model' => $member_model,
                                'attributes' => [
                                    [
                                        'attribute' => 'name',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->name;
                                        },
                                    ],
                                    [
                                        'attribute' => 'username',
                                        'lable' => 'Mobile No',
                                        'value' => function ($model) {
                                            return $model->username;
                                        },
                                    ],
                                ],
                            ])
                            ?> 
                        </div>
                        <div class="col-lg-7">
                            <?=
                            DetailView::widget([
                                'model' => $member_model,
                                'attributes' => [
                                    [
                                        'attribute' => 'District',
                                        'header' => 'District',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            $html = '';
                                            if (in_array($model->role, [MasterRole::ROLE_BMMU])) {
                                                $html .= implode(', ', array_unique(ArrayHelper::getColumn($model->blocks, 'district.district_name')));
                                            }
                                            return $html;
                                        },
                                    ],
                                    [
                                        'attribute' => 'Block',
                                        'header' => 'Block',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            $html = '';
                                            if (in_array($model->role, [MasterRole::ROLE_BMMU])) {

                                                $html .= '' . implode(', ', array_unique(ArrayHelper::getColumn($model->blocks, 'block.block_name')));
                                            }
                                            return $html;
                                        },
                                    ],
                                ],
                            ])
                            ?> 


                        </div>
                    </div>  
                    <?php //echo $this->render('callhistory', ['dataProvider' => $model->dataProvider]); ?>
                    <div class="col-lg-12 conection">
                        <?php
                        echo $form->field($model, 'upsrlm_connection_status',
                                        ['wrapperOptions' => ['style' => 'display:inline-block']])
                                ->inline(true)->radioList($model->connection_status_option);
                        ?> 
                    </div>
                    <div class="col-lg-12">
                        <div class="connection_status_1">
                            <?php
                            echo $form->field($model, 'upsrlm_call_status',
                                            ['wrapperOptions' => ['style' => 'display:inline-block']])
                                    ->inline(true)->radioList($model->call_status_option);
                            ?>
<!--                            <div id="panel-3" class="panel">
                                <div class="call_status_10"> 
                                    <?php
                                    echo $form->field($model, 'wada_info_call',
                                                    ['wrapperOptions' => ['style' => 'display:inline-block']])
                                            ->inline(true)->radioList($model->smart_phone_option);
                                    ?> 

                                </div>
                            </div>    -->
                            <div id="panel-2" class="panel">
                                <div class="panel-hdr">
                                    <h2>
                                        <?= 'Call End Report' ?>
                                    </h2>

                                </div>
                                <?php
                                echo $form->field($model, 'upsrlm_call_quality',
                                                ['wrapperOptions' => ['style' => 'display:inline-block']])
                                        ->inline(true)->radioList($model->call_quality_option);
                                ?>

                                <?php
                                echo $form->field($model, 'upsrlm_call_outcome',
                                                ['wrapperOptions' => ['style' => 'display:inline-block']])
                                        ->inline(true)->radioList($model->call_outcome_option);
                                ?>


                            </div>       

                        </div>
                    </div>
                    <div class="form-group pt-2">
                        <div style="display:none">
                            <?= $form->field($model, 'log_id')->hiddenInput()->label(''); ?>
                            <?= $form->field($model, 'status_url')->hiddenInput([])->label(''); ?>
                        </div>    
                        <div class="col-lg-offset-3 col-lg-11">
                            <?= Html::submitButton('Submit', ['id' => 'buttonsave', 'class' => 'btn btn-info', 'value' => 'save', 'name' => 'save']) ?>

                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

        </div>
    </div>
</div>
<?php
$js = <<<JS
    $(document).ready(function() {
        $(".connection_status_1").css("display","none");
        $(".call_status_10").css("display","none");
        $(".action_status_2").css("display","none");
         
          if($('input[type=radio][name="CloudLog[upsrlm_connection_status]"]:checked').val() === '1'){
            $(".connection_status_1").css("display","block");
          }
          if($('input[type=radio][name="CloudLog[upsrlm_call_status]"]:checked').val()=='10'){
            $(".call_status_10").css("display","block");
          }  
        $('input[type=radio][name="CloudLog[upsrlm_connection_status]"]').change(function() {
        if($(this).val()) {
           var upsrlm_connection_status =$('input[name="CloudLog[upsrlm_connection_status]"]:checked').val();
           var upsrlm_call_status =$('input[name="CloudLog[upsrlm_call_status]"]:checked').val();
          var log_id =$('#cloudlog-log_id').val();
          var url =$('#cloudlog-status_url').val();
    $.ajax({
            type: "POST",
            url: url,
            data: { 'log_id' : log_id , 'upsrlm_connection_status' : upsrlm_connection_status},
            
            dataType: "json",
            success: function (data) {
               
            },
            error: function (errormessage) {
                

            }
        });
        }
           if($(this).val() =='1') {
            $(".connection_status_1").css("display","block");
            }else{
            $('input[name="CloudLog[upsrlm_call_status]"]').prop('checked', false);
            $('input[name="CloudLog[action_status]"]').prop('checked', false);
            $('input[type=checkbox]').prop('checked', false);
            $(".connection_status_1").css("display","none");
             }
    });
    $('input[type=radio][name="CloudLog[upsrlm_call_status]"]').change(function() {
        if($(this).val()) {
         var upsrlm_connection_status =$('input[name="CloudLog[upsrlm_connection_status]"]:checked').val();
         var upsrlm_call_status =$('input[name="CloudLog[upsrlm_call_status]"]:checked').val();
         var log_id =$('#cloudlog-log_id').val();
         var url =$('#cloudlog-status_url').val();
    $.ajax({
            type: "POST",
            url: url,
            data: { 'log_id' : log_id , 'upsrlm_connection_status' : upsrlm_connection_status, 'upsrlm_call_status' : upsrlm_call_status},
            
            dataType: "json",
            success: function (data) {
               
            },
            error: function (errormessage) {
                

            }
        });
        }
           if($(this).val() =='10') {
             $(".call_status_10").css("display","block");
            }else{
             $('input[type=checkbox]').prop('checked', false);
             $(".call_status_10").css("display","none");
             $(".action_status_2").css("display","none");
             $('input[name="CloudLog[action_status]"]').prop('checked', false);
             }
    });
    $('input[type=radio][name="CloudLog[action_status]"]').change(function() {
           if($(this).val() =='2') {
             $(".action_status_2").css("display","block");
            }else{
             $('input[type=checkbox]').prop('checked', false); 
             $(".action_status_2").css("display","none");
             
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











