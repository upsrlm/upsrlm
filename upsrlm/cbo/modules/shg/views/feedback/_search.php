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
<div class="srlm-search">
    <?php
    $form = ActiveForm::begin([
                'layout' => 'inline',
                'options' => [
                    'class' => 'form-inline',
                    'data-pjax' => true,
                    'id' => 'Searchform'
                ],
                'method' => 'get',
    ]);
    ?>

<div class="row">
    <div class="col-xl-3 col-md-4 mb-2">
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
    <div class="col-xl-3 col-md-4 mb-2">
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
    <div class="col-xl-3 col-md-4 mb-2">
    <?php
    echo $form->field($model, 'gram_panchayat_code')->label('Gram Panchayat')->widget(Select2::classname(), [
        'data' => $model->gp_option,
        'options' => ['placeholder' => 'Select Gram Panchayat', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    </div>

    <div class="col-xl-3 col-md-4 mb-2">

    <?= Html::submitButton('Search', ['class' => 'btn btn-sm btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'margin-left:10px;padding:7px 20px;']) ?>
    <?= Html::button('Reset', ['class' => 'btn btn-sm btn-primary reset', 'style' => 'margin-left:10px;padding:7px 20px;', 'id' => 'reloads']) ?>
    <?=Html::button('<i class="fal fa-download-alt"></i> Download Feedback CSV', ['class' => 'btn btn-primary btn-sm', 'style' => 'margin-left:10px;padding:7px 20px;', 'id' => 'download', 'name' => 'download', 'value' => 'download']) ?>
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


