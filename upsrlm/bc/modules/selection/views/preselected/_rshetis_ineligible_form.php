<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;

$this->title = 'Capturing Ineligible reason of candidate : ' . $model->bc_model->name;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                <div class="panel-toolbar">

                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-lg-6">

                            <div><?= $model->bc_model->aadhar_front_photo != null ? '<span class="profile-picture">
                                        <img style="height:500px" src="' . $model->bc_model->aadhar_front_photo_url . '" data-src="' . $model->bc_model->aadhar_front_photo_url . '"  class="lozad img-fluid img-responsive" title="aadhar_front_photo"/>
                                        </span> ' : '-' ?></div>
                            <div>Candidate Age : <?= $model->bc_model->age ?></div>

                        </div>
                        <div class="col-lg-6">
                            <div> <?= $model->bc_model->aadhar_back_photo != null ? '<span class="profile-picture">
                                        <img style="height:500px" src="' . $model->bc_model->aadhar_back_photo_url . '"  data-src="' . $model->bc_model->aadhar_back_photo_url . '"  class="lozad img-fluid img-responsive" title="aadhar back photo"/>
                                        </span> ' : '' ?></div>
                            <div>Candidate Address : <?= str_replace('<br/>', ' , ', $model->bc_model->fulladdress) ?></div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-lg-12" style="margin-top: 10px">

                            <?php
                            $form = ActiveForm::begin([
                                        'enableClientValidation' => false,
                                        'enableAjaxValidation' => TRUE,
                                        'options' => ['id' => 'ineligible', 'enctype' => 'multipart/form-data'],
                            ]);
                            ?>

                            <?= $form->field($model, 'ineligible_reason')->checkboxList($model->ineligible_reason_option) ?>


                            <div class="form-group">
                                <div class="col-lg-offset-5 col-lg-11">
                                    <?= Html::submitButton('Submit', ['id' => 'buttonsave', 'class' => 'btn btn-info', 'value' => 'save', 'name' => 'save']) ?>

                                </div>
                            </div>
                        </div> 

                    </div>
                    <?php ActiveForm::end(); ?>
                </div>

            </div>
        </div> 
    </div> 
</div>
<?php
$js = <<<JS
    
$('#ineligible').on('beforeSubmit', function (e) {
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
