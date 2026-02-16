<?php

use yii\helpers\Html;
use sakhi\widgets\ActiveMobileForm;
use kartik\form\ActiveField;
use kartik\date\DatePicker;
use yii\widgets\DetailView;

$this->title = 'SHG का विवरण';
?>
<script type="text/javascript">
    var date = <?= isset($model->date_of_formation) ? strtotime($model->date_of_formation) . '000' : 0 ?>;
    var mindate = <?= strtotime('2000-01-01') . '000' ?>;
    var maxdate = <?= time() . '000' ?>;

</script>
<div class="subheader mb-2">
    <h1 class="subheader-title">
        SHG का विवरण
    </h1>
</div>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <?=
                            DetailView::widget([
                                'model' => $shg_model,
                                'attributes' => [
                                    [
                                        'attribute' => 'name_of_shg',
                                        'label' => 'SHG का नाम',
                                        'value' => function ($model) {
                                            return $model->name_of_shg;
                                        },
                                    ],
                                    [
                                        'attribute' => 'division_name',
                                        'label' => 'प्रभाग का नाम',
                                        'value' => function ($model) {
                                            return $model->division_name;
                                        },
                                    ],
                                    [
                                        'attribute' => 'district_name',
                                        'label' => 'जिला',
                                        'value' => function ($model) {
                                            return $model->district_name;
                                        },
                                    ],
                                    [
                                        'attribute' => 'block_name',
                                        'label' => 'ब्लाक',
                                        'value' => function ($model) {
                                            return $model->block_name;
                                        },
                                    ],
                                    [
                                        'attribute' => 'gram_panchayat_name',
                                        'label' => 'ग्राम पंचायत',
                                        'value' => function ($model) {
                                            return $model->gram_panchayat_name;
                                        },
                                    ],
                                    [
                                        'attribute' => 'village_name',
                                        'label' => 'ग्राम',
                                        'value' => function ($model) {
                                            return $model->village_name;
                                        },
                                    ],
                                    [
                                        'attribute' => 'hamlet',
                                        'label' => 'मजरा/ टोला',
                                        'value' => function ($model) {
                                            return $model->hamlet;
                                        },
                                    ],
                                ],
                            ])
                            ?>
                        </div>
                    </div>

                    <?php $form = ActiveMobileForm::begin(['id' => 'form-shgprofileupdate', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
                    <div class="row">

                        <div class="col-lg-6">
                            <?php echo $form->field($model, "name_of_shg")->textInput(['data-inputmask-regex'=>"[A-Za-z0-9]*"])->label('SHG का नाम')->textInput() ?>

                        </div>  
                        <div class="col-lg-6">      
                            <?php echo $form->field($model, "no_of_members")->textInput(['type' => 'number'])->label('सदस्यों की संख्या') ?>
                        </div>

                        <div class="col-lg-6">      
                            <?=
                            $form->field($model, 'date_of_formation', [
                                'inputTemplate' => '<div class="input-group"><div class="input-group-prepend">
        <span class="input-group-text"><i class="fal fa-calendar"></i> </span>
    </div>{input}</div>',
                            ])->textInput(['maxlength' => true, 'readonly' => 'readonly', 'onclick' => "javascript:return showCalender(date,mindate,maxdate,'rishtashgprofileform-date_of_formation');"])->label('गठन की तारीख')
                            ?>  
                        </div>

                    </div>

                    <div class="form-group text-center">
                        <?= $form->field($model, 'cbo_shg_id')->hiddenInput()->label(false); ?>
                        <?= Html::submitButton('सेव', ['class' => 'btn btn-sm form-control btn-info', 'name' => 'save_b', 'id' => 'save_b']) ?>
                    </div>
                    <?php ActiveMobileForm::end(); ?>
                </div>
            </div>    

        </div>
    </div>    
</div>