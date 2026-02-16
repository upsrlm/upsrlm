<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use kartik\widgets\DateTimePicker;
//use kartik\date\DatePicker;
use kartik\widgets\DatePicker;
use common\models\base\GenralModel;
use common\models\User;
use common\models\master\MasterRole;
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
                'method' => 'POST',
    ]);
    ?>
    <div class="row">
        <div class="col-xl-2 col-md-4 mb-2">
        <?php
    echo $form->field($model, 'month')->widget(Select2::classname(), [
        'data' => $model->month_option,
        'options' => ['placeholder' => 'Select Month', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Month');
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;']) ?>

        </div>
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


