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
use common\models\master\MasterRole;

$request = explode('?', Yii::$app->request->url);
$request_url = rtrim($request[0], '/');
?>
<?php
    $form = ActiveForm::begin([
                'layout' => 'inline',
                'options' => [
                    'class' => 'form-inline',
                    'data-pjax' => true,
                    'id' => 'Searchform'
                ],
                'method' => 'POST',
    ]);
    ?>
    <div class="row">
        <div class="col-xl-2 col-md-4 mb-2">
        <?php

echo $form->field($model, 'aspirational')->widget(Select2::classname(), [
    'data' => ['1' => 'Yes', '0' => 'No'],
    'options' => ['placeholder' => 'Aspirational Block', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?php

echo $form->field($model, 'district_code')->widget(Select2::classname(), [
    'data' => $model->district_option,
    'options' => ['placeholder' => 'District', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?php

echo $form->field($model, 'block_code')->widget(Select2::classname(), [
    'data' => $model->block_option,
    'options' => ['placeholder' => 'Block', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2 ">
        <?php

echo $form->field($model, 'gram_panchayat_code')->widget(Select2::classname(), [
    'data' => $model->gp_option,
    'options' => ['placeholder' => 'GP', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => ' padding:7px 20px; margin-left:10px']) ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?php echo $form->field($model, 'change_type')->hiddenInput()->label(false); ?>
        </div>
    </div>

 <?php ActiveForm::end(); ?>
<?php

$js = <<<JS

$('#reloads').click(function() {
    location.reload();
});        
JS;
$this->registerJs($js);

$css = <<<cs
 .select2-selection__rendered {
    width: 250px !important;
}
cs;
$this->registerCss($css);
?>


