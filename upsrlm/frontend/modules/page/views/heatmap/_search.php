<?php

use kartik\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\helpers\Utility;

$form = ActiveForm::begin([
    'options' => [
        'class' => 'form-inline',
        'data-pjax' => true,
        'id' => 'Searchform'
    ],
    'id' => 'Searchform',
//    'layout' => 'inline',
    'method' => 'POST',
        ]);
?>
<div class="col-md-12">
    <div class="row">
        <div class="mr-2">
            <?php
            echo $form->field($model, 'district_code')->widget(Select2::classname(), [
                'data' => $model->district_option,
                'options' => ['placeholder' => 'चुने', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="mr-2">
            <?php
            echo $form->field($model, 'month_id')->widget(Select2::classname(), [
                'data' => $model->month_option,
                'options' => ['placeholder' => 'चुने', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ]);
            ?>
        </div>

        <?php echo $form->field($model, 'change_type')->hiddenInput()->label(false); ?>
        <div class="mt-4">
            <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;']) ?>
        </div>

    </div>
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
    width: 150px !important;
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


<?php ActiveForm::end(); ?>