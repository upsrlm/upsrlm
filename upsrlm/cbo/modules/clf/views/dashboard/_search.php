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
            echo $form->field($model, 'type_column')->label('Fund Type')->widget(Select2::classname(), [
                'data' => $model->funds_type_column_option,
                'options' => ['placeholder' => 'Select Fund Type', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
</div>
<div class="col-xl-2 col-md-4 mb-2">
<?php
            echo $form->field($model, 'order_by')->label('Order By')->widget(Select2::classname(), [
                'data' => $model->order_by_option,
                'options' => ['placeholder' => 'Select Order By', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
</div>
<div class="col-xl-2 col-md-4 mb-2">
<?php
            echo $form->field($model, 'status')->label('CLF Status')->widget(Select2::classname(), [
                'data' => [1 => 'Save', 2 => 'Submit'],
                'options' => ['placeholder' => 'Select Status', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
</div>
<div class="col-xl-2 col-md-4 mb-2 ">
<?= Html::submitButton('Search', ['class' => 'btn btn-sm btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;margin-left:10px']) ?>
            <?= Html::button('Reset', ['class' => 'btn btn-sm btn-primary reset', 'style' => 'padding:7px 20px;margin-left:10px', 'id' => 'reloads']) ?>
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

