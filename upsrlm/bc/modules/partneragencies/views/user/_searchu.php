<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
use common\models\base\GenralModel;
use common\models\master\MasterRole;
?>

<div class="search-form ">

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
        <?=
    $form->field($model, 'name', [
        'template' => '{label}<div >{input}</div>',
    ])->textInput(['placeholder' => 'name'])
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?=
    $form->field($model, 'username', [
        'template' => '{label}<div >{input}</div>',
    ])->textInput(['placeholder' => 'Login'])->label('Login')
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?php
    if (isset(Yii::$app->user->identity) and!in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
        echo $form->field($model, 'master_partner_bank_id')->widget(Select2::classname(), [
            'data' => $model->bank_option,
            'options' => ['placeholder' => 'Select Parner Bank', 'style' => 'width:200px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Partner Bank');
    }
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?php
    echo $form->field($model, 'district_code')->widget(Select2::classname(), [
        'data' => $model->district_option,
        'options' => ['placeholder' => 'Select District', 'style' => 'width:200px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('District');
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?php
    echo $form->field($model, 'status')->widget(Select2::classname(), [
        'data' => [10 => 'Active', 9 => 'Inactive'],
        'options' => ['placeholder' => 'Select User Status', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?= Html::submitButton('Search', ['class' => 'btn btn-info ','style'=>'padding:7px 20px;']) ?>
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
<?php
$script = <<< JS
    $('form select').on('change', function(){
    $(this).closest('form').submit();
});            
   
JS;
$this->registerJs($script);
?>