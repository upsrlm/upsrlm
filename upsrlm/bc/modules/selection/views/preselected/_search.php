<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use bc\modules\selection\models\base\GenralModel;
use common\models\User;
use common\models\master\MasterRole;
?>
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
            'bsVersion' => '4.x',
            'data' => $model->district_option,
            'options' => ['placeholder' => 'District', 'style' => 'width:250px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
        echo $form->field($model, 'block_code')->label('Block')->widget(Select2::classname(), [
            'bsVersion' => '4.x',
            'data' => $model->block_option,
            'options' => ['placeholder' => 'Block', 'style' => 'width:250px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
        echo $form->field($model, 'gram_panchayat_code')->widget(Select2::classname(), [
            'bsVersion' => '4.x',
            'data' => $model->gp_option,
            'options' => ['placeholder' => 'GP', 'style' => 'width:250px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">

        <?php
        echo $form->field($model, 'village_code')->widget(Select2::classname(), [
            'bsVersion' => '4.x',
            'data' => $model->village_option,
            'options' => ['placeholder' => 'Village', 'style' => 'width:250px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>
    <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN])) { ?>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'age_group')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => $model->age_group_option1,
                'options' => ['placeholder' => 'Age Group', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'training_status')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => [0 => 'Default', 1 => 'Agree', '2' => 'Registered(Assign Batch)', '3' => 'Certified', '4' => 'Not Certified', '5' => 'ineligible', '6' => 'Absent', '-2' => 'Unwilling', '32' => 'Certified Unwilling'],
                'options' => ['placeholder' => 'Training Status', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Training Status');
            ?>
        </div>
    <?php } ?>
    <?php if (!in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS,MasterRole::ROLE_CORPORATE_BCS, MasterRole::ROLE_VIEWER])) { ?>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'call1')->label('Call by YP Status')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => [1 => 'Called & Informed', 2 => 'Not Called'],
                'options' => ['placeholder' => 'Select Status', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'col_send_temp')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => $model->view_temp_option,
                'options' => ['placeholder' => 'Notification Sent', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Notification Sent');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'col_view_temp')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => $model->view_temp_option,
                'options' => ['placeholder' => 'Notification Viewed', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Notification Viewed');
            ?>
        </div>

    <?php } ?>
    <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) { ?>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'bc_photo_status')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => $model->bc_photo_option,
                'options' => ['placeholder' => 'Photo Status', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>

    <?php } ?>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
        echo $form->field($model, 'selection_by')->widget(Select2::classname(), [
            'bsVersion' => '4.x',
            'data' => [1 => 'Round 1', 2 => 'Round 2', 3 => 'Round 3', 4 => 'Round 4', 5 => 'Round 5', 6 => 'Round 6', 7 => 'Round 7', 8 => 'Round 8', 9 => 'Round 9', 10 => 'Round 10', 11 => 'Round 11', 12 => 'Round 12', 13 => 'Round 13', 14 => 'Round 14', 15 => 'Round 15'],
            'options' => ['placeholder' => 'Selection Round', 'style' => 'width:250px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Urban');
        ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
        echo $form->field($model, 'urban_shg')->widget(Select2::classname(), [
            'bsVersion' => '4.x',
            'data' => [0 => 'No', 1 => 'Yes'],
            'options' => ['placeholder' => 'Convert to Urban', 'style' => 'width:250px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Urban');
        ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;']) ?>
        <?= Html::button('Reset', ['class' => 'btn  btn-primary reset', 'style' => 'padding:7px 20px;margin-left:10px', 'id' => 'reloads']) ?>
    </div>
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