<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use dosamigos\tinymce\TinyMce;
use app\models\nfsa\NfsaBaseSurvey;
use yii\widgets\DetailView;

$this->title = 'Verify';
$optiongp = [];
$optionname = [];
$optioncode = [];
$optionmember = [];
$optionchmno = [];
$optionsemno = [];

$optiontmno = [];
if (isset($model->shg_model)) {
//    if ($model->shg_model->verify_shg_code == '1' and $model->shg_model->shg_code) {
//        $optioncode = ['disabled' => true];
//    }
//    if ($model->shg_model->verify_shg_location == '1') {
//        $optiongp = ['disabled' => true];
//    }
//    if ($model->shg_model->verify_shg_name == '1') {
//        $optionname = ['disabled' => true];
//    }
//    if ($model->shg_model->verify_shg_members == '1') {
//        $optionmember = ['disabled' => true];
//    }
//    
//    if ($model->shg_model->verify_chaire_person_mobile_no == '1') {
//
//        $optionchmno = ['disabled' => true];
//    }
//    if ($model->shg_model->verify_secretary_mobile_no == '1') {
//
//        $optionsemno = ['disabled' => true];
//    }
//    if ($model->shg_model->verify_treasurer_mobile_no == '1') {
//
//        $optiontmno = ['disabled' => true];
//    }
}
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>

                <div class="panel-toolbar">

                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <?php
                    $form = ActiveForm::begin([
                                'enableClientValidation' => FALSE,
                                'enableAjaxValidation' => TRUE,
                                'layout' => 'default',
                                'options' => ['class' => 'form-horizontal', 'id' => 'approve-form', 'enctype' => 'multipart/form-data'],
//                    'fieldConfig' => [
//                        'template' => "{label}\n<div class=\"col-lg-6\">{input}{error}</div>",
//                        'labelOptions' => ['class' => 'col-md-6 control-label'],
//                    ],
                    ]);
                    ?>
                    <div class="row">

                        <div class="col-lg-6">

                            <?=
                            DetailView::widget([
                                'model' => $model->shg_model,
                                'attributes' => [
                                    'id',
                                    [
                                        'attribute' => 'name_of_shg',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->name_of_shg . $model->getColumnstatus($model->verify_shg_name);
                                        }
                                    ],
                                    [
                                        'attribute' => 'shg_code',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return isset($model->shg_code) ? $model->shg_code . $model->getColumnstatus($model->verify_shg_code) : '';
                                        }
                                    ],
                                    'district_name',
                                    'block_name',
                                    [
                                        'attribute' => 'gram_panchayat_name',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->gram_panchayat_name . $model->getColumnstatus($model->verify_shg_location);
                                        }
                                    ],
                                    [
                                        'attribute' => 'village_name',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->village_name . $model->getColumnstatus($model->verify_shg_location);
                                        }
                                    ],
                                    [
                                        'attribute' => 'hamlet',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->hamlet . $model->getColumnstatus($model->verify_shg_location);
                                        }
                                    ],
                                ],
                            ])
                            ?> 
                        </div>
                        <div class="col-lg-6">

                            <?php
                            echo DetailView::widget([
                                'model' => $model->shg_model,
                                'attributes' => [
                                    [
                                        'attribute' => 'no_of_members',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->no_of_members . $model->getColumnstatus($model->verify_shg_members);
                                        }
                                    ],
                                    [
                                        'attribute' => 'chaire_person_name',
                                        'label' => 'Chaire Person Name',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            $mmodel = $model->getRmembers()->andWhere(['role' => 1])->one();
                                            return isset($mmodel) ? $mmodel->name : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'chaire_person_mobile_no',
                                        'label' => 'Chaire Person Mobile No',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            $mmodel = $model->getRmembers()->andWhere(['role' => 1])->one();
                                            return isset($mmodel) ? $mmodel->mobile . $model->getColumnstatus($model->verify_chaire_person_mobile_no) : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'secretary_name',
                                        'label' => 'Secretary Name',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            $mmodel = $model->getRmembers()->andWhere(['role' => 2])->one();
                                            return isset($mmodel) ? $mmodel->name : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'secretary_mobile_no',
                                        'label' => 'Secretary Mobile No',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            $mmodel = $model->getRmembers()->andWhere(['role' => 2])->one();
                                            return isset($mmodel) ? $mmodel->mobile . $model->getColumnstatus($model->verify_secretary_mobile_no) : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'treasurer_name',
                                        'label' => 'Treasurer Name',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            $mmodel = $model->getRmembers()->andWhere(['role' => 3])->one();
                                            return isset($mmodel) ? $mmodel->name : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'treasurer_mobile_no',
                                        'label' => 'Treasurer Mobile No',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            $mmodel = $model->getRmembers()->andWhere(['role' => 3])->one();
                                            return isset($mmodel) ? $mmodel->mobile . $model->getColumnstatus($model->verify_treasurer_mobile_no) : '';
                                        }
                                    ],
                                ],
                            ])
                            ?> 
                        </div>
                    </div> 
                    <div class="row">           
                        <div class="col-lg-3">
