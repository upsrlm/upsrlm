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

/* @var $this yii\web\View */
/* @var $model common\models\dynamicdb\support\ConversationDetailSearch */
/* @var $form yii\widgets\ActiveForm */
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
    echo $form->field($model, 'call_type')->label('Call Type')->widget(Select2::classname(), [
        'data' => ['I' => 'Incoming', 'O' => 'Outgoing', 'C' => 'Cancel'],
        'options' => ['placeholder' => 'Call Type', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>


    <?= $form->field($model, 'calling_no') ?>
    <?php
    echo $form->field($model, 'cc_executive_code')->label('Executive')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(common\models\dynamicdb\support\master\MasterCcAgent::find()->all(), 'cc_executive_code', 'cc_executive_name'),
        'options' => ['placeholder' => 'Executive', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    <?php
    echo $form->field($model, 'call_response')->label('Call Type')->widget(Select2::classname(), [
        'data' => [
            'Call Dropped' => 'Call Dropped',
            'Call me later' => 'Call me later',
            'Conversation Completed' => 'Conversation Completed',
            'Enquary' => 'Enquary',
            'No voice' => 'No voice',
            'Non Responsive' => 'Non Responsive',
            'Not Related' => 'Not Related',
            'Spouse is out of Station and not available on same day' => 'Spouse is out of Station and not available on same day',
            'Switch off' => 'Switch off',
            'Task Completed as seen on support portal' => 'Task Completed as seen on support portal',
            'Wrong No' => 'Wrong No'
        ],
        'options' => ['placeholder' => 'Call Response', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
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
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>


    <?php ActiveForm::end(); ?>

</div>
<?php
$css = <<<cs
 .select2-selection__rendered {
    width: 250px !important;
}
cs;
$this->registerCss($css);
?>