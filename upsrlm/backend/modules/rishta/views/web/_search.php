<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use kartik\widgets\DateTimePicker;
use kartik\widgets\DatePicker;
use common\models\base\GenralModel;
use common\models\User;
use common\models\master\MasterArea;
?>
<div class="col-xl-12">
    <?php
    $form = ActiveForm::begin([
                'layout' => 'inline',
                'options' => [
                    'class' => 'form-inline',
                    'data-pjax' => true,
                    'id' => 'Searchform'
                ],
                'method' => 'get',
    ]);
    ?>
    <div class="row">
<div class="col-xl-2 col-md-4 mb-2">
<?php
    echo $form->field($model, 'type')->widget(Select2::classname(), [
        'data' => [1 => 'SHG', 2 => 'VO', 3 => 'CLF', 4 => 'BC', 7 => 'PAGE'],
        'options' => ['placeholder' => 'Type', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
</div>
<div class="col-xl-2 col-md-4 mb-2">
<?=
    $form->field($model, 'app_version', [
        'template' => '{label}<div class="col-xs-12">{input}</div>',
    ])->textInput(['placeholder' => 'App Vesion'])
    ?>
</div>
<div class="col-xl-3 col-md-4 mb-2">
<?php

echo $form->field($model, 'from_date_time')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'From Date'],
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
<div class="col-xl-3 col-md-4 mb-2">
<?php

echo $form->field($model, 'to_date_time')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'To Date'],
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
<?= Html::submitButton('Search', ['class' => 'btn btn-sm btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'margin-left:10px;padding:7px 20px;']) ?>
    <?= Html::button('Reset', ['class' => 'btn btn-sm btn-primary reset', 'style' => 'padding:7px 20px;', 'id' => 'reloads']) ?>
</div>
</div>


    <?php ActiveForm::end(); ?>
</div>
<?php
$js = <<<JS
$('#reloads').click(function() {
    location.reload();
});        
JS;
$this->registerJs($js);


$css = <<<cs
 .select2-selection__rendered {
    width: 180px !important;
}
cs;
$this->registerCss($css);
?>


