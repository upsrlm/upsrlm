<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
use yii\widgets\DetailView;

?>
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
                        <div class="col-lg-6">
                            <?= DetailView::widget([
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
                        ])?>
                        </div>
                    </div>
                    <?php $form = ActiveForm::begin(['id' => 'form-shgprofilecreate', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
                    <div class="row">

                        <div class="col-lg-6">
                            <?php echo $form->field($model, "name_of_shg")->label('SHG का नाम')->textInput() ?>

                        </div>  
                        <div class="col-lg-6">      
                            <?php echo $form->field($model, "no_of_members")->textInput()->label('सदस्यों की संख्या') ?>
                        </div>

                        <div class="col-lg-6">      
                            <?= $form->field($model, 'date_of_formation')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'गठन की तारीख'],
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'yyyy-mm-dd'
                            ],
                            'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                            'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                        ])->label('गठन की तारीख') ?>  
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <?= Html::submitButton('सेव', ['class' => 'btn btn-small btn-info mt-2', 'name' => 'save_b', 'id' => 'save_b']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>    

        </div>
    </div>    
</div>