<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use \yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use common\models\base\GenralModel;
use common\models\User;
use common\models\master\MasterArea;
?>
<div class="srlm-search">
    <?php
    $form = ActiveForm::begin([
                'options' => [
                    'class' => 'form-inline',
                    'data-pjax' => true,
                    'id' => 'Searchform'
                ],
                'method' => 'get',
    ]);
    ?>
    <div class="row">
        <div class="col-xl-2 col-md-4 mb-2">
        <?php
            echo $form->field($model, 'district_code')->widget(Select2::classname(), [
                'data' => $model->district_option,
                'options' => ['placeholder' => 'Select District', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('District');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?php
            echo $form->field($model, 'rsetis_center_id')->widget(Select2::classname(), [
                'data' => $model->center_option,
                'options' => ['placeholder' => 'Select Venue', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Venue');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?php
            echo $form->field($model, 'rsetis_center_training_id')->widget(Select2::classname(), [
                'data' => $model->training_option,
                'options' => ['placeholder' => 'Select Training', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Training');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;']) ?>
        <?= Html::button('Reset', ['class' => 'btn  btn-primary reset', 'style' => 'padding:7px 20px;margin-left:10px', 'id' => 'reloads']) ?>
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
    width: 250px !important;
}
cs;
$this->registerCss($css);
?>