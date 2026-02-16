<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use \yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use bc\modules\selection\models\base\GenralModel;
use common\models\User;
?>

        <?php
        $form = ActiveForm::begin([
                    'layout' => 'inline',
                    'options' => [
                        'class' => 'form-inline',
                        'data-pjax' => true,
                        'id' => 'Searchform',
                    ],
                   
                    'method' => 'get',
        ]);
        ?>
        <div class="row">
            <div class="col-xl-2 col-md-4 mb-2">
            <?php echo $form->field($model, 'district_code')->dropDownList($model->district_option, ['prompt' => 'District Name', 'style' => 'width:250px', 'style' => 'height:40px'])->label(false); ?>
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
            <?= '&nbsp;'.Html::submitButton('<i class="fal fa-search"></i> Search', ['class' => 'btn btn-primary btn-md py-2 px-3', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search']) . '&nbsp;' ?>
            <?php if ($model->district_code || $model->block_code) { ?>
                <?= Html::button('<i class="fal fa-file-pdf"></i> Download PDF', ['class' => 'btn btn-primary btn-md py-2 px-3', 'id' => 'download', 'name' => 'download', 'value' => 'download']). '&nbsp;' ?>
                <?= Html::button('<i class="fal fa-file-excel"></i> Download CSV', ['class' => 'btn btn-primary btn-md py-2 px-3', 'id' => 'downloadcsv', 'name' => 'downloadcsv', 'value' => 'downloadcsv']). '&nbsp;' ?>
            <?php } ?>
            </div>
        </div>
      
    

       

           
       
        <?php ActiveForm::end(); ?>
   
<?php
$script = <<< JS
    $('form select').on('change', function(){
    $(this).closest('form').submit();
});                   
JS;
$this->registerJs($script);
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
              $("#Searchform").attr({ "action":"/selection/application/pdfgp"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
         $("#downloadcsv").click(function(event){
              $("#Searchform").attr({ "action":"/selection/application/csvgp"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
        $("#searchbtn").click(function(event){
                $("#Searchform").attr({ "action":"/selection/application/grampanchayat"});
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

$this->registerJs($js);
?>