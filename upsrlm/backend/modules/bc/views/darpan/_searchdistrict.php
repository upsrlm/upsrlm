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
use kartik\icons\FontAwesomeAsset;

FontAwesomeAsset::register($this);
?>
<div class="row">

    <div class="col-xl-2 col-md-4 mb-2">   
        <?php
        echo $form->field($model, 'date')->widget(Select2::classname(), [
            'data' => $model->date_option,
            'options' => ['placeholder' => 'Select Date', 'style' => 'width:250px'],
            'pluginOptions' => [
                'allowClear' => false
            ],
        ])->label('Date');
        ?>
    </div>  

    <div class="col-xl-2 col-md-4 mb-2"> 
        <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;']) ?>
<?= Html::button('Reset', ['class' => 'btn  btn-primary reset', 'style' => '', 'id' => 'reloads']) ?>

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

