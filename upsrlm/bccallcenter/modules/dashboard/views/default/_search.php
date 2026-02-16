<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
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
<div class="srlm-search">
    <?php
    $form = ActiveForm::begin([
                'layout' => 'inline',
                'options' => [
                    'class' => 'form-inline',
                    'data-pjax' => true,
                    'id' => 'Searchform'
                ],
                'method' => 'POST',
    ]);
    ?>
    <div class="row">
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'otp_mobile_no', [
                'template' => '{label}<div class="col-xs-12">{input}</div>',
            ])->textInput(['placeholder' => 'Mobile Number'])
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'division_code')->widget(Select2::classname(), [
                'data' => $model->division_option,
                'options' => ['placeholder' => 'Select Division', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Division');
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
            echo $form->field($model, 'assign_shg_status')->widget(Select2::classname(), [
                'data' => [1 => 'Yes', 0 => 'No'],
                'options' => ['placeholder' => 'Select SHG Assigned Status', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('BC-SHG Mapped');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">


            <?php
            echo $form->field($model, 'bc_bank')->widget(Select2::classname(), [
                'data' => [0 => 'Not filled', 4 => 'Total filled', 1 => 'Not verified', 2 => 'Verified', 3 => 'Return'],
                'options' => ['placeholder' => 'Select BC Bank Detail', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('BC Bank Detail');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">

            <?php
            echo $form->field($model, 'shg_bank')->widget(Select2::classname(), [
                'data' => [0 => 'Not filled', 4 => 'Total filled', 1 => 'Not verified', 2 => 'Verified', 3 => 'Return'],
                'options' => ['placeholder' => 'Select BC SHG Bank Detail', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('BC SHG Bank Detail');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'pan_photo_upload')->widget(Select2::classname(), [
                'data' => [0 => 'No', 1 => 'Yes'],
                'options' => ['placeholder' => 'Select PAN Photo upload status', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('PAN Photo upload status');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'iibf_photo_status')->widget(Select2::classname(), [
                'data' => [1 => 'Yes', 0 => 'No'],
                'options' => ['placeholder' => 'IIBF Photo Status', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('IIBF Photo');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'bc_shg_funds_status')->widget(Select2::classname(), [
                'data' => [0 => 'No', 1 => 'Yes'],
                'options' => ['placeholder' => 'BC SHG funds transfer', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('BC SHG funds transfer');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'bc_support_funds_received')->widget(Select2::classname(), [
                'data' => [0 => 'No', 1 => 'Yes'],
                'options' => ['placeholder' => 'Received BC-support fund?', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Acknowledge support funds received');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'handheld_machine_status')->widget(Select2::classname(), [
                'data' => [0 => 'No', 1 => 'Yes'],
                'options' => ['placeholder' => 'Handheld Machine provided', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Handheld Machine provided');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">

            <?php
            echo $form->field($model, 'bc_handheld_machine_recived')->widget(Select2::classname(), [
                'data' => [0 => 'No', 1 => 'Yes'],
                'options' => ['placeholder' => 'Got Hh machine?', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Acknowledge handheld machine received');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'bc_photo_status')->widget(Select2::classname(), [
                'data' => $model->bc_photo_option,
                'options' => ['placeholder' => 'Select Photo Status', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'pin_used')->widget(Select2::classname(), [
                'data' => [0 => 'No', 1 => 'Yes'],
                'options' => ['placeholder' => 'Got PIN?', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Got PIN');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'blocked_bc')->widget(Select2::classname(), [
                'data' => [0 => 'No', 1 => 'Yes'],
                'options' => ['placeholder' => 'Blocked', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Blocked');
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
            echo $form->field($model, 'shg_confirm_funds_return')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => [1 => 'Yes', 2 => 'No'],
                'options' => ['placeholder' => 'Loan repaid', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Loan repaid');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'rishta_access_page')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => $model->rishta_access_option,
                'options' => ['placeholder' => 'Rishta App', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?= Html::submitButton('Search', ['class' => 'btn btn-sm btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;']) ?>

            <?php if (isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SUPPORT_UNIT]) and $model->division_code) { ?>
                <?php Html::button('<i class="glyphicon glyphicon-download-alt"></i> Download Certified BC CSV', ['class' => 'btn btn-primary btn-sm', 'style' => 'margin-left:10px;padding:7px 20px', 'id' => 'downloadbcs', 'name' => 'downloadbcs', 'value' => 'downloadbcs']) ?>
            <?php } ?>
        </div>
    </div>


    <?php
//    echo $form->field($model, 'urban_shg')->widget(Select2::classname(), [
//        'data' => [0 => 'No', 1 => 'Yes'],
//        'options' => ['placeholder' => 'Convert to Urban', 'style' => 'width:250px'],
//        'pluginOptions' => [
//            'allowClear' => true
//        ],
//    ])->label('Urban');
    ?>


    <?php ActiveForm::end(); ?>
</div>
<?php
$js = <<<JS
$('#reloads').click(function() {
    location.reload();
});        
JS;
$this->registerJs($js);

$css = <<<cs
 .select2-selection__rendered {
    width: 200px !important;
}
cs;
$this->registerCss($css);
?>