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
    <div class="col-xl-2 col-md-4 mb-2">

        <?php

echo $form->field($model, 'nretp')->widget(Select2::classname(), [
    'bsVersion' => '4.x',
    'data' => [1 => 'Yes', 0 => 'No'],
    'options' => ['placeholder' => 'NRETP Block', 'style' => 'width:200px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('NRETP Block');
?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php

if (isset(Yii::$app->user->identity) and!in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
    echo $form->field($model, 'master_partner_bank_id')->widget(Select2::classname(), [
        'data' => $model->bank_option,
        'options' => ['placeholder' => 'Select Partner agencies', 'style' => 'width:200px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Partner agencies');
}
?>
    </div>
    <div class="col-xl-4 col-md-4 mb-2">

        <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;']) ?>
        <?= Html::button('Reset', ['class' => 'btn  btn-primary reset', 'style' => 'padding:7px 20px;margin-left:10px', 'id' => 'reloads']) ?>
        <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) { ?>
        <?php echo Html::button('<i class="glyphicon glyphicon-download-alt"></i> Download CSV', ['class' => 'btn btn-primary ', 'style' => 'padding:7px 20px;margin-left:10px;', 'id' => 'download', 'name' => 'download', 'value' => 'download']) ?>
        <?php } ?>
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