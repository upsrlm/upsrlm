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
if(is_array($model->district_code)){
 $model->district_code='';   
}
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
        echo $form->field($model, 'number_of_day_work')->widget(Select2::classname(), [
            'data' => $model->numberofdays_option,
            'options' => ['placeholder' => 'Select No of Days Worked', 'style' => 'width:200px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('No of Days Worked');
        ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;']) ?>
        <?= Html::button('Reset', ['class' => 'btn  btn-primary reset', 'style' => 'padding:7px 20px;margin-left:10px', 'id' => 'reloads']) ?>
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