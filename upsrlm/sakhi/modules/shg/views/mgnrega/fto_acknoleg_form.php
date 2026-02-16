<?php

use yii\helpers\Html;
use sakhi\widgets\ActiveMobileForm;
use kartik\date\DatePicker;

$this->title = 'मनरेगा भुगतान पावती';
$app = new \sakhi\components\App();
?>

<script>
    var wsdate = <?= isset($model->work_start_date) ? strtotime($model->work_start_date) . '000' : 0 ?>;
    var wedate = <?= isset($model->work_end_date) ? strtotime($model->work_end_date) . '000' : 0 ?>;
    var date_of_receipt_of_wages = <?= isset($model->date_of_receipt_of_wages) ? strtotime($model->date_of_receipt_of_wages) . '000' : 0 ?>;
    var mindate = <?= strtotime('2022-01-01') . '000' ?>;
    var maxdate = <?= time() . '000' ?>;
</script>


<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-container show">
                <div class="panel-content">

                    <?php $form = ActiveMobileForm::begin(['id' => 'form-mgnrega-payment-ack', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  

                    <div class='card'>
                        <div class="col-lg-12"> 
                            <?php echo $form->field($model, "name")->textInput(['readonly' => 'readonly']) ?>
                        </div>
                    </div>   
                    <div class='card'>
                        <div class="col-lg-12"> 
                            <?php echo $form->field($model, "shg_name")->textInput(['readonly' => 'readonly']) ?>
                        </div> 
                    </div>    
                    <div class='card'>
                        <div class="col-lg-12"> 
                            <?php echo $form->field($model, "work_day")->textInput(['readonly' => 'readonly']) ?>
                        </div> 
                    </div>
                    <div clas="card">
                        <div class="col-lg-12">  
                            <div class=""><?= Html::activeLabel($model, 'work_day_duration'); ?> </div>
                            <?=
                            $form->field($model, 'work_start_date', [
                                'inputTemplate' => '<div class="input-group"><div class="input-group-prepend">
        <span class="input-group-text"><i class="fal fa-calendar-alt text-primary"></i> </span>
    </div>{input}</div>',
                            ])->textInput(['placeholder' => 'तिथि से', 'onclick' => "javascript:return showCalender(wsdate,mindate,maxdate,'dbtmgnregaftoacknolegeform-work_start_date');"])->label('')
                            ?> 
                            <?=
                            $form->field($model, 'work_end_date', [
                                'inputTemplate' => '<div class="input-group"><div class="input-group-prepend">
        <span class="input-group-text"><i class="fal fa-calendar-alt text-primary"></i> </span>
    </div>{input}</div>',
                            ])->textInput(['placeholder' => 'तिथि तक', 'onclick' => "javascript:return showCalender(wedate,mindate,maxdate,'dbtmgnregaftoacknolegeform-work_end_date');"])->label('')
                            ?>  
                        </div>
                    </div>   
                    <div class='card'>
                        <div class="col-lg-12">    
                            <?= $form->field($model, 'laborer_wages_were_paid')->radioList($model->yesnooption, ['separator' => ' ']); ?>  
                        </div>
                    </div>

                    <div class='card'>
                        <div class="col-lg-12"> 
                            <?php echo $form->field($model, "total_wage_liability")->textInput(['type' => 'number']) ?>
                        </div>
                    </div>   
                    <div class='card'>
                        <div class="col-lg-12"> 
                            <?php echo $form->field($model, "wages_received_by_the_worker")->textInput(['type' => 'number']) ?>
                        </div>

                        <div class='card'>
                            <div class="col-lg-12">  
                                <?=
                                $form->field($model, 'date_of_receipt_of_wages', [
                                    'inputTemplate' => '<div class="input-group"><div class="input-group-prepend">
        <span class="input-group-text"><i class="fal fa-calendar-alt text-primary"></i> </span>
    </div>{input}</div>',
                                ])->textInput(['placeholder' => 'मजदूरी प्राप्त होने की तिथि', 'onclick' => "javascript:return showCalender(date_of_receipt_of_wages,mindate,maxdate,'dbtmgnregaftoacknolegeform-date_of_receipt_of_wages');"])
                                ?>  
                            </div>
                        </div>    

                    </div>
                    <div clas="card">
                        <div class="col-lg-12">  
                            <div class=""><?= Html::activeLabel($model, 'feedback'); ?> </div>
                            <?= $form->field($model, 'feed_did_you_get_your_wages_ontime')->radioList($model->yesnooption, ['separator' => ' ']); ?>  
                            <?= $form->field($model, 'feed_whether_wages_were_cut_in_any_way')->radioList($model->yesnooption, ['separator' => ' ']); ?>  
                            <?= $form->field($model, 'feed_bank_bc_delayed_discouraged_withdrawal_wages')->radioList($model->yesnooption, ['separator' => ' ']); ?>  
                            <?= $form->field($model, 'feed_someone_wrongly_ask_money_commission')->radioList($model->yesnooption, ['separator' => ' ']); ?>  
                            <?= $form->field($model, 'feed_misbehaved_gp_nrega_official_employee')->radioList($model->yesnooption, ['separator' => ' ']); ?>  
                            <?= $form->field($model, 'feed_satisfied_behavior_officers_associated_nrega')->radioList($model->yesnooption, ['separator' => ' ']); ?>  
                        </div>
                    </div>   


                    <div class="form-group text-center">
                        <?= $form->field($model, 'da_member_fto_ack_id')->hiddenInput()->label(false); ?>
                        <?php if ($model->fto_ack_model->status == '0') { ?>
                            <?= Html::submitButton('सेव', ['class' => 'btn btn-lg btn-info btn-sm form-control', 'name' => 'save_b', 'id' => 'save_b']) ?>
                        <?php } ?>
                    </div>
                    <?php ActiveMobileForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
$style = <<< CSS
 img[src=""] {
        display: none;
    }  

CSS;
$this->registerCss($style);
?>