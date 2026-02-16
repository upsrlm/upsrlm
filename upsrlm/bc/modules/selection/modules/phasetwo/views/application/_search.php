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
echo $form->field($model, 'district_code')->widget(Select2::classname(), [
    'data' => $model->district_option,
    'options' => ['placeholder' => 'Select District', 'style' => 'width:250px'],
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
    'options' => ['placeholder' => 'Select Block', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
echo $form->field($model, 'marital_status')->widget(Select2::classname(), [
    'data' => $model->marital_status_option,
    'options' => ['placeholder' => 'Select Marital Status', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">


        <?php
echo $form->field($model, 'reading_skills')->widget(Select2::classname(), [
    'data' => $model->reading_skills_option,
    'options' => ['placeholder' => 'Select Education / Functional skills', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('Education / Functional skills');
?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">

        <?php
echo $form->field($model, 'cast')->widget(Select2::classname(), [
    'data' => $model->cast_option,
    'options' => ['placeholder' => 'Select Social Category', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('Social Category');
?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
echo $form->field($model, 'age_group')->widget(Select2::classname(), [
    'data' => $model->age_group_option,
    'options' => ['placeholder' => 'Select Age Group', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">

        <?php
echo $form->field($model, 'phone_type')->widget(Select2::classname(), [
    'data' => $model->phone_type_option,
    'options' => ['placeholder' => 'Select Phone Type', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
echo $form->field($model, 'custom_already_group_member')->widget(Select2::classname(), [
    'data' => $model->already_group_member_option,
    'options' => ['placeholder' => 'Select Group Member', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
echo $form->field($model, 'highest_score_in_gp')->widget(Select2::classname(), [
    'data' => $model->highest_score_in_gp_option,
    'options' => ['placeholder' => 'Highest scroe in GP', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
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
    </div>
    <div class="col-xl-4 col-md-4 mb-2">
        <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;']) ?>
        <?= Html::button('Reset', ['class' => 'btn  btn-primary reset', 'style' => 'padding:7px 20px;margin-left:10px', 'id' => 'reloads']) ?>
        <?php if ($model->block_code) { ?>
        <?= Html::button('<i class="fa fa-file-pdf-o"></i> Download PDF', ['class' => 'btn  btn-primary', 'id' => 'download', 'name' => 'download', 'value' => 'download', 'style' => 'padding:7px 20px;margin-left:10px;']) ?>

        <?php } ?>
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
    width: 250px !important;
}
cs;
$this->registerCss($css);
?>
<?php
$js = <<<js
        
        $(document).ready(function(){
            $("#download").click(function(event){
              $("#Searchform").attr({ "action":"/selection/phase2/application/reportpdf"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
        $("#searchbtn").click(function(event){
                $("#Searchform").attr({ "action":"/selection/phase2/application/report"});
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

$this->registerJs($js);
?>