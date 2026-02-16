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
use common\models\master\MasterArea;
?>
   <div class="row">
        <div class="col-xl-2 col-md-4 mb-2">
        <?php

echo $form->field($model, 'district_code')->widget(Select2::classname(), [
    'data' => $model->district_option,
    'options' => ['placeholder' => 'District', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('District');
?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?php

echo $form->field($model, 'block_code')->label('Block')->widget(Select2::classname(), [
    'data' => $model->block_option,
    'options' => ['placeholder' => 'Block', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('Block');
?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">

        <?php

echo $form->field($model, 'gram_panchayat_code')->label('GP')->widget(Select2::classname(), [
    'data' => $model->gp_option,
    'options' => ['placeholder' => 'Gram Panchayat', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('GP');
?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">

        <?php

echo $form->field($model, 'cbo_shg_id')->label('SHG')->widget(Select2::classname(), [
    'data' => $model->shg_option,
    'options' => ['placeholder' => 'SHG', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('SHG');
?>
        </div>
        <div class="col-xl-3 col-md-4 mb-2">
        <?= Html::submitButton('Search', ['class' => 'btn btn-sm btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;']) ?>
<?= Html::button('Reset', ['class' => 'btn btn-sm btn-primary reset', 'style' => ';margin-left:10px;padding:7px 20px;', 'id' => 'reloads']) ?>
        </div>
  
    </div>





<?php

$js = <<<JS
$('#reloads').click(function() {
    location.reload();
});        
JS;
$this->registerJs($js);
$js = <<<JS
 
$('#reloads').click(function() {
    location.reload();
});        
JS;
$this->registerJs($js);

$css = <<<cs
 .select2-selection__rendered {
    width: 230px !important;
}
cs;
$this->registerCss($css);
?>