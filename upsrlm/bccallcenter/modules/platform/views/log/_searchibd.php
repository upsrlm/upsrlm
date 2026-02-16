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
use common\models\master\MasterRole;
?>

<div class="search-form ">


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
    <div class="row custom-input">
        <div class="col-xl-2 col-lg-3 col-md-4 mb-2">  
            <?=
            $form->field($model, 'customernumber', [
                'template' => '{label}<div class="col-xs-12">{input}</div>',
            ])->textInput(['placeholder' => 'Calling From'])->label('Calling From')
            ?>
        </div> 
        <div class="col-xl-2 col-lg-3 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'callStatus')->label('Api Call Status')->widget(Select2::classname(), [
                'data' => $model->api_call_status_option,
                'options' => ['placeholder' => 'Api Call Status', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">

            <?php
            echo $form->field($model, 'month')->label('Month')->widget(Select2::classname(), [
                'data' => $model->month_option,
                'options' => ['placeholder' => 'Month', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-xl-3 col-md-4 mb-2">

            <?php
            echo $form->field($model, 'date')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Date'],
                'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                'pluginOptions' => [
                    'autoclose' => true,
                    'todayHighlight' => true,
                    'format' => 'yyyy-mm-dd',
                    'startDate' => $model->month,
                    'endDate' => isset($model->to_date_time) ? $model->to_date_time : date('Y-m-d'),
                ]
            ]);
            ?>
        </div>
<!--        <div class="col-xl-2 col-lg-3 col-md-4 mb-2">    
            <?php
//            echo $form->field($model, 'to_date_time')->widget(DatePicker::classname(), [
//                'options' => ['placeholder' => 'To Date'],
//                'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
//                'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
//                'pluginOptions' => [
//                    'autoclose' => true,
//                    'todayHighlight' => true,
//                    'format' => 'yyyy-mm-dd',
//                    'startDate' => "2023-05-19",
//                    'endDate' => date('Y-m-d'),
//                ]
//            ]);
            ?>
        </div> -->
        <div class="col-xl-2 col-lg-3 col-md-4 mb-2">    
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>

        </div>
        <?php ActiveForm::end(); ?>

    </div>
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
    width: 200px !important;
}
cs;
$this->registerCss($css);
?>
