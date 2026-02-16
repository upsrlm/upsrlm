<?php

use yii\helpers\Html;
// use yii\bootstrap4\ActiveForm;
use sakhi\widgets\ActiveMobileForm;
use kartik\date\DatePicker;

$this->title = 'फंड जोड़ें';
?>
<script type="text/javascript">
    var date = <?= isset($model->date_of_receipt) ? strtotime($model->date_of_receipt) . '000' : 0 ?>;
    var mindate = <?= strtotime('2000-01-01') . '000' ?>;
    var maxdate = <?= time() . '000' ?>;

</script>
<div class="subheader mb-2">
    <h1 class="subheader-title">
        फंड जोड़ें
    </h1>
</div>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-container show">
                <div class="panel-content">

                    <?php
                    $form = ActiveMobileForm::begin(['id' => 'form-shgbankdetail',
                                'method' => 'POST',
                                'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]);
                    ?>  
                    <div class="row">

                        <div class="col-lg-6">
                            <h3><?= isset($model->shg_fund_received_model->funddetail->fund_type) ? $model->shg_fund_received_model->funddetail->fund_type : $model->fund_type ?></h3>
                        </div>

                        <div class="col-lg-6 mt-3">
                            <?php echo $form->field($model, "received_from")->dropDownList([1 => 'UPSRLM', 2 => 'VO', 3 => 'CLF'], ['prompt' => 'चयन कीजिए'])->label('से प्राप्त किया') ?>
                        </div>

                        <div class="col-lg-6">     
                            <?=
                            $form->field($model, 'date_of_receipt', [
                                'inputTemplate' => '<div class="input-group"><div class="input-group-prepend">
        <span class="input-group-text"><i class="fal fa-calendar-alt text-primary"></i> </span>
    </div>{input}</div>',
                            ])->textInput(['placeholder' => 'प्राप्ति की तारीख', 'readonly' => 'readonly', 'onclick' => "javascript:return showCalender(date,mindate,maxdate,'rishtashgfundreceivedform-date_of_receipt');"])->label('प्राप्ति की तारीख')
                            ?>   
                            <?php
//                            $form->field($model, 'date_of_receipt')->widget(DatePicker::classname(), [
//                                'options' => ['placeholder' => 'प्राप्ति की तारीख'],
//                                'pluginOptions' => [
//                                    'autoclose' => true,
//                                    'format' => 'yyyy-mm-dd',
//                                    'endDate' => "0d",
//                                ],
//                                'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
//                                'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
//                            ])->label('प्राप्ति की तारीख')
                            ?> 
                        </div>

                        <div class="col-lg-6">
                            <?php echo $form->field($model, "amount_received")->label('रकम प्राप्त')->textInput(['type' => 'number']) ?>
                        </div>

                    </div>

                    <div class="form-group text-center">
                        <?= $form->field($model, 'fund_type')->hiddenInput()->label(false); ?>
                        <?= $form->field($model, 'cbo_shg_id')->hiddenInput()->label(false); ?>
                        <?= $form->field($model, 'shg_fund_received_id')->hiddenInput()->label(false); ?>
                        <?= Html::submitButton('सेव', ['class' => 'btn btn-info btn-sm form-control mt-2 ', 'name' => 'save_b', 'id' => 'save_b']) ?>
                    </div>
                    <?php ActiveMobileForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>