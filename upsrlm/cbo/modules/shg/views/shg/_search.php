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
<!--    <div class="row-fluid">
        <div class="col-lg-12">-->
            <?php  
//            echo $form->field($model, 'name_of_shg',['template' => '<span class="col-md-9 col-lg-9"><label class="control-label">{label}</label><br/>{input}{error}</span>'
//                            ])->textInput([])
//                    ->label('SHG Name') ?>
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
//            echo $form->field($model, 'gram_panchayat_code')->label('Gram Panchayat')->widget(Select2::classname(), [
//                'data' => $model->gp_option,
//                'options' => ['placeholder' => 'Select Gram Panchayat', 'style' => 'width:250px'],
//                'pluginOptions' => [
//                    'allowClear' => true
//                ],
//            ]);
            ?>
            <?php
//            echo $form->field($model, 'village_code')->label('Rev. Village')->widget(Select2::classname(), [
//                'data' => $model->village_option,
//                'options' => ['placeholder' => 'Select Rev. Village', 'style' => 'width:250px'],
//                'pluginOptions' => [
//                    'allowClear' => true
//                ],
//            ]);
            ?>
            <?php
            echo $form->field($model, 'verification_status')->widget(Select2::classname(), [
                'data' => [1=>'Completed',0=>'Not Completed'],
                'options' => ['placeholder' => '', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Verification Process');
            ?>
            <?php
            echo $form->field($model, 'verify_mobile_no')->widget(Select2::classname(), [
                'data' => $model->verify_option,
                'options' => ['placeholder' => '', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Verification Status');
            ?>
            

            <?= Html::submitButton('Search', ['class' => 'btn btn-sm btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'margin-top:10px;width:75px;margin-left:10px']) ?>
            <?= Html::button('Reset', ['class' => 'btn btn-sm btn-primary reset', 'style' => 'margin-top:10px;width:75px;margin-left:10px', 'id' => 'reloads']) ?>
          
<!--        </div>

    </div>-->
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
<?php
$js = <<<js
        
        $(document).ready(function(){
            $("#download").click(function(event){
              $("#Searchform").attr({ "action":"/srlm/data/bcselection/reportpdf"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
        $("#searchbtn").click(function(event){
                
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

$this->registerJs($js);
?>

