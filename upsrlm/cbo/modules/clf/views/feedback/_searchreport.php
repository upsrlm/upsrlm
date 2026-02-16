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
?>

<div class="row">
    <div class="col-xl-2 col-md-4 mb-2">
    <?php
    echo $form->field($model, 'district_code')->label('District')->widget(Select2::classname(), [
        'data' => $model->district_option,
        'options' => ['placeholder' => 'Select District', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
    <?php
    echo $form->field($model, 'block_code')->label('Block')->widget(Select2::classname(), [
        'data' => $model->block_option,
        'options' => ['placeholder' => 'Select Block', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
    <?php
    echo $form->field($model, 'ques_8')->label('क्या मोबाइल ऐप के लिए कोई शुल्क निर्धारित होना चाहिए')->widget(Select2::classname(), [
        'data' => [1 => 'हाँ', 2 => 'नहीं '],
        'options' => ['placeholder' => 'Select', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
    <?= Html::submitButton('Search', ['class' => 'btn btn-sm btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px; margin-left:10px']) ?>
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
    width: 250px !important;
}
cs;
$this->registerCss($css);
?>


