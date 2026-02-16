<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use bc\modules\selection\models\base\GenralModel;
use common\models\User;
use common\models\master\MasterArea;
?>

<div class="srlm-bc-selection-app-detail-search">

    <?php
    $form = ActiveForm::begin([
                'layout' => 'inline',
                'options' => [
                    'data-pjax' => true,
                    'id' => 'Searchform'
                ],
                'method' => 'get',
    ]);
    ?>
    <div class="row">
<div class="col-xl-2 col-md-4 mb-2">
<?= $form->field($model, 'user_id') ?>
</div>
<div class="col-xl-2 col-md-4 mb-2">
<?= $form->field($model, 'manufacturer_name') ?>
</div>
<div class="col-xl-2 col-md-4 mb-2">
<?php
    echo $form->field($model, 'status')->widget(Select2::classname(), [
        'data' => [1 => 'Active', 0 => 'Inactive'],
        'options' => ['placeholder' => 'App Status', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('App Status');
    ?>
</div>
<div class="col-xl-2 col-md-4 mb-2">
<?= Html::submitButton('Search', ['class' => 'btn btn-primary','style' => 'padding:7px 20px;']) ?>
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
    width: 200px !important;
}
cs;
$this->registerCss($css);
?>