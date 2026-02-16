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
                'method' => 'get',
    ]);
    ?>

    <?php
    echo $form->field($model, 'district_code')->widget(Select2::classname(), [
        'data' => $model->district_option,
        'options' => ['placeholder' => 'Select District', 'style' => 'width:200px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('District');
    ?>
    <?php
    echo $form->field($model, 'block_code')->widget(Select2::classname(), [
        'data' => $model->block_option,
        'options' => ['placeholder' => 'Select Block', 'style' => 'width:200px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Block');
    ?>
    <?php
    echo $form->field($model, 'gram_panchayat_code')->widget(Select2::classname(), [
        'data' => $model->gp_option,
        'options' => ['placeholder' => 'Select GP', 'style' => 'width:200px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('GP');
    ?>

    <?php
//    echo $form->field($model, 'custom_member_column')->widget(Select2::classname(), [
//        'data' => [1 => 'No', 2 => 'Yes'],
//        'options' => ['placeholder' => 'Select Member', 'style' => 'width:200px'],
//        'pluginOptions' => [
//            'allowClear' => true
//        ],
//    ])->label('SHG Member (when applied)');
    ?>


    
        <?php
        echo $form->field($model, 'pvr_status')->widget(Select2::classname(), [
            'data' => [1 => 'Yes', 0 => 'No'],
            'options' => ['placeholder' => 'Select PVR Upload Status', 'style' => 'width:250px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('PVR Upload Status');
        ?>
        <?php
        echo $form->field($model, 'assign_shg_status')->widget(Select2::classname(), [
            'data' => [1 => 'Yes', 0 => 'No'],
            'options' => ['placeholder' => 'Select SHG Assigned Status', 'style' => 'width:250px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('BC-SHG Mapped');
        ?>
        <?php
        echo $form->field($model, 'bc_bank')->widget(Select2::classname(), [
            'data' => [0 => 'Not filled', 4 => 'Total filled', 1 => 'Not verified', 2 => 'Verified', 3 => 'Return'],
            'options' => ['placeholder' => 'Select BC Bank Detail', 'style' => 'width:200px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('BC Bank Detail');
        ?>
        <?php
        echo $form->field($model, 'shg_bank')->widget(Select2::classname(), [
            'data' => [0 => 'Not filled', 4 => 'Total filled', 1 => 'Not verified', 2 => 'Verified', 3 => 'Return'],
            'options' => ['placeholder' => 'Select BC SHG Bank Detail', 'style' => 'width:200px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('BC SHG Bank Detail');
        ?>
        <?php
        echo $form->field($model, 'pfms_maped_status')->widget(Select2::classname(), [
            'data' => [0 => 'No', 1 => 'Yes'],
            'options' => ['placeholder' => 'Select PFMS Maped', 'style' => 'width:200px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('PFMS Maped');
        ?>
        <?php
        echo $form->field($model, 'bc_shg_funds_status')->widget(Select2::classname(), [
            'data' => [0 => 'No', 1 => 'Yes'],
            'options' => ['placeholder' => 'Select BC SHG funds received ', 'style' => 'width:200px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('BC SHG funds received');
        ?>
        <?php
        echo $form->field($model, 'pan_card_status')->widget(Select2::classname(), [
            'data' => [0 => 'No', 1 => 'Yes'],
            'options' => ['placeholder' => 'Select PAN Card Status', 'style' => 'width:200px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('PAN Card Status');
        ?>
        <?php
        echo $form->field($model, 'pan_photo_upload')->widget(Select2::classname(), [
            'data' => [0 => 'No', 1 => 'Yes'],
            'options' => ['placeholder' => 'Select PAN Photo upload status', 'style' => 'width:200px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('PAN Photo upload status');
        ?>
        <?php
        echo $form->field($model, 'handheld_machine_status')->widget(Select2::classname(), [
            'data' => [0 => 'No', 1 => 'Yes'],
            'options' => ['placeholder' => 'Select Handheld Machine provided', 'style' => 'width:200px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Handheld Machine provided');
        ?>



    <?= Html::submitButton('Search', ['class' => 'btn btn-sm btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'margin-top:10px;width:75px;margin-left:10px']) ?>
    <?php Html::button('Reset', ['class' => 'btn btn-sm btn-primary reset', 'style' => 'margin-top:10px;width:75px;margin-left:10px', 'id' => 'reloads']) ?>


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

