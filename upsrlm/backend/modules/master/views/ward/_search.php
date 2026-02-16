<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use \yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
use app\models\base\GenralModel;

/* @var $this yii\web\View */
/* @var $model app\models\MasterTownSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-town-search">
    <?php
    $form = ActiveForm::begin([
            'layout' => 'inline',
                'options' => [
                    'class' => 'form-inline',
                    'data-pjax' => true,
                ],
                'method' => 'get',
    ]);
    ?>

    <?php
    echo $form->field($model, 'ulb_code')->widget(Select2::classname(), [
        'data' => $model->ulb_option,
        'options' => ['placeholder' => 'Select ULB', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('ULB');
    ?>
    <div class = "form-group">
        <?= Html::submitButton('<i class="fal fa-search"></i>Search', ['class' => 'btn btn-primary']) ?>

    </div>

    <?php ActiveForm::end(); ?>


</div>
<?php
$css = <<<cs
 .select2-selection__rendered {
    width: 200px !important;
}
cs;
$this->registerCss($css);
?>