<?php echo $form->field($model, 'verify_shg_code')->radioList($model->yes_no_skip_option, ['itemOptions' => $optioncode])->label("Verify SHG Code"); ?> 

                        </div>
                        <div class="col-lg-3">
                            <?php echo $form->field($model, 'verify_shg_location')->radioList($model->yes_no_skip_option, ['itemOptions' => $optiongp])->label("Verify location (GP/ Village & hamlet) of the SHG"); ?> 

                        </div>
                        <div class="col-lg-3">
                            <?php echo $form->field($model, 'verify_shg_name')->radioList($model->yes_no_skip_option, ['itemOptions' => $optionname])->label("Verify Name of SHG"); ?> 

                        </div>
                        <div class="col-lg-3">
                            <?php echo $form->field($model, 'verify_shg_members')->radioList($model->yes_no_skip_option, ['itemOptions' => $optionmember])->label("Verify no. of SHG members"); ?> 
                        </div>
                    </div> 
                    <div class="row">           

                        <div class="col-lg-3">
<?php echo $form->field($model, 'verify_chaire_person_mobile_no')->radioList($model->yes_no_option, ['itemOptions' => $optionchmno])->label("Verify mobile no. of Chair person"); ?> 
                        </div>
                        <div class="col-lg-3">
                            <?php echo $form->field($model, 'verify_secretary_mobile_no')->radioList($model->yes_no_option, ['itemOptions' => $optionsemno])->label("Verify mobile no. of Secretary"); ?> 

                        </div>
                        <div class="col-lg-3">

<?php echo $form->field($model, 'verify_treasurer_mobile_no')->radioList($model->yes_no_option, ['itemOptions' => $optiontmno])->label("Verify mobile no. of treasurer"); ?> 
                        </div>
                    </div> 

                    <div class="panel-tag mt-3">
                        <div style="text-decoration: underline;padding-bottom:10px;font-weight: bold">Note:</div>
                        'Skip' का उपयोग तभी करें जब किसी का फ़ोन busy हो, न लग रहा हो या 'switched off' हो I सभी Skip किये गए रजिस्ट्रेशन को पुनः कॉल करना है एवं सत्यापन (Verification)  सुनिश्चित करना अनिवार्य है I Skip किया गए रजिस्ट्रेशन 2-3 दिनों के अंदर अवश्य सत्यापित (Verify) हो जाने चाहिए I
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-5 col-lg-11">
<?= Html::submitButton('Submit', ['id' => 'buttonsave', 'class' => 'btn btn-info', 'value' => 'save', 'name' => 'save']) ?>

                        </div>
                    </div>
                            <?php ActiveForm::end(); ?>
                </div>
            </div>

        </div>
    </div>












