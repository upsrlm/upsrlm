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
//echo $request_url;
?>
<div class="srlm-search">
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
            echo $form->field($model, 'division_code')->widget(Select2::classname(), [
                'data' => $model->division_option,
                'options' => ['placeholder' => 'Select Division', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Division');
            ?>
        </div>
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
                'options' => ['placeholder' => 'Select GP', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('GP');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">

            <?php
            echo $form->field($model, 'pin_used')->widget(Select2::classname(), [
                'data' => [0 => 'No', 1 => 'Yes'],
                'options' => ['placeholder' => 'Got PIN?', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Got PIN');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'training_status')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => [0 => 'Preselected', 1 => 'Agree', '2' => 'Registered(Assign Batch)'],
                'options' => ['placeholder' => 'Training Status', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Training Status');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'blocked_bc')->widget(Select2::classname(), [
                'data' => [0 => 'No', 1 => 'Yes'],
                'options' => ['placeholder' => 'Blocked', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Blocked');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?= Html::submitButton('Search', ['class' => 'btn btn-sm btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;']) ?>

        </div>
    </div>
    <?php
//    echo $form->field($model, 'otp_mobile_no', [
//        'template' => '{label}<div class="col-xs-12">{input}</div>',
//    ])->textInput(['placeholder' => 'Mobile Number'])
    ?>














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

