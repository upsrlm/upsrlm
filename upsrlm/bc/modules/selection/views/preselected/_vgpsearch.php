<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use bc\modules\selection\models\base\GenralModel;
use common\models\User;
use common\models\master\MasterRole;
?>

<?php

echo $form->field($model, 'district_code')->widget(Select2::classname(), [
    'data' => $model->district_option,
    'options' => ['placeholder' => 'District', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
<?php

echo $form->field($model, 'block_code')->label('Block')->widget(Select2::classname(), [
    'data' => $model->block_option,
    'options' => ['placeholder' => 'Block', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>


<?php

echo $form->field($model, 'gram_panchayat_code')->widget(Select2::classname(), [
    'data' => $model->gp_option,
    'options' => ['placeholder' => 'GP', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
<?php

echo $form->field($model, 'training_status')->widget(Select2::classname(), [
    'data' => ['4' => 'Not Certified', '5' => 'ineligible', '6' => 'Absent', '-2' => 'Unwilling', '32' => 'Certified Unwilling'],
    'options' => ['placeholder' => 'Vacant Reason', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('Vacant Reason');
?>
<?php

echo $form->field($model, 'master_partner_bank_id')->widget(Select2::classname(), [
    'data' => $model->bc_partner_bank_option,
    'options' => ['placeholder' => 'Partner agencies', 'style' => 'width:200px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
<?php

echo $form->field($model, 'singleapplication')->label('Application')->widget(Select2::classname(), [
    'data' => [1 => 'Single Application', 2 => 'Multiple Application'],
    'options' => ['placeholder' => 'Select', 'style' => 'width:200px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>

<?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'margin-left:10px']) ?>
<?= Html::button('Reset', ['class' => 'btn  btn-primary reset', 'style' => 'margin-left:10px', 'id' => 'reloads']) ?>
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


