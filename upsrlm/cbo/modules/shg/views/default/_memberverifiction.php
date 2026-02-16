<?php

use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use yii\widgets\DetailView;

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
                                'id' => 'approve-form',
                    ]);
                    ?>
                    <div class="row">

                        <div class="col-lg-5">

                            <?=
                            DetailView::widget([
                                'model' => $model->shg_model,
                                'attributes' => [
                                    'name_of_shg',
                                    'shg_code',
                                    'district_name',
                                    'block_name',
                                    'gram_panchayat_name',
                                    'village_name',
                                ],
                            ])
                            ?> 
                        </div>
                        <div class="col-lg-7">

                            <?php
                            if ($model->designation == \cbo\models\CboMasterMemberDesignation::SHG_CHAIRPERSON) {
                                echo DetailView::widget([
                                    'model' => $model->shg_model,
                                    'attributes' => [
                                        'chaire_person_name',
                                        'chaire_person_mobile_no',
                                    ],
                                ]);
                            }
                            if ($model->designation == \cbo\models\CboMasterMemberDesignation::SHG_SECRETARY) {
                                echo DetailView::widget([
                                    'model' => $model->shg_model,
                                    'attributes' => [
                                        'secretary_name',
                                        'secretary_mobile_no',
                                    ],
                                ]);
                            }
                            if ($model->designation == \cbo\models\CboMasterMemberDesignation::SHG_TREASURER) {
                                echo DetailView::widget([
                                    'model' => $model->shg_model,
                                    'attributes' => [
                                        'treasurer_name',
                                        'treasurer_mobile_no',
                                    ],
                                ]);
                            }
                            ?>  
                        </div>
                    </div>  

                    <div class="col-lg-12">


                        <?php echo $form->field($model, 'talk_with_shg_member')->radioList($model->talk_with_shg_member_option); ?> 
                        <div class="yes">
                            <?php echo $form->field($model, 'talk_with_shg_member_yes')->radioList($model->talk_with_shg_member_yes_option); ?> 
                            <?php echo $form->field($model, 'talk_with_call_center')->radioList($model->talk_with_call_center_option); ?> 
                            <?php echo $form->field($model, 'how_many_time_for_suggest_samuh_sakhi')->radioList($model->how_many_time_for_suggest_samuh_sakhi_option); ?> 
                        </div>
                    </div>

                    <div class="form-group">
                        <div style="display: none">
                            <?= $form->field($model, 'cbo_shg_id')->hiddenInput()->label(''); ?>
                            <?= $form->field($model, 'designation')->hiddenInput()->label(''); ?>
                            <?= $form->field($model, 'mobile_no')->hiddenInput()->label(''); ?>
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
        $(".yes").css("display","none");
          if($('input[type=radio][name="ShgCallForm[talk_with_shg_member]"]:checked').val() === '1'){
            $(".yes").css("display","block");
          }
        
        $('input[type=radio][name="ShgCallForm[talk_with_shg_member]"]').change(function() {
           if($(this).val() =='1') {
            $(".yes").css("display","block");
            }else{
            $('input[name="ShgCallForm[talk_with_shg_member_yes]"]').prop('checked', false);
            $('input[name="ShgCallForm[talk_with_call_center]"]').prop('checked', false);
            $('input[name="ShgCallForm[how_many_time_for_suggest_samuh_sakhi]"]').prop('checked', false);
            $(".yes").css("display","none");
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









