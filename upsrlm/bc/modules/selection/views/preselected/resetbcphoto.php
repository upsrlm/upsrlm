<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\widgets\DetailView;

$this->title = 'Update Mobile No';
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">

            <div class="panel-container show">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-lg-4">

                            <div><?= $model->bc_model->user->profile_photo != null ? '<span class="profile-picture">
                                        <img style="height:400px" src="' . $model->bc_model->profile_photo_url . '" data-src="' . $model->bc_model->profile_photo_url . '"  class="lozad img-fluid" title="profile_photo"/>
                                        </span> ' : '-' ?></div>


                        </div>
                        <div class="col-lg-4">

                            <div><?= $model->bc_model->user->aadhar_front_photo != null ? '<span class="profile-picture">
                                        <img style="height:400px" src="' . $model->bc_model->aadhar_front_photo_url . '" data-src="' . $model->bc_model->aadhar_front_photo_url . '"  class="lozad img-fluid" title="aadhar_front_photo"/>
                                        </span> ' : '-' ?></div>


                        </div>
                        <div class="col-lg-4">
                            <div> <?= $model->bc_model->user->aadhar_back_photo != null ? '<span class="profile-picture">
                                        <img style="height:400px" src="' . $model->bc_model->aadhar_back_photo_url . '"  data-src="' . $model->bc_model->aadhar_back_photo_url . '"  class="lozad img-fluid" title="aadhar back photo"/>
                                        </span> ' : '' ?></div>

                        </div>
                    </div>
                    <?php
                    $form = ActiveForm::begin([
                                'enableClientValidation' => FALSE,
                                'enableAjaxValidation' => TRUE,
                                'options' => ['id' => 'add-score-form', 'enctype' => 'multipart/form-data'],
                    ]);
                    ?>

                    <div class="col-md-12 mt-3">

                        <?=
                        $form->field($model, 'bc_photo_status', [
                            'template' => "<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
                        ])->checkbox([
//                'checked' => false, 'required' => true,
                            'label' => "Reset profile photo of BC"
                        ])->label();
                        ?>

                    </div>
                    <div class="col-md-12">
                        <div class="text-center">
                            <?= Html::submitButton('<i class="fal fa-save"></i> Save', ['class' => 'btn btn-success']) ?>
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











