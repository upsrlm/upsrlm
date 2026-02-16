<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use kartik\widgets\DateTimePicker;
use kartik\widgets\DatePicker;
use common\models\base\GenralModel;
use common\models\User;
use common\models\master\MasterRole;
?>
<?php

echo $form->field($model, 'from_month_id')->widget(Select2::classname(), [
    'data' => $model->from_month_option,
    'options' => ['placeholder' => 'From Month', 'style' => 'width:200px'],
    'pluginOptions' => [
        'allowClear' => false
    ],
])->label('From Month');
?>
<?php

echo $form->field($model, 'to_month_id')->widget(Select2::classname(), [
    'data' => $model->to_month_option,
    'options' => ['placeholder' => 'To Month', 'style' => 'width:200px'],
    'pluginOptions' => [
        'allowClear' => false
    ],
])->label('Block');
?>
<?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'margin-left:10px']) ?>
<?php

$css = <<<cs
 .select2-selection__rendered {
    width: 200px !important;
}
cs;
$this->registerCss($css);
?>


