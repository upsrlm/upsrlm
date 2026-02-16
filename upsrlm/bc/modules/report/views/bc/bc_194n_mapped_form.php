<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\widgets\DetailView;
use common\models\master\MasterRole;

$this->title = 'BC settlement a/c tagged for 194N ';
?>
<?php if ($model->bc_model->bc_settlement_ac_194n == 0 and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_RBI])) { ?>
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
                        <div class="col-md-12 pt-3">

                            <?=
                            $form->field($model, 'bc_settlement_ac_194n', [
                                'template' => "<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
                            ])->checkbox([
//                'checked' => false, 'required' => true,
                                'label' => "BC settlement a/c tagged for 194N"
                            ])->label();
                            ?>

                        </div>
                        <div class="col-md-12 pt-3">
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
<?php } ?>
<div class="col-lg-12">
    <?php
    echo $this->render('bc_view', [
        'model' => $model->bc_model
    ]);
    ?></div>
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











