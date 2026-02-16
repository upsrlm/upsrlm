<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use \yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use common\models\base\GenralModel;
use common\models\User;
use common\models\master\MasterRole;

$request = explode('?', Yii::$app->request->url);
$request_url = rtrim($request[0], '/');
//echo $request_url;
?>
<!--<div class="col-lg-12">-->
<div class="row">
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
        echo $form->field($model, 'aspirational')->widget(Select2::classname(), [
            'data' => ['1' => 'Yes', '0' => 'No'],
            'options' => ['placeholder' => 'Aspirational Block', 'style' => 'width:250px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>

    <div class="col-xl-2 col-md-4 mb-2">
        <?php
        echo $form->field($model, 'district_code')->widget(Select2::classname(), [
            'data' => $model->district_option,
            'options' => ['placeholder' => 'Select District', 'style' => 'width:200px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('District');
        ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
        echo $form->field($model, 'block_code')->widget(Select2::classname(), [
            'data' => $model->block_option,
            'options' => ['placeholder' => 'Select Block', 'style' => 'width:200px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Block');
        ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
        echo $form->field($model, 'gram_panchayat_code')->widget(Select2::classname(), [
            'data' => $model->gp_option,
            'options' => ['placeholder' => 'Select GP', 'style' => 'width:200px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('GP');
        ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
        echo $form->field($model, 'bc_shg_funds_status')->widget(Select2::classname(), [
            'bsVersion' => '4.x',
            'data' => [0 => 'No', 1 => 'Yes'],
            'options' => ['placeholder' => 'Select BC SHG funds transfer', 'style' => 'width:200px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('BC SHG funds transfer');
        ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
        echo $form->field($model, 'onboarding')->widget(Select2::classname(), [
            'bsVersion' => '4.x',
            'data' => [1 => 'Yes', 0 => 'No'],
            'options' => ['placeholder' => 'Onboarding Status', 'style' => 'width:250px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Onboarding');
        ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">

        <?php
        echo $form->field($model, 'bc_operational')->widget(Select2::classname(), [
            'bsVersion' => '4.x',
            'data' => [1 => 'Yes', 0 => 'No'],
            'options' => ['placeholder' => 'BC Operational', 'style' => 'width:250px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('BC Operational');
        ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
        echo $form->field($model, 'bc_payment_count')->widget(Select2::classname(), [
            'bsVersion' => '4.x',
            'data' => [0 => '0', 1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6'],
            'options' => ['placeholder' => 'Select Honorarium', 'style' => 'width:200px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Honorarium');
        ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
        echo $form->field($model, 'bc_unwilling_bc')->widget(Select2::classname(), [
            'bsVersion' => '4.x',
            'data' => [0 => 'No Action', 1 => 'Unwilling', 2 => 'Not Unwilling'],
            'options' => ['placeholder' => 'BC Unwilling Status', 'style' => 'width:200px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('BC Unwilling Status');
        ?>
    </div>
    <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD])) { ?>
        <div class="col-xl-2 col-md-4 mb-2">

            <?php
            echo $form->field($model, 'master_partner_bank_id')->widget(Select2::classname(), [
                'data' => $model->bc_partner_bank_option,
                'options' => ['placeholder' => 'Select Partner agencies', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>

        </div>
    <?php } ?>
    <div class="col-xl-2 col-md-4 mb-2">
        <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;']) ?>
    </div>

</div>






<?php
$css = <<<cs
 .select2-selection__rendered {
    width: 250px !important;
}
cs;
$this->registerCss($css);
?>