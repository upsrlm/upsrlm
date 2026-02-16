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
<?php

echo $form->field($model, 'district_code')->widget(Select2::classname(), [
    'data' => $model->district_option,
    'options' => ['placeholder' => 'Select District', 'style' => 'width:200px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('District');
?>

<?php

if (isset(Yii::$app->user->identity) and !in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
    echo $form->field($model, 'master_partner_bank_id')->widget(Select2::classname(), [
        'data' => $model->bank_option,
        'options' => ['placeholder' => 'Select Partner agencies', 'style' => 'width:200px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Partner agencies');
}
?>

<?php

echo $form->field($model, 'commission_earn')->widget(Select2::classname(), [
    'data' => [1 => '0 Earn', 2 => '1-500 Earn', 3 => '501-2001 Earn', 4 => '2001-5000 Earn', 5 => '5000 Above Earn'],
    'options' => ['placeholder' => 'Select Commission Earn', 'style' => 'width:200px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('Commission Earn');
?>

<?php

echo $form->field($model, 'number_of_day_work')->widget(Select2::classname(), [
    'data' => $model->numberofdays_option,
    'options' => ['placeholder' => 'Select No of Days Worked', 'style' => 'width:200px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('No of Days Worked');
?>

<?php

echo $form->field($model, 'no_of_transaction')->widget(Select2::classname(), [
    'data' => $model->transaction_option,
    'options' => ['placeholder' => 'Select No of Transaction', 'style' => 'width:200px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('No of Transaction');
?>

<?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'margin-left:10px']) ?>
<?= Html::button('Reset', ['class' => 'btn  btn-primary reset', 'style' => 'margin-left:10px', 'id' => 'reloads']) ?>
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

