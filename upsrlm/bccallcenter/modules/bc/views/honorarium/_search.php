<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use common\models\base\GenralModel;
use common\models\User;
use common\models\master\MasterRole;
use yii\bootstrap\ButtonDropdown;

$request = explode('?', Yii::$app->request->url);
$request_url = rtrim($request[0], '/');
//echo $request_url;
?>
   <div class="row">
        <div class="col-xl-2 col-md-4 mb-2">
        <?php
    echo $form->field($model, 'district_code')->widget(Select2::classname(), [
        'bsVersion' => '4.x',
        'data' => $model->district_option,
        'options' => ['placeholder' => 'District', 'style' => 'width:200px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('District');
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?php
    echo $form->field($model, 'block_code')->widget(Select2::classname(), [
        'bsVersion' => '4.x',
        'data' => $model->block_option,
        'options' => ['placeholder' => 'Block', 'style' => 'width:200px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Block');
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">

        <?php
    echo $form->field($model, 'gram_panchayat_code')->widget(Select2::classname(), [
        'bsVersion' => '4.x',
        'data' => $model->gp_option,
        'options' => ['placeholder' => 'GP', 'style' => 'width:200px'],
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
        <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;']) ?>
        </div>

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

