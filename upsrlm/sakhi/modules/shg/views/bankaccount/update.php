<?php

use yii\helpers\Html;
use sakhi\widgets\ActiveMobileForm;
use kartik\date\DatePicker;

$this->title = 'SHG बैंक खातों का विवरण';
$app = new \sakhi\components\App();
?>
<div class="subheader mb-2">
    <h1 class="subheader-title">

        <?php
        if ($model->shg_bank_detail_model->id) {
            echo 'बैंक खाते का विवरण अपडेट करें';
            ?>
            <?php if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/bankaccount/remove', ['shgid' => $model->shg_bank_detail_model->cbo_shg_id])) { ?>
                <?=
                \sakhi\widgets\RemoveButton::widget([
                    'options' => [
                        'value' => '/shg/bankaccount/remove?shgid=' . $model->shg_bank_detail_model->cbo_shg_id . '&shg_bank_id=' . $model->shg_bank_detail_model->id,
                    ],
                ]);
                ?>
            <?php } ?>
            <?php
        } else {
            echo 'बैंक खाते का विवरण';
        }
        ?>
    </h1>
</div>

<script>
    function takePicture(outputFunction) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageData(data) {
        document.getElementById('displayImage').setAttribute('src', 'data:image/png;base64,' + data);
        document.getElementById('bankstatement').setAttribute('value', data);
        if (typeof AndroidDevice !== "undefined") {
        }
    }
    var date = <?= isset($model->date_of_opening_the_bank_account) ? strtotime($model->date_of_opening_the_bank_account) . '000' : 0 ?>;
    var mindate = <?= strtotime('2000-01-01') . '000' ?>;
    var maxdate = <?= time() . '000' ?>;
</script>


<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-container show">
                <div class="panel-content">

                    <?php $form = ActiveMobileForm::begin(['id' => 'form-shgbankdetail', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
                    <div class="row">
                        <div class="col-lg-6">
                            <?php echo $form->field($model, "bank_account_no_of_the_shg")->label('बैंक का खाता संख्या')->textInput(['type' => 'number']) ?>
                        </div>

                        <div class="col-lg-6">
                            <?php echo $form->field($model, "bank_id")->dropDownList(\common\models\base\GenralModel::rishta_bank_option(), ['prompt' => 'चयन कीजिए'])->label('बैंक का नाम') ?>
                        </div> 

                        <div class="col-lg-6">
                            <?php echo $form->field($model, "branch")->label('शाखा का नाम')->textInput() ?>
                        </div>

                        <div class="col-lg-6">
                            <?php echo $form->field($model, "branch_code_or_ifsc")->label('शाखा कोड या IFSC कोड')->textInput() ?>
                        </div>

                        <div class="col-lg-6">  
                            <?=
                            $form->field($model, 'date_of_opening_the_bank_account', [
                                'inputTemplate' => '<div class="input-group"><div class="input-group-prepend">
        <span class="input-group-text"><i class="fal fa-calendar-alt text-primary"></i> </span>
    </div>{input}</div>',
                            ])->textInput(['placeholder' => 'बैंक खाता खोलने की तिथि', 'readonly' => 'readonly', 'onclick' => "javascript:return showCalender(date,mindate,maxdate,'rishtashgbankdetailform-date_of_opening_the_bank_account');"])->label('बैंक खाता खोलने की तिथि')
                            ?>  
                            <?php
//                            $form->field($model, 'date_of_opening_the_bank_account')->widget(DatePicker::classname(), [
//                                'options' => ['placeholder' => 'बैंक खाता खोलने की तिथि'],
//                                'pluginOptions' => [
//                                    'autoclose' => true,
//                                    'format' => 'yyyy-mm-dd',
//                                    'endDate' => "0d"
//                                ],
//                                'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
//                                'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
//                            ])->label('बैंक खाता खोलने की तिथि')
                            ?> 
                        </div>
                        <div class="col-lg-6 mt-3">
                            <?php echo $form->field($model, "balance_as_on_date")->label('दिनांक के अनुसार शेष राशि')->textInput(['type' => 'number']) ?>
                        </div>
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-primary btn-sm mt-2" onClick="takePicture('imageData')">
                                <i class="fal fa-camera"></i> बैंक स्टेटमेंट अपलोड करें
                            </button>
                            <input type="hidden" value="" name='bankstatement' id="bankstatement">
                        </div>
                        <div class="col-lg-6 mt-3 mb-3"><img id="displayImage" src="" class="img-responsive" width="200" height="300"/></div>

                        <div class="col-lg-6">
                            <?php if (isset($model->shg_bank_detail_model->passbook_photo)) { ?>
                                <img src="<?= $model->shg_bank_detail_model->passbook_photo_url ?>" alt="<?= $model->shg_bank_detail_model->passbook_photo ?>" class="img-responsive mb-2" width="100%" height="auto" >
                            <?php } ?>
                        </div>
                    </div>



                    <div class="form-group text-center">
                        <?= $form->field($model, 'cbo_shg_id')->hiddenInput()->label(false); ?>
                        <?= $form->field($model, 'shg_bank_id')->hiddenInput()->label(false); ?>
                        <?= Html::submitButton('सेव', ['class' => 'btn btn-lg btn-info btn-sm form-control', 'name' => 'save_b', 'id' => 'save_b']) ?>
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