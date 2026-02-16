<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use \yii\widgets\Pjax;
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
echo $form->field($model, 'reading_skills')->label('Education')->widget(Select2::classname(), [
    'bsVersion' => '4.x',
    'data' => [1 => 'Class 10 pass', 2 => 'Class 10 pass and proficient in group function'],
    'options' => ['placeholder' => 'Education', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>

    </div>
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
        echo $form->field($model, 'operational')->widget(Select2::classname(), [
            'bsVersion' => '4.x',
            'data' => [1 => 'Yes', 0 => 'No'],
            'options' => ['placeholder' => 'Operational', 'style' => 'width:250px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Bank Id Map');
        ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
        echo $form->field($model, 'blocked')->widget(Select2::classname(), [
            'bsVersion' => '4.x',
            'data' => $model->blocked_option,
            'options' => ['placeholder' => 'Block reason', 'style' => 'width:250px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
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
        <?= Html::button('Reset', ['class' => 'btn  btn-primary reset', 'style' => 'adding:7px 20px;margin-left:10px', 'id' => 'reloads']) ?>
    </div>
</div>



        <?php
//echo $form->field($model, 'age_group')->widget(Select2::classname(), [
//    'bsVersion' => '4.x',
//    'data' => $model->age_group_option1,
//    'options' => ['placeholder' => 'Age Group', 'style' => 'width:250px'],
//    'pluginOptions' => [
//        'allowClear' => true
//    ],
//]);
        ?>

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