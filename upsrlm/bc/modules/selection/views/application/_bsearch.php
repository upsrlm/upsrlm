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

$form = ActiveForm::begin([
            'layout' => 'inline',
            'options' => [
                'class' => 'form-inline',
                'data-pjax' => true,
                'id' => 'search-form'
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
    'options' => ['placeholder' => 'Block', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
    </div>
    <div class="col-xl-6 col-md-4 mb-2">
    <?= Html::submitButton('<i class="fal fa-search"></i>Search', ['class' => 'btn btn-primary btn-md py-2 px-3', 'id' => 'searchbtn']) . '&nbsp;' ?>

<?=

' ' . Html::a('<i class="fal fa-file-pdf"></i> Download PDF', ['/selection/application/pdfblock'], [
    'title' => 'Download PDF',
    'class' => 'btn btn-primary btn-md py-2 px-3',
    'data-pjax' => 0
])
?>
<?=

' ' .Html::a('<i class="fal fa-file-excel"></i> Download CSV', ['/selection/application/csvblock'], [
    'title' => 'Download CSV',
    'class' => 'btn  btn-info',
    'class' => 'btn btn-primary btn-md py-2 px-3',
    'data-pjax' => 0
])
?> 
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