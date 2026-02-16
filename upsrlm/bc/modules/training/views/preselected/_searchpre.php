<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
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
        echo $form->field($model, 'call1')->label('UPSRLM Call Status')->widget(Select2::classname(), [
            'bsVersion' => '4.x',
            'data' => [0 => 'Not done', 1 => 'Done'],
            'options' => ['placeholder' => 'UPSRLM Call Status', 'style' => 'width:250px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
        echo $form->field($model, 'bc_unwilling_rsetis')->label('Unwlling')->widget(Select2::classname(), [
            'bsVersion' => '4.x',
            'data' => [0 => 'No', 1 => 'Yes'],
            'options' => ['placeholder' => 'Unwlling Status', 'style' => 'width:250px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>
    <div class="col-xl-4 col-md-4 mb-2">
        <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;']) ?>
        <?= Html::button('Reset', ['class' => 'btn  btn-primary reset', 'style' => 'padding:7px 20px;margin-left:10px', 'id' => 'reloads']) ?>
        <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) { ?>
            <?php echo Html::button('<i class="glyphicon glyphicon-download-alt"></i> Download CSV', ['class' => 'btn btn-primary ', 'style' => 'padding:7px 20px;margin-left:10px;', 'id' => 'download', 'name' => 'download', 'value' => 'download']) ?>
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
    width: 200px !important;
}
cs;
$this->registerCss($css);
?>