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
<div class="srlm-search">
    <?php
    $form = ActiveForm::begin([
                'options' => [
                    'class' => 'form-inline',
                    'data-pjax' => true,
                    'id' => 'Searchform'
                ],
                'method' => 'get',
    ]);
    ?>
    <div class="row-fluid">

        <div class="col-lg-12">
            <?php
            echo $form->field($model, 'aspirational')->widget(Select2::classname(), [
                'data' => ['1' => 'Yes', '0' => 'No'],
                'options' => ['placeholder' => 'Aspirational Block', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
            <?php
            echo $form->field($model, 'district_code')->widget(Select2::classname(), [
                'data' => $model->district_option,
                'options' => ['placeholder' => 'Select District', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('District');
            ?>
            <?php
            $form->field($model, 'rsetis_center_id')->widget(Select2::classname(), [
                'data' => $model->center_option,
                'options' => ['placeholder' => 'Select Venue', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Venue');
            ?>
            <?php
            echo $form->field($model, 'rsetis_center_training_id')->widget(Select2::classname(), [
                'data' => $model->training_option,
                'options' => ['placeholder' => 'Select Training', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Training');
            ?>
            <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) { ?>
                <?php
                echo $form->field($model, 'custom_education')->widget(Select2::classname(), [
                    'data' => [1 => '10th Pass', 2 => '10th not pass'],
                    'options' => ['placeholder' => 'Select Education', 'style' => 'width:250px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Education');
                ?>
            <?php } ?>
            <?php //if (!in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT,MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {?>
            <?php
            $form->field($model, 'training_status')->widget(Select2::classname(), [
                'data' => $model->training_status_option,
                'options' => ['placeholder' => 'Select Training Status', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Training Status');
            ?>
            <?php //} ?>
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
//            echo $form->field($model, 'already_group_member')->widget(Select2::classname(), [
//                'data' => $model->gp_member_option,
//                'options' => ['placeholder' => 'Select Member', 'style' => 'width:200px'],
//                'pluginOptions' => [
//                    'allowClear' => true
//                ],
//            ])->label('Member');
            ?>
            <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) { ?>
                <?php
                echo $form->field($model, 'bc_photo_status')->widget(Select2::classname(), [
                    'data' => $model->bc_photo_option,
                    'options' => ['placeholder' => 'Select Photo Status', 'style' => 'width:250px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>

            <?php } ?>
            <?php
            echo $form->field($model, 'custom_member_column')->widget(Select2::classname(), [
                'data' => [1 => 'No', 2 => 'Yes'],
                'options' => ['placeholder' => 'Select Member', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Member');
            ?>

            <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'margin-top:10px;width:75px;margin-left:10px']) ?>
            <?= Html::button('Reset', ['class' => 'btn  btn-primary reset', 'style' => 'margin-top:10px;width:75px;margin-left:10px', 'id' => 'reloads']) ?>
            <?= Html::button('<i class="glyphicon glyphicon-download-alt"></i> Download CSV', ['class' => 'btn btn-primary ', 'style' => 'margin-top:10px;', 'id' => 'download', 'name' => 'download', 'value' => 'download']) ?>
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
    width: 250px !important;
}
cs;
$this->registerCss($css);
?>
<?php
$js = <<<js
        
        $(document).ready(function(){
            $("#download").click(function(event){
              $("#Searchform").attr({ "action":"/bc/training/participants/downloadcsv"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
        $("#searchbtn").click(function(event){
                $("#Searchform").attr({ "action":"/bc/training/participants"});
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

$this->registerJs($js);
?>
