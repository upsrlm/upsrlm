<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use bc\modules\selection\models\base\GenralModel;
use common\models\User;

?>
<?php
$class = 'hide';
if ($button_type) {
    $class = 'show';
}

$class1 = 'hide';
if ($button_type == 2 || $button_type == 3) {
    $class1 = 'show';
}
$class2 = 'hide';
if ($button_type == 3) {
    $class2 = 'show';
}
if ($button_type == 4) {
    $class2 = 'show';
}
?>
<div class="box box-info <?= $class ?>">
    <input type="hidden" name="button_type" value="<?= $button_type ?>">
    <div class="row-fluid">
        <div class="col-lg-3">
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
        <div class="col-lg-3 <?= $class1 ?>">
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
        <div class="col-lg-3 <?= $class2 ?>">
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
        <div class="col-lg-3">
            <?= Html::submitButton('<i class="fa fa-search"></i>Search', ['class' => 'btn btn-primary ', 'style' => 'margin-top:10px', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search']) . '&nbsp;' ?>
            <?= Html::button('Reset', ['class' => 'btn  btn-primary reset', 'style' => 'margin-top:10px', 'id' => 'reloads']) ?>
        </div> 
        
            <div class="col-lg-12">
                <?php if ($button_type == 4) { ?>
                <?=Html::button('<i class="fa fa-file-excel-o"></i>GP start registration but incomplete Download CSV', ['class' => 'btn btn-primary ', 'id' => 'download', 'name' => 'download', 'value' => 'download', 'style' => 'padding: 6px 12px']) ?>
                <?php } ?>
                <?php if ($button_type == 3) { ?>
                <?= Html::button('<i class="fa fa-file-excel-o"></i> GP not start registration Download CSV', ['class' => 'btn btn-primary ', 'id' => 'downloadcsv', 'name' => 'downloadcsv', 'value' => 'downloadcsv', 'style' => 'padding: 6px 12px']) ?>
                <?php } ?>
            </div>
        
    </div>
</div>   
<?php
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
        $('#reloads').click(function() {
               location.reload();
         }); 
         $("#Searchform button").click(function (ev) {
             ev.preventDefault()
                $("#Searchform").attr({ "action":"/selection/application/registration"});
                $("#Searchform").attr("data-pjax", "True");
                $("#Searchform").submit();
           });
            $("#download").click(function(event){
              $("#Searchform").attr({ "action":"/selection/application/csvstartnotcomgp"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
         $("#downloadcsv").click(function(event){
              $("#Searchform").attr({ "action":"/selection/application/csvnotreggp"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
        $("#searchbtn").click(function(event){
                $("#Searchform").attr({ "action":"/selection/application/registration"});
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

$this->registerJs($js);
?>