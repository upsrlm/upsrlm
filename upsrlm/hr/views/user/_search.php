<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use \yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
use common\models\base\GenralModel;
?>

<div class="search-form ">

    <?php
    $form = ActiveForm::begin([
                'layout' => 'inline',
                'options' => [
                    'class' => 'form-inline',
                    'data-pjax' => true,
                    'id' => 'search-form'
                ],
//                'fieldConfig' => [
//                    'template' => "{label}\n<div class=\"col-lg-0\">{input}</div>",
//                    'labelOptions' => ['class' => 'col-md-12 control-label'],
//                ],
                'method' => 'get',
    ]);
    ?>
    <div class="row">
        <div class="col-xl-2 col-md-4 mb-2">
        <?=
    $form->field($model, 'name', [
        'template' => '{label}<div class="col-xs-12">{input}</div>',
    ])->textInput(['placeholder' => 'Name'])
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?=
    $form->field($model, 'username', [
        'template' => '{label}<div class="col-xs-12">{input}</div>',
    ])->textInput(['placeholder' => 'Login'])->label('Login')
    ?>
        </div>
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
    echo $form->field($model, 'block_code')->label('Block')->widget(Select2::classname(), [
        'data' => $model->block_option,
        'options' => ['placeholder' => 'Select Block', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Block');
    ?>
            </div>
            <div class="col-xl-2 col-md-4 mb-2">
            <?php
    echo $form->field($model, 'profile_status')->widget(Select2::classname(), [
        'data' => GenralModel::profilesoption(),
        'options' => ['placeholder' => 'Select Profile Status', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Profile Status');
    ?>
            </div>
            <div class="col-xl-2 col-md-4 mb-2">
            <?php
    echo $form->field($model, 'verification_status')->widget(Select2::classname(), [
        'data' => [1 => 'Verify', 2 => 'Reject'],
        'options' => ['placeholder' => 'Select Verification Status', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Verification Status');
    ?>
            </div>
            <?= $form->field($model, 'page')->hiddenInput()->label(false) ?>
            <div class="col-xl-4 col-md-4 mb-2">
            <?= Html::submitButton('Search', ['class' => 'btn btn-info btn-sm', 'style' => 'padding:7px 20px;']) ?>
            </div>
    </div>
 
    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<< JS
    $('form select').on('change', function(){   
     $("#Searchform").attr("data-pjax", "True");    
    $(this).closest('form').submit();
});            
$('form input').on('change', function(){
     $("#Searchform").attr("data-pjax", "True");    
    $(this).closest('form').submit();
});        
JS;
$this->registerJs($script);
?>   
<?php
$css = <<<cs
 .select2-selection__rendered {
    width: 200px !important;
}
.input-group-addon{
/* width:20px !important;*/       
}    
cs;
$this->registerCss($css);
?>