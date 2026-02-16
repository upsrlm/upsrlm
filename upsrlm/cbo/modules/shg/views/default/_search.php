<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use common\models\base\GenralModel;
use common\models\User;
use common\models\master\MasterRole;
?>
<div class="col-xl-12">
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
    <div class="row">
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'district_code')->widget(Select2::classname(), [
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
            echo $form->field($model, 'gram_panchayat_code')->label('Gram Panchayat')->widget(Select2::classname(), [
                'data' => $model->gp_option,
                'options' => ['placeholder' => 'Gram Panchayat', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'wada')->label('WADA')->widget(Select2::classname(), [
                'data' => [1 => 'Yes', 0 => 'No'],
                'options' => ['placeholder' => 'WADA', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">

            <?php
            echo $form->field($model, 'shg_nrlm_code')->label('NRLM SHG Code')->widget(Select2::classname(), [
                'data' => [1 => 'Yes', 0 => 'No'],
                'options' => ['placeholder' => 'NRLM SHG Code', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <?php if (!in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DMMU])) { ?>
            <div class="col-xl-2 col-md-4 mb-2">
                <?php
                echo $form->field($model, 'verification_status')->widget(Select2::classname(), [
                    'data' => [1 => 'Completed', 0 => 'Not Completed'],
                    'options' => ['placeholder' => 'Verification Process', 'style' => 'width:250px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Verification Process');
                ?>
            </div>

        <?php } ?>

        <?php if (!in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DMMU])) { ?>
            <div class="col-xl-2 col-md-4 mb-2">

            </div>
            <div class="col-xl-2 col-md-4 mb-2">
                <?php
                echo $form->field($model, 'verify_mobile_no')->widget(Select2::classname(), [
                    'data' => $model->verify_option,
                    'options' => ['placeholder' => 'Verification Member Status', 'style' => 'width:250px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Verification Member Status');
                ?>
            </div>
        <?php } ?>

        <?php if (!in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DMMU])) { ?>
            <div class="col-xl-2 col-md-4 mb-2">

            </div>
            <div class="col-xl-2 col-md-4 mb-2">

                <?php
                echo $form->field($model, 'verify_other')->widget(Select2::classname(), [
                    'data' => $model->verify_other_option,
                    'options' => ['placeholder' => 'Verification SHG Status', 'style' => 'width:250px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Verification SHG Status');
                ?>
            </div>
        <?php } ?>

        <?php if (!in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DMMU])) { ?>
            <div class="col-xl-2 col-md-4 mb-2">
                <?php
                echo $form->field($model, 'return')->widget(Select2::classname(), [
                    'data' => $model->return_option,
                    'options' => ['placeholder' => 'Return Status', 'style' => 'width:250px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Return');
                ?>
            </div>
            <div class="col-xl-2 col-md-4 mb-2">
                <?php
                echo $form->field($model, 'data_entry')->widget(Select2::classname(), [
                    'data' => [0 => 'By All', 1 => 'By Me'],
                    'options' => ['placeholder' => 'SHG Entry', 'style' => 'width:250px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('SHG Entry');
                ?>
            </div>
        <?php } ?>
<!--        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'urban_shg')->widget(Select2::classname(), [
                'data' => [0 => 'No', 1 => 'Yes'],
                'options' => ['placeholder' => 'Convert to Urban', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Urban');
            ?>
        </div>-->
        <div class="col-xl-2 col-md-4 mb-2">

            <?= Html::submitButton('Search', ['class' => 'btn btn-sm btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;']) ?>
            <?= Html::button('Reset', ['class' => 'btn btn-sm btn-primary reset', 'style' => 'padding:7px 20px;margin-left:10px', 'id' => 'reloads']) ?>
        </div>
    </div>





    <?php
//            echo $form->field($model, 'village_code')->label('Rev. Village')->widget(Select2::classname(), [
//                'data' => $model->village_option,
//                'options' => ['placeholder' => 'Select Rev. Village', 'style' => 'width:250px'],
//                'pluginOptions' => [
//                    'allowClear' => true
//                ],
//            ]);
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
$js = <<<JS
    $(".reset").click(function() {
   $("select").each(function() { this.selectedIndex = 0 });
        $(this).closest('form').submit();
});
$('#reloads').click(function() {
    location.reload();
});        
JS;
$this->registerJs($js);

$css = <<<cs
 .select2-selection__rendered {
    width: 180px !important;
}
cs;
$this->registerCss($css);
?>
<?php
$js = <<<js
        
        $(document).ready(function(){
            $("#download").click(function(event){
              $("#Searchform").attr({ "action":"/srlm/data/bcselection/reportpdf"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
        $("#searchbtn").click(function(event){
                
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

$this->registerJs($js);
?>