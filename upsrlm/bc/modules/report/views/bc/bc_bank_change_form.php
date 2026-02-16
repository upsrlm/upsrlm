<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\widgets\DetailView;

$this->title = 'BC Bank Account Bank Change';
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                <div class="panel-toolbar">
                </div>
            </div>
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
                        <div class="col-lg-12">
                            <?php
                            echo $form->field($model, 'bank_id')->widget(Select2::classname(), [
                                'bsVersion' => '4.x',
                                'data' => $model->bank_option,
                                'options' => ['placeholder' => 'Select Bank', 'style' => 'width:250px'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div> 
                        <div class="col-lg-12">
                            <?= $model->bc_model->passbook_photo != null ? '<span class="profile-picture">
                                        <img width="475px" src="' . $model->bc_model->passbook_photo_url . '" data-src="' . $model->bc_model->passbook_photo_url . '"  class="img-thumbnail lozad" title="Passbook Photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?>
                            <div> बैंक अकाउंट नम्बर : <?= $model->bc_model->bank_account_no_of_the_bc ?></div>
                            <div> बैंक अकाउंट का IFSC कोड : <?= $model->bc_model->branch_code_or_ifsc ?></div>
                        </div>
                    </div>
                    <div class="col-md-12 pt-2">
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











