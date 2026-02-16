<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use kartik\widgets\DateTimePicker;
//use kartik\date\DatePicker;
use kartik\widgets\DatePicker;
use common\models\base\GenralModel;
use common\models\User;
use common\models\master\MasterRole;
?>
<div class="row">
   <?php if (!$model->bc_application_id) { ?>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
        echo $form->field($model, 'district_code')->widget(Select2::classname(), [
            'data' => $model->district_option,
            'options' => ['placeholder' => 'Select District', 'style' => 'width:200px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('District');
        ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">        
        <?php
        echo $form->field($model, 'block_code')->widget(Select2::classname(), [
            'data' => $model->block_option,
            'options' => ['placeholder' => 'Select Block', 'style' => 'width:200px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Block');
        ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">       
        <?php
        echo $form->field($model, 'gram_panchayat_code')->widget(Select2::classname(), [
            'data' => $model->gp_option,
            'options' => ['placeholder' => 'Select Gram Panchayat', 'style' => 'width:250px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('GP');
        ?>
    </div>
   <?php } ?>
    <div class="col-xl-2 col-md-4 mb-2">        
        <?php
        echo $form->field($model, 'from_date_time')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Transaction Start Date'],
            'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
            'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
            'pluginOptions' => [
                'autoclose' => true,
                'todayHighlight' => true,
                'format' => 'yyyy-mm-dd',
                'minDate' => '2021-01-01',
            ]
        ]);
        ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
        echo $form->field($model, 'to_date_time')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Transaction End Date'],
            'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
            'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
            'pluginOptions' => [
                'autoclose' => true,
                'todayHighlight' => true,
                'format' => 'yyyy-mm-dd',
                'minDate' => '2021-01-01',
            ]
        ]);
        ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;']) ?>
        <?= Html::button('Reset', ['class' => 'btn  btn-primary reset', 'style' => 'padding:7px 20px;margin-left:10px', 'id' => 'reloads']) ?>
    </div>
</div>
<?php
$js = <<<JS
$('#reloads').click(function() {
    window.location = window.location.pathname;
});        
JS;
$this->registerJs($js);
$css = <<<cs
 .select2-selection__rendered {
    width: 200px !important;
}
cs;
$this->registerCss($css);
?>

