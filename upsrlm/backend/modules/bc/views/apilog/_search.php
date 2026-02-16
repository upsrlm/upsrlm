<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\ApiLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="col-sm-12">
    <?php
    $form = ActiveForm::begin([
                'options' => [
                    'class' => 'form-inline',
                    'id' => 'Searchform',
                    'data-pjax' => true,
                    'autocomplete' => 'off',
                ],
                'method' => 'get',
    ]);
    ?>
<div class="row">
<div class="col-xl-2 col-md-4 mb-2">
<?php
    echo $form->field($model, 'srlm_bc_selection_app_id')->textInput(['maxlength' => true, 'placeholder' => 'Search By App', 'class' => 'form-control form-control-sm'])->label(false);
    ?>
</div>
<?php
    $form->field($model, 'version_no')->dropDownList([
        '2.65' => '2.65',
        '2.62' => '2.62',
        '2.61' => '2.61',
        '2.60' => '2.60',
        '2.59' => '2.59',
        '2.58' => '2.58',
        '2.56' => '2.56',
        '2.55' => '2.55',
            ], ['prompt' => 'Select App Version'])->label(false)
    ?>
<div class="col-xl-2 col-md-4 mb-2">
<?=
    $form->field($model, 'http_response_code')->dropDownList([
        200 => '200 OK',
        302 => '302 Redirection',
        400 => '400 Bad Request',
        403 => '403 Forbidden',
        404 => '404 not found',
        409 => '409 conflict in the request',
        500 => '500 Internal Server Error'
            ], ['prompt' => 'Select Response Code'])->label(false)
    ?>
</div>
<div class="col-xl-3 col-md-4 mb-2">
<?=
    $form->field($model, 'request_url')->dropDownList(['bcselection/user/phase' => 'bcselection/user/phase',
        'bcselection/user/formsave' => 'bcselection/user/formsave',
        'bcselection/user/mobilepin' => 'bcselection/user/mobilepin',
        'bcselection/user/getshg' => 'bcselection/user/login',
        'bcselection/user/getdetail' => 'bcselection/user/getdetail',
        'bcselection/user/getgp' => 'bcselection/user/getgp',
        'bcselection/user/getshg' => 'bcselection/user/getshg',
        'bcselection/user/uploadphoto' => 'bcselection/user/uploadphoto',
        'bcselection/user/updateshg' => 'bcselection/user/updateshg',
        'bcselection/user/acknowledgehandheldmachine' => 'bcselection/user/acknowledgehandheldmachine',
        'bcselection/user/acknowledgesupportfunds' => 'bcselection/user/acknowledgesupportfunds',
        'bcselection/user/bcbankaccountsave' => 'bcselection/user/bcbankaccountsave',
        'bcselection/user/bcshgbankaccountsave' => 'bcselection/user/bcshgbankaccountsave',
        'bcselection/user/coronafeedback' => 'bcselection/user/coronafeedback',
        'bcselection/user/getphoto' => 'bcselection/user/getphoto',
        'bcselection/user/notificationacknowledge' => 'bcselection/user/notificationacknowledge',
        'bcselection/user/trainingfeedback' => 'bcselection/user/trainingfeedback',
        'bcselection/user/uploadpan' => 'bcselection/user/uploadpan',
        'bcselection/user/veiwweb' => 'bcselection/user/veiwweb',
        'bcselection/' => 'bcselection/'], ['prompt' => 'Select api url'])->label(false)
    ?>
</div>
<div class="col-xl-2 col-md-4 mb-2">
<?= Html::submitButton('Search', ['class' => 'btn btn-primary btn-sm','style' => 'padding:7px 20px;']) ?>
</div>
</div>


    <?php ActiveForm::end(); ?>

</div>




