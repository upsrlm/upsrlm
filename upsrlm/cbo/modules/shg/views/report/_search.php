<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
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
            echo $form->field($model, 'district_code')->widget(Select2::classname(), [
                'data' => $model->district_option,
                'options' => ['placeholder' => 'Select District', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('District');
            ?>
        </div>
        <div class="col-xl-10 col-md-8 mb-2">
        <?= Html::submitButton('Search', ['class' => 'btn btn-sm btn-primary mb-2', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'margin-left:10px;padding:7px 20px;']) ?>
            <?= Html::button('Reset', ['class' => 'btn btn-sm btn-primary reset mb-2', 'style' => 'margin-left:10px;padding:7px 20px;', 'id' => 'reloads']) ?>
           <?=
            Html::a('<i class="fal fa-file-excel"></i> Download CSV CBO registration status district wise', ['/shg/report/downloadregdistrict'], [
                'title' => 'Download CSV',
                'class' => 'btn btn-sm btn-info mb-2',
                'style' => 'margin-left:10px;padding:7px 20px;',
                'data-pjax' => 0
            ])
            ?>
            <?=
            Html::a('<i class="fal fa-file-excel"></i> Download CSV CBO registration status block wise', ['/shg/report/downloadregblock'], [
                'title' => 'Download CSV',
                'class' => 'btn btn-sm btn-info mb-2',
                'style' => 'margin-left:10px;padding:7px 20px;',
                'data-pjax' => 0
            ])
            ?> 
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

