<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use common\models\base\GenralModel;
use common\models\User;
use common\models\master\MasterRole;

$request = explode('?', Yii::$app->request->url);
$request_url = rtrim($request[0], '/');
//echo $request_url;
?>
<!--<div class="col-lg-12">-->
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
echo $form->field($model, 'block_code')->widget(Select2::classname(), [
    'data' => $model->block_option,
    'options' => ['placeholder' => 'Select Block', 'style' => 'width:200px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('Block');
?>
<?php
echo $form->field($model, 'gram_panchayat_code')->widget(Select2::classname(), [
    'data' => $model->gp_option,
    'options' => ['placeholder' => 'Select GP', 'style' => 'width:200px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('GP');
?>
<?php
echo $form->field($model, 'que1a')->widget(Select2::classname(), [
    'data' => $model->q1_option,
    'options' => ['placeholder' => 'क्या आपके गाँव/ ग्राम पंचायत में काफ़ी लोगों को तेज बुख़ार, साँस की तकलीफ़, सीने में जकड़न इत्यादि की शिकायत है', 'style' => 'width:200px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
<?php
echo $form->field($model, 'que2a')->widget(Select2::classname(), [
    'data' => $model->q2_option,
    'options' => ['placeholder' => 'अगर हाँ तो %', 'style' => 'width:200px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
<?php
echo $form->field($model, 'que3a')->widget(Select2::classname(), [
    'data' => $model->q3_option,
    'options' => ['placeholder' => 'पिछले एक दो महीने में गाँव/ ग्रा०प० में कितने लोगों की मृत्यु हुई है', 'style' => 'width:200px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
<?php
echo $form->field($model, 'que4a')->widget(Select2::classname(), [
    'data' => $model->q4_option,
    'options' => ['placeholder' => 'पिछले कुछ दिनों में गाँव में इस तरह के बीमारियों की गम्भीरता कैसी है', 'style' => 'width:200px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
<?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search']).' ' ?>
<?php if (isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) { ?>
    <?php echo ' ',Html::button('<i class="glyphicon glyphicon-download-alt"></i> Download CSV', ['class' => 'btn btn-primary ', 'id' => 'download', 'name' => 'download', 'value' => 'download']) ?>
<?php } ?>

<?php
$css = <<<cs
 .select2-selection__rendered {
    width: 150px !important;
}
cs;
$this->registerCss($css);
?>
<?php
$script = <<< JS
    $('form select').on('change', function(){
     $("#Searchform").attr({ "action":"/corona"});
     $("#Searchform").attr("data-pjax", "True");    
    $(this).closest('form').submit();
});            
   
JS;
$this->registerJs($script);
?>