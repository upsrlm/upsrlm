<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use \yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use common\models\base\GenralModel;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model bc\models\NotificationLogSearch */
/* @var $form yii\widgets\ActiveForm */
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
<div class="col-xl-6 col-md-4 mb-2">
<?php
    echo $form->field($model, 'detail_id')->widget(Select2::classname(), [
    'data' => ["3" => "बीसी सखी : ऍप अपडेट", '1' => "बीसी सखी : शार्ट लिस्ट", "2" => "बीसी सखी : स्टैंड बाई", "5" => "बीसी सखी : शार्ट लिस्ट Info", "7" => "बीसी सखी व समूह के बैंक अकाउंट संबंधित सूचना देने के विषय में", "8" => "BC सखी के मोबाइल से सम्बंधित अति महत्वपूर्ण सूचना", "9" => "बीसी सखी ऐप को अपडेट रखना", "10" => "बैंक अकाउंट की जानकारी", "11" => "बीसी सखी : पैन कार्ड अपलोड करना Message 1", "12" => "बीसी सखी : पैन कार्ड अपलोड करना Message 2"],
    'options' => ['placeholder' => '', 'style' => 'width:250px'],
    'pluginOptions' => [
    'allowClear' => true
    ],
    ])->label('Notitifcation Template');
    echo "&nbsp;&nbsp;&nbsp;";
    echo $form->field($model, 'acknowledge_status')->widget(Select2::classname(), [
        'data' => [1 => 'Yes', 0 => 'No'],
        'options' => ['placeholder' => '', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Acknowledgement Status');
    ?> 
</div>
<div class="col-xl-5 col-md-4 mb-2">
<?= Html::submitButton('Search', ['class' => 'btn btn-primary py-2 px-3 me-2']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary py-2 px-3']) ?>
</div>
<div class="col-xl-2 col-md-4 mb-2">

</div>
<div class="col-xl-2 col-md-4 mb-2">

</div>
<div class="col-xl-2 col-md-4 mb-2">

</div>
</div>

    <?php
//echo $form->field($model, 'visible')->widget(Select2::classname(), [
//    'data' => [1 => 'yes', 0 => 'No'],
//    'options' => ['placeholder' => '', 'style' => 'width:250px'],
//    'pluginOptions' => [
//        'allowClear' => true
//    ],
//])->label('Visible');
    ?>
    <?php
//echo $form->field($model, 'acknowledge')->widget(Select2::classname(), [
//    'data' => [1 => 'yes', 0 => 'No'],
//    'options' => ['placeholder' => '', 'style' => 'width:250px'],
//    'pluginOptions' => [
//        'allowClear' => true
//    ],
//])->label('Acknowledge');
    ?>
    
    <?php // echo $form->field($model, 'visible') ?>

    <?php // echo $form->field($model, 'acknowledge') ?>

    <?php // echo $form->field($model, 'message_title') ?>

    <?php // echo $form->field($model, 'message') ?>

    <?php // echo $form->field($model, 'genrated_on') ?>

    <?php // echo $form->field($model, 'send_datetime') ?>

    <?php // echo $form->field($model, 'acknowledge_status') ?>

    <?php // echo $form->field($model, 'acknowledge_date') ?>

    <?php // echo $form->field($model, 'send_count') ?>

    <?php // echo $form->field($model, 'cron_status') ?>


    <?php // echo $form->field($model, 'status') ?>

    <?php ActiveForm::end(); ?>
    <?php
    $js = <<<JS
$('#reloads').click(function() {
    location.reload();
});        
JS;
    $this->registerJs($js);
    $js = <<<JS
    $(".reset").click(function() {
   $("select").each(function() { this.selectedIndex = 0 });
        $(this).closest('form').submit();
});
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
</div>
