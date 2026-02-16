<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
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
                    'data-pjax' => true,
                    'id' => 'Searchform'
                ],
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
    echo $form->field($model, 'master_partner_bank_id')->widget(Select2::classname(), [
        'data' => $model->partner_bank_option,
        'options' => ['placeholder' => 'Select Partner Agency', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('District');
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
    echo $form->field($model, 'status')->widget(Select2::classname(), [
        'data' => [10 => 'Active', 9 => 'Inactive'],
        'options' => ['placeholder' => 'Select User Status', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?= Html::submitButton('Search', ['class' => 'btn btn-info btn-sm', 'style' => 'padding:7px 20px;']) ?>
        <?php Html::a('Partner Agency', ['/user/bankdu'], ['class' => 'btn btn-info btn-sm']) ?>
        </div>
    </div>
 
  

 



    <div class="form-group">

       
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