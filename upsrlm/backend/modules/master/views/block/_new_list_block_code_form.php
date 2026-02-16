<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\widgets\DetailView;

$this->title = 'New List Bock Code';
?>
<div class="panel panel-default">

    <div class='panel-body'>
        <div class="col-lg-12">
            <?php
            $form = ActiveForm::begin([
                        'enableClientValidation' => FALSE,
                        'enableAjaxValidation' => TRUE,
                        'options' => ['id' => 'block-code-form', 'enctype' => 'multipart/form-data'],
            ]);
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <?= $form->field($model, 'new_block_code')->textInput(); ?>
                </div>
                 <div class="col-lg-12">
                    <?= $form->field($model, 'new_block_name')->textInput(); ?>
                </div>

            </div>
            <div class="col-md-12">
                <div class="text-center">
                    <?= Html::submitButton('<i class="fa fa-save"></i> Save', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>       
    </div>
</div>

<?php
$js = <<<JS
    
$('#block-code-form').on('beforeSubmit', function (e) {
    var form = $(this);
    var submit = form.find(':submit');
    submit.html('<span class="fa fa-spin fa-spinner"></span> Wait...');
    submit.prop('disabled', true);

});       
JS;
$this->registerJs($js);
?>
<?php
$css = <<<css
   div.required label.control-label:after {
    content: " *";
    color: red;
}
css;
$this->registerCss($css);
?>
