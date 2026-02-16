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

/* @var $this yii\web\View */
/* @var $model bc\modules\selection\models\BcMissingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bc-missing-search">

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
            <?= $form->field($model, 'bc_name')->label('')->textInput(['placeholder' => 'BC Name']) ?>
        </div>
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
    echo $form->field($model, 'listed_bc_training_status')->widget(Select2::classname(), [
        'data' => [0 => 'Default', 1 => 'Agree', '2' => 'Registered(Assign Batch)', '3' => 'Certified', '4' => 'Not Certified', '5' => 'ineligible', '6' => 'Absent'],
        'options' => ['placeholder' => 'Training Status', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('listed training Status');
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
    echo $form->field($model, 'map')->widget(Select2::classname(), [
        'data' => [0 => 'No', 1 => 'Yes',],
        'options' => ['placeholder' => 'Map', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Map');
    ?>
               <?php
    $form->field($model, 'bc_missing_listed')->widget(Select2::classname(), [
        'data' => [0 => 'No', 1 => 'Yes',],
        'options' => ['placeholder' => 'BC missing listed same', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('BC missing listed same');
    ?>
        </div>

        <div class="col-xl-2 col-md-4 mb-2">
            <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;']) ?>
            <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) { ?>
            <?php echo Html::button('<i class="fa fa-download"></i> Download CSV', ['class' => 'btn btn-primary ', 'style' => 'padding:7px 20px;margin-left:10px;', 'id' => 'download', 'name' => 'download', 'value' => 'download']) ?>
            <?php } ?>
        </div>

    </div>


    <?php ActiveForm::end(); ?>

</div>
<?php
$css = <<<cs
 .select2-selection__rendered {
    width: 150px !important;
}
cs;
$this->registerCss($css);
?>