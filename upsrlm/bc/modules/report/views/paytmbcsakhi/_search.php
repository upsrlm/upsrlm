<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use common\models\master\MasterRole;
use yii\bootstrap4\ButtonDropdown;
use bc\modules\selection\models\PaytmBcSakhi;

$request = explode('?', Yii::$app->request->url);
$request_url = rtrim($request[0], '/');
//echo $request_url;
?>
<div class="srlm-search">
    <?php
    $form = ActiveForm::begin([
//                'layout' => 'inline',
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
            echo $form->field($model, 'district_code')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => ArrayHelper::map(PaytmBcSakhi::find()->all(), 'district_code', 'district'),
                'options' => ['placeholder' => 'District', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('District');
            ?>
        </div>

        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'onboarding_status')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => ['Yes' => 'Yes', 'No' => 'No'],
                'options' => ['placeholder' => 'Onboarding Status', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Onboarding Status');
            ?>
        </div>

        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'bmd_1650')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => ['Yes' => 'Yes', 'No' => 'No'],
                'options' => ['placeholder' => 'Biometric Device', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'sarthi_device_25000')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => ['Yes' => 'Yes', 'No' => 'No'],
                'options' => ['placeholder' => 'Micro ATM Device', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
<!--        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'both_devices')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => ['Yes' => 'Yes', 'No' => 'No'],
                'options' => ['placeholder' => 'Both Devices', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'device_not_purchased')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => ['Device Purchased' => 'Device Purchased', 'Device Not Purchased' => 'Device Not Purchased'],
                'options' => ['placeholder' => 'Device', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>-->
        <div class="col-xl-2 col-md-4 mb-2 mt-2">
            <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'margin-top:10px']) ?>

        </div>

    </div>

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
    width: 150px !important;
}
cs;
$this->registerCss($css);
?>