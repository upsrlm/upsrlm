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

<div class="conversation-detail-search">

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
    <?php
    echo $form->field($model, 'user_id')->label('User')->widget(Select2::classname(), [
            'data' =>$model->user_option,
            'options'  => ['placeholder' => 'Call Center User', 'style'  => 'width:250px'],
            'pluginOptions'  => [
            'allowClear' => true
            ],
    ]);
    ?>
    
    <?php
    echo $form->field($model, 'from_date')->widget(DatePicker::classname(), [
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
    <?php
    echo $form->field($model, 'to_date')->widget(DatePicker::classname(), [
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
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>


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
    width: 200px !important;
}
cs;
$this->registerCss($css);
?>
