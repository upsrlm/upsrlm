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
<div class="search">
    <?php
    $form = ActiveForm::begin([
                'layout' => 'inline',
                'options' => [
                    'data-pjax' => true,
                    'id' => 'Searchform'
                ],
                'method' => 'get',
    ]);
    ?>
    <?php
    echo $form->field($model, 'gram_panchayat_name')->textInput(['placeholder' => 'Gram Panchayat Name']);
    ?>
    <?php
    echo $form->field($model, 'district_code')->widget(Select2::classname(), [
        'data' => $model->district_option,
        'options' => ['placeholder' => 'Select District', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    <?php
    echo $form->field($model, 'block_code')->label('Block')->widget(Select2::classname(), [
        'data' => $model->block_option,
        'options' => ['placeholder' => 'Select Block', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    <?php
//    echo $form->field($model, 'new')->widget(Select2::classname(), [
//        'data' => [1 => 'Yes', 0 => "No"],
//        'options' => ['placeholder' => 'New Entry', 'style' => 'width:250px'],
//        'pluginOptions' => [
//            'allowClear' => true
//        ],
//    ]);
    ?>

    <?php
//    echo $form->field($model, 'new_status')->widget(Select2::classname(), [
//        'data' => [1 => 'Yes', 0 => "No"],
//        'options' => ['placeholder' => 'Match New GP List', 'style' => 'width:250px'],
//        'pluginOptions' => [
//            'allowClear' => true
//        ],
//    ]);
    ?>
    <?php
//    echo $form->field($model, 'gp_covert_urban')->widget(Select2::classname(), [
//        'data' => [1 => 'Yes', 0 => "No"],
//        'options' => ['placeholder' => 'GP covert urban', 'style' => 'width:250px'],
//        'pluginOptions' => [
//            'allowClear' => true
//        ],
//    ]);
    ?>


    <?= Html::submitButton('Search', ['class' => 'btn btn-sm btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'margin-top:10px;width:75px;margin-left:10px']) ?>
    <?= Html::button('Reset', ['class' => 'btn btn-sm btn-primary reset', 'style' => 'margin-top:10px;width:75px;margin-left:10px', 'id' => 'reloads']) ?>

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
    $(".reset").click(function() {
   $("select").each(function() { this.selectedIndex = 0 });
        $(this).closest('form').submit();
});
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

