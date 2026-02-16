<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\widgets\DetailView;

$this->title = 'Update Age';
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">

            <div class="panel-container show">
                <div class="panel-content">
                    <?php
                    $form = ActiveForm::begin([
                                'enableClientValidation' => FALSE,
                                'enableAjaxValidation' => TRUE,
                                'options' => ['id' => 'add-score-form', 'enctype' => 'multipart/form-data'],
                    ]);
                    ?>
                    <div class="row">

                        <div class="col-lg-6">
                            <?= $form->field($model, 'age')->textInput(['size' => 100]); ?>
                            <div class="col-md-12">
                                <div class="text-center">
                                    <?= Html::submitButton('<i class="fal fa-save"></i> Save', ['class' => 'btn btn-success']) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <?= $model->bc_model->user->aadhar_front_photo != null ? '<span class="profile-picture">
                                        <img  src="' . $model->bc_model->aadhar_front_photo_url . '" data-src="' . $model->bc_model->aadhar_front_photo_url . '"  class="lozad img-responsive img-fluid" title="aadhar_front_photo"/>
                                        </span> ' : '-' ?>
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











