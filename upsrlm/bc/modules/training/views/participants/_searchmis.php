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
    <!-- <div class="col-xl-2 col-md-4 mb-2">

    <?php
    $form->field($model, 'rsetis_center_id')->widget(Select2::classname(), [
        'bsVersion' => '4.x',
        'data' => $model->center_option,
        'options' => ['placeholder' => 'Venue', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Venue');
    ?>
    </div> -->

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

    <!-- <div class="col-xl-2 col-md-4 mb-2">
    <?php
    $form->field($model, 'rsetis_center_training_id')->widget(Select2::classname(), [
        'bsVersion' => '4.x',
        'data' => $model->training_option,
        'options' => ['placeholder' => 'Training', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Training');
    ?>
    </div> -->
    <div class="col-xl-2 col-md-4 mb-2">
        <?php //if (!in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT,MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {?>
        <?php
        echo $form->field($model, 'custum_training_status')->widget(Select2::classname(), [
            'bsVersion' => '4.x',
            'data' => $model->training_status_option,
            'options' => ['placeholder' => 'Training Status', 'style' => 'width:250px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Training Status');
        ?>
        <?php //} ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
        echo $form->field($model, 'iibf_photo_status')->widget(Select2::classname(), [
            'bsVersion' => '4.x',
            'data' => [1 => 'Yes', 0 => 'No'],
            'options' => ['placeholder' => 'IIBF Photo', 'style' => 'width:250px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('IIBF Photo');
        ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
        echo $form->field($model, 'pvr_status')->widget(Select2::classname(), [
            'bsVersion' => '4.x',
            'data' => [1 => 'Yes', 0 => 'No'],
            'options' => ['placeholder' => 'PVR Upload Status', 'style' => 'width:250px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('PVR Upload Status');
        ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
        echo $form->field($model, 'custom_member_column')->widget(Select2::classname(), [
            'bsVersion' => '4.x',
            'data' => [1 => 'No', 2 => 'Yes'],
            'options' => ['placeholder' => 'Select Member', 'style' => 'width:200px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('SHG Member');
        ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">

        <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_MD])) { ?>
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

        <?php } ?>
    </div>
    <div class="col-xl-3 col-md-4 mb-2">
        <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;']) ?>
        <?= Html::button('Reset', ['class' => 'btn  btn-primary reset', 'style' => 'padding:7px 20px;margin-left:10px', 'id' => 'reloads']) ?>
        <?= Html::button('<i class="glyphicon glyphicon-download-alt"></i> Download CSV', ['class' => 'btn btn-primary ', 'style' => 'padding:7px 20px; margin-left:3px;', 'id' => 'download', 'name' => 'download', 'value' => 'download']) ?>
    </div>
</div>










<?php
//            echo $form->field($model, 'urban_shg')->widget(Select2::classname(), [
//                'data' => [0 => 'No', 1 => 'Yes'],
//                'options' => ['placeholder' => 'Convert to Urban', 'style' => 'width:250px'],
//                'pluginOptions' => [
//                    'allowClear' => true
//                ],
//            ])->label('Urban');
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
<?php
$js = <<<js
        
        $(document).ready(function(){
            $("#download").click(function(event){
              $("#Searchform").attr({ "action":"/training/participants/miscsv"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
        $("#searchbtn").click(function(event){
                $("#Searchform").attr({ "action":"/training/participants"});
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

$this->registerJs($js);
?>