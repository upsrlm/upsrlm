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
                'method' => 'POST',
    ]);
    ?>
    <div class="row">
        <div class="col-xl-2 col-md-4 mb-2">
            <?=
            $form->field($model, 'mopup_name', [
                'template' => '{label}<div class="col-xs-12">{input}</div>',
            ])->textInput(['placeholder' => 'Name'])
            ?>
        </div>
        <div class="col-xl-2 col-md-2 mb-2">
            <?=
            $form->field($model, 'username', [
                'template' => '{label}<div class="col-xs-12">{input}</div>',
            ])->textInput(['placeholder' => 'Mobile no'])->label('Mobile no')
            ?>
        </div>
<!--        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'role')->widget(Select2::classname(), [
                'data' => [
                    41 => 'ग्राम पंचायत सचिव',
                    43 => 'ग्राम पंचायत सहायक',
                    44 => 'ग्राम प्रधान',
                    45 => 'ग्राम रोजगार सेवक',
                    46 => 'ग्राम सफाई कर्मचारी',
                    47 => 'CSO User',
                    100 => 'CBO / समूह सखी/ सामुदायिक कैडर'
                ],
                'options' => ['placeholder' => 'Role', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Role');
            ?>
        </div>-->
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
                'options' => ['placeholder' => 'Select GP', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('GP');
            ?>
        </div>

        <div class="col-xl-1 col-md-1 mb-2">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search',]) ?>
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
.form-inline{

    display: block !important;
  }
  .form-inline .form-group{
  
    display: block !important;
  }
cs;
$this->registerCss($css);
?>