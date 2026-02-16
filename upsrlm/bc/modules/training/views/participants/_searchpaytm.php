<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use common\models\master\MasterRole;
use yii\bootstrap4\ButtonDropdown;

$request = explode('?', Yii::$app->request->url);
$request_url = rtrim($request[0], '/');
//echo $request_url;
?>
<div class="srlm-search">
    <?php
    $form = ActiveForm::begin([
//                'layout' => 'inline',
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
            echo $form->field($model, 'district_code')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => $model->district_option,
                'options' => ['placeholder' => 'District', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('District');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'block_code')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => $model->block_option,
                'options' => ['placeholder' => 'Block', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Block');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'gram_panchayat_code')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => $model->gp_option,
                'options' => ['placeholder' => 'GP', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('GP');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'nretp')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => [1 => 'Yes', 0 => 'No'],
                'options' => ['placeholder' => 'NRETP Block', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('NRETP Block');
            ?>
        </div>

        <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) { ?>
            <div class="col-xl-2 col-md-4 mb-2">
                <?php
                echo $form->field($model, 'custom_education')->widget(Select2::classname(), [
                    'bsVersion' => '4.x',
                    'data' => [1 => '10th Pass', 2 => '10th not pass'],
                    'options' => ['placeholder' => 'Education', 'style' => 'width:250px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Education');
                ?>
            </div>
        <?php } ?>

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
            echo $form->field($model, 'bankid')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => [1 => 'Yes', 0 => 'No'],
                'options' => ['placeholder' => 'Bank Id Map', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Bank Id Map');
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
        <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) { ?>
            <div class="col-xl-2 col-md-4 mb-2">
                <?php
                echo $form->field($model, 'bc_shg_bank')->widget(Select2::classname(), [
                    'bsVersion' => '4.x',
                    'data' => [1 => 'Not Verified', 2 => 'Not Filled', 3 => 'Verified', 4 => 'Return'],
                    'options' => ['placeholder' => 'Select Bank Detail status', 'style' => 'width:200px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Bank Detail');
                ?>
            </div>
            <div class="col-xl-2 col-md-4 mb-2">
                <?php
                echo $form->field($model, 'pfms_maped_status')->widget(Select2::classname(), [
                    'bsVersion' => '4.x',
                    'data' => [0 => 'No', 1 => 'Yes'],
                    'options' => ['placeholder' => 'Select PFMS Maped', 'style' => 'width:200px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('PFMS Mapped');
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
                echo $form->field($model, 'handheld_machine_status')->widget(Select2::classname(), [
                    'bsVersion' => '4.x',
                    'data' => [0 => 'No', 1 => 'Yes'],
                    'options' => ['placeholder' => 'Select Handheld Machine provided', 'style' => 'width:200px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Handheld Machine provided');
                ?>
            </div>
            <div class="col-xl-2 col-md-4 mb-2">
                <?php
                echo $form->field($model, 'pan_photo_upload')->widget(Select2::classname(), [
                    'bsVersion' => '4.x',
                    'data' => [0 => 'No', 1 => 'Yes'],
                    'options' => ['placeholder' => 'Select PAN Photo upload status', 'style' => 'width:200px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('PAN Photo upload status');
                ?>
            </div>


        <?php } ?>
        <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_MD])) { ?>
            <div class="col-xl-2 col-md-4 mb-2">
                <?php
                echo $form->field($model, 'pvr_status')->widget(Select2::classname(), [
                    'bsVersion' => '4.x',
                    'data' => [1 => 'Yes', 0 => 'No'],
                    'options' => ['placeholder' => 'Select PVR Upload Status', 'style' => 'width:250px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('PVR Upload Status');
                ?>
            </div>
            <div class="col-xl-2 col-md-4 mb-2">
                <?php
                echo $form->field($model, 'bc_shg_map')->widget(Select2::classname(), [
                    'bsVersion' => '4.x',
                    'data' => [1 => 'Completed', 2 => 'Not Filled', 3 => 'Not Assigned'],
                    'options' => ['placeholder' => 'Select BC-SHG Mapped Status', 'style' => 'width:250px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('BC-SHG Mapped');
                ?>
            </div>
            <div class="col-xl-2 col-md-4 mb-2">
                <?php
                echo $form->field($model, 'bc_shg_bank')->widget(Select2::classname(), [
                    'bsVersion' => '4.x',
                    'data' => [1 => 'Not Verified', 2 => 'Not Filled', 3 => 'Verified', 4 => 'Return'],
                    'options' => ['placeholder' => 'Select Bank Detail status', 'style' => 'width:200px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Bank Detail');
                ?>
            </div>
            <div class="col-xl-2 col-md-4 mb-2">
                <?php
                echo $form->field($model, 'pfms_maped_status')->widget(Select2::classname(), [
                    'bsVersion' => '4.x',
                    'data' => [0 => 'No', 1 => 'Yes'],
                    'options' => ['placeholder' => 'Select SHG PFMS Maped', 'style' => 'width:200px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('SHG PFMS Maped');
                ?>
            </div>
            <div class="col-xl-2 col-md-4 mb-2">
                <?php
                echo $form->field($model, 'bc_beneficiaries_map')->widget(Select2::classname(), [
                    'bsVersion' => '4.x',
                    'data' => [0 => 'No', 1 => 'Yes'],
                    'options' => ['placeholder' => 'Select BC PFMS Maped', 'style' => 'width:200px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('BC PFMS Maped');
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
                echo $form->field($model, 'pan_photo_upload')->widget(Select2::classname(), [
                    'bsVersion' => '4.x',
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
                echo $form->field($model, 'handheld_machine_status')->widget(Select2::classname(), [
                    'bsVersion' => '4.x',
                    'data' => [0 => 'No', 1 => 'Yes'],
                    'options' => ['placeholder' => 'Select Handheld Machine provided', 'style' => 'width:200px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Handheld Machine provided');
                ?>
            </div>
        <?php } ?>
        <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DC_NRLM])) { ?>
            <div class="col-xl-2 col-md-4 mb-2">
                <?php
                echo $form->field($model, 'bc_shg_bank')->widget(Select2::classname(), [
                    'bsVersion' => '4.x',
                    'data' => [1 => 'Not Verified', 2 => 'Not Filled', 3 => 'Verified', 4 => 'Return'],
                    'options' => ['placeholder' => 'Select Bank Detail status', 'style' => 'width:200px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Bank Detail');
                ?>
            </div>
            <div class="col-xl-2 col-md-4 mb-2">
                <?php
                echo $form->field($model, 'pfms_maped_status')->widget(Select2::classname(), [
                    'bsVersion' => '4.x',
                    'data' => [0 => 'No', 1 => 'Yes'],
                    'options' => ['placeholder' => 'Select SHG PFMS Maped', 'style' => 'width:200px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('SHG PFMS Maped');
                ?>
            </div>
            <div class="col-xl-2 col-md-4 mb-2">
                <?php
                echo $form->field($model, 'bc_beneficiaries_map')->widget(Select2::classname(), [
                    'bsVersion' => '4.x',
                    'data' => [0 => 'No', 1 => 'Yes'],
                    'options' => ['placeholder' => 'Select BC PFMS Maped', 'style' => 'width:200px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('BC PFMS Maped');
                ?>
            </div>
            <div class="col-xl-2 col-md-4 mb-2">
                <?php
                echo $form->field($model, 'bc_shg_map')->widget(Select2::classname(), [
                    'bsVersion' => '4.x',
                    'data' => [1 => 'Assigned', 3 => 'Not Assigned'],
                    'options' => ['placeholder' => 'Select BC-SHG Mapped Status', 'style' => 'width:250px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('BC-SHG Mapped');
                ?>
            </div>
        <?php } ?>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'bc_support_funds_received')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => [0 => 'No', 1 => 'Yes'],
                'options' => ['placeholder' => 'Select Acknowledge support funds received', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Acknowledge support funds received');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'bc_handheld_machine_recived')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => [0 => 'No', 1 => 'Yes'],
                'options' => ['placeholder' => 'Select Acknowledge handheld machine received', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Acknowledge handheld machine received');
            ?>
        </div>

        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'ptm_device')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => $model->ptm_device_option,
                'options' => ['placeholder' => 'Select Device', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Device');
            ?>
        </div>
         <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'bc_operational')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => [0 => 'No', 1 => 'Yes'],
                'options' => ['placeholder' => 'Select Operational', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Operational');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'pendency')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => $model->pendency_option,
                'options' => ['placeholder' => 'Pendency', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Pendency');
            ?>
        </div>
        
        <div class="col-xl-6 col-md-4 mb-2">
            <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;']) ?>
            <?php Html::button('Reset', ['class' => 'btn  btn-primary reset', 'style' => 'padding:7px 20px;margin-left:10px', 'id' => 'reloads']) ?>
           
        </div>

    </div>

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
    width: 150px !important;
}
cs;
$this->registerCss($css);
?>