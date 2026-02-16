<?php

use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
?>


<?php

$form = ActiveForm::begin([
            'layout' => 'inline',
            'options' => [
                'class' => 'form-inline',
                'data-pjax' => true,
            ],
            'method' => 'get',
        ]);
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

echo $form->field($model, 'gram_panchayat_code')->label('Gram Panchayat')->widget(Select2::classname(), [
    'data' => $model->gp_option,
    'options' => ['placeholder' => 'Gram Panchayat', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
<?php

echo $form->field($model, 'wada')->label('WADA SHG')->widget(Select2::classname(), [
    'data' => [1 => 'Yes', 0 => 'No'],
    'options' => ['placeholder' => 'WADA SHG', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
<?php

echo $form->field($model, 'rishta_app_used')->widget(Select2::classname(), [
    'bsVersion' => '4.x',
    'data' => [1 => 'Yes', 0 => 'No'],
    'options' => ['placeholder' => 'Rishta App', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('');
?> 
<?php

echo $form->field($model, 'bc_sakhi')->label('BC Sakhi')->widget(Select2::classname(), [
    'data' => [1 => 'Yes', 0 => 'No'],
    'options' => ['placeholder' => 'BC Sakhi', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
<?php

echo $form->field($model, 'shg_chairperson')->label('SHG chairperson')->widget(Select2::classname(), [
    'data' => [1 => 'Yes', 0 => 'No'],
    'options' => ['placeholder' => 'SHG chairperson', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
<?php

echo $form->field($model, 'shg_secretary')->label('SHG secretary')->widget(Select2::classname(), [
    'data' => [1 => 'Yes', 0 => 'No'],
    'options' => ['placeholder' => 'SHG secretary', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
<?php

echo $form->field($model, 'shg_treasurer')->label('SHG treasurer')->widget(Select2::classname(), [
    'data' => [1 => 'Yes', 0 => 'No'],
    'options' => ['placeholder' => 'SHG treasurer', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
<?php

echo $form->field($model, 'shg_member')->label('SHG Member')->widget(Select2::classname(), [
    'data' => [1 => 'Yes', 0 => 'No'],
    'options' => ['placeholder' => 'SHG Member', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
<?php

echo $form->field($model, 'samuh_sakhi')->label('Samuh Sakhi')->widget(Select2::classname(), [
    'data' => [1 => 'Yes', 0 => 'No'],
    'options' => ['placeholder' => 'Samuh Sakhi', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
<?= $form->field($model, 'shg_chairperson')->checkbox(['uncheck' => null]); ?>
<?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>



<?php ActiveForm::end(); ?>

<?php

$css = <<<cs
 .select2-selection__rendered {
    width: 200px !important;
}
cs;
$this->registerCss($css);
?>