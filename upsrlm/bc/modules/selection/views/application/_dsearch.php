<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2
?>
<div class="search">

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
        <?php
    echo $form->field($model, 'district_code')->widget(kartik\select2\Select2::classname(), [
        'data' => $model->district_option,
        'size' => Select2::MEDIUM,
        'options' => ['placeholder' => 'Select District', 'multiple' => TRUE],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
        </div>
        <div class="col-xl-4 col-md-4 mb-2">
        <?= Html::submitButton(' Search', ['class' => 'btn btn-primary btn-md', 'id' => 'searchbtn','style'=>'padding:7px 20px;']) . '&nbsp;' ?>
        <?=
    ' ' .Html::a('<i class="fal fa-file-pdf"></i> Download PDF', ['/selection/application/pdfdistrict'], [
        'title' => 'Download PDF',
        'class' => 'btn  btn-info py-2 px-3',
        'data-pjax' => 0
    ])
    ?>
    <?=
    ' ' .Html::a('<i class="fal fa-file-excel"></i> Download CSV', ['/selection/application/csvdistrict'], [
        'title' => 'Download CSV',
        'class' => 'btn  btn-info py-2 px-3',
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

$css = <<<cs
 .select2-selection__rendered {
    width: 250px !important;
}
cs;
$this->registerCss($css);
?>