<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
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
                'layout' => 'inline',
                'options' => [
                    'class' => 'form-inline',
                    'data-pjax' => true,
                    'id' => 'Searchform'
                ],
                'method' => 'get',
    ]);
    ?>

    <?php
    if (isset(Yii::$app->user->identity) and!in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
        echo $form->field($model, 'master_partner_bank_id')->widget(Select2::classname(), [
            'data' => $model->bank_option,
            'options' => ['placeholder' => 'Select Partner Agency', 'style' => 'width:200px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Partner Bank');
    
    ?>
    <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'margin-left:10px']) ?>
   <?php } ?>
    

    
    

    <?php ActiveForm::end(); ?>
</div>
<?php
$css = <<<cs
 .select2-selection__rendered {
    width: 250px !important;
}
cs;
$this->registerCss($css);
?>


