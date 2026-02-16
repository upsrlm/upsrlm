<?php

use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use \yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use common\models\base\GenralModel;
use common\models\User;
use kartik\widgets\DateTimePicker;
use kartik\widgets\DatePicker;

?>

<div class="notification-log-search">

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
<?=
    $form->field($model, 'mobile_no', [
        'template' => '{label}<div class="col-xs-12">{input}</div>',
    ])->textInput(['placeholder' => 'Mobile No.'])->label('Mobile No.')
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
<?= Html::submitButton('Search', ['class' => 'btn btn-primary','style' => 'padding:7px 20px;']) ?>
</div>
<div class="col-xl-2 col-md-4 mb-2">

</div>
</div>
   
    <?php ActiveForm::end(); ?>
    <?php
    $css = <<<cs
 .select2-selection__rendered {
    width: 200px !important;
}
cs;
    $this->registerCss($css);
    ?>
</div>
