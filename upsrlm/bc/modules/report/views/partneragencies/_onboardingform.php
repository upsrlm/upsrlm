<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\widgets\DetailView;

$this->title = 'Onboarding';
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>

            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <?php
                    $form = ActiveForm::begin([
                                'id'=>'can-form',
                                'enableClientValidation' => FALSE,
                                'enableAjaxValidation' => TRUE,
                                'action' => $model->action_url,
                                'validationUrl' => $model->action_validate_url,
                                'options' => ['enctype' => 'multipart/form-data']
                    ]);
                    ?>
                    <div class="row">
                        <div class="col-lg-6">
                            <?= $form->field($model, 'onboarding')->radioList([1 => 'Yes', 0 => 'No']); ?>
                        </div>
                        <div class="col-md-6">
                            <?php
                            echo $form->field($model, "onboarding_date_time")->widget(DatePicker::classname(), [
                                'value' => $model->onboarding_date_time,
                                'options' => ['placeholder' => 'Onboard Date', 'class' => 'calculateday', 'readonly' => 'readonly'],
                                'pluginOptions' => [
                                    'readonly' => 'readonly',
                                    'format' => 'yyyy-mm-dd',
                                    'todayHighlight' => true,
                                    'autoclose' => true,
                                    'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { console.log(dateText, inst) }'),
                                ],
                                'pluginEvents' => [
                                    "changeDate" => "function(e) { "
                                    . "}",
                                ]
                            ])->label('Onboard Date');
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
    </div> 
</div>

<?php
//$js = <<<JS
//    
//$('#add-score-form').on('beforeSubmit', function (e) {
//    var form = $(this);
//    var submit = form.find(':submit');
//    submit.html('<span class="fa fa-spin fa-spinner"></span> Wait...');
//    submit.prop('disabled', true);
//
//});       
//JS;
//$this->registerJs($js);
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











