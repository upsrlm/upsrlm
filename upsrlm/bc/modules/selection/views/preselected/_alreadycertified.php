<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\widgets\DetailView;

$this->title = 'Already Certified';
?>
<div class="add-batch_form">  

    <div class="panel panel-default">
        <div class='panel-body'>
            <?php
            $form = ActiveForm::begin([
                        'enableClientValidation' => FALSE,
                        'enableAjaxValidation' => TRUE,
                        'options' => ['id' => 'add-score-form', 'enctype' => 'multipart/form-data'],
            ]);
            ?>
            <div class="row">

                <div class="col-md-4">
                    <?= $form->field($model, 'exam_score')->textInput(['maxlength' => true]) ?>

                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'certificate_code')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?php
                    echo $form->field($model, "iibf_date")->widget(DatePicker::classname(), [
                        'value' => $model->iibf_date,
                        'options' => ['placeholder' => 'IIBF Date', 'class' => 'calculateday', 'readonly' => 'readonly'],
                        'pluginOptions' => [
                            'readonly' => 'readonly',
                            'format' => 'dd-mm-yyyy',
                            'todayHighlight' => true,
                            'autoclose' => true,
                            'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { console.log(dateText, inst) }'),
                        ],
                        'pluginEvents' => [
                            "changeDate" => "function(e) { "
                            . "}",
                        ]
                    ])->label('IIBF Date');
                    ?>
                </div>
                <div class="col-md-12">
                    <?php
                    $form->field($model, 'iibf_photo_file_name', ['enableClientValidation' => true])->widget(\kartik\widgets\FileInput::classname(), [
                        'options' => ['multiple' => false, 'accept' => 'image/*'],
                        'pluginOptions' => [
                            'showPreview' => false,
                            'showCaption' => true,
                            'showCancel' => FALSE,
                            'showRemove' => true,
                            'showUpload' => false,
                        ]
                    ]);
                    ?>
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
    
$('#add-score-form').on('beforeSubmit', function (e) {
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











