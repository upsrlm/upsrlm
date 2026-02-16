<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

$this->title = 'Blocked BC ' . $model->bc_model->name;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title?>
                </h2>
                
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <?php $form = ActiveForm::begin(['id' => 'form-bc-blocked', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
                    <div class="row">

                        <div class="col-lg-12">
                            <?php
                            echo $form->field($model, 'blocked')->widget(Select2::classname(), [
                                'bsVersion' => '4.x',                         
                                'data' => $model->blocked_option,
                                'options' => ['placeholder' => 'Select Blocked Reason', 'style' => 'width:250px'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label('Select Blocked Reason');
                            ?>

                        </div>
                    </div>
                    <div class="clearfix pt-3"></div>
                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>     
        </div>
    </div>     
</div>        
<?php
$js = <<<JS
    
$('#form-bc-blocked').on('beforeSubmit', function (e) {
    var form = $(this);
    var submit = form.find(':submit');
    submit.html('<span class="fal fa-spin fa-spinner"></span> Wait...');
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
