<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use \yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use common\models\base\GenralModel;
use common\models\User;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $model bc\models\PartnerAssociatesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="partner-associates-search">

    <?php
    $form = ActiveForm::begin([
                'options' => [
                    'class' => 'form-inline',
                    'data-pjax' => true,
                    'id' => 'Searchform'
                ],
                'id' => 'Searchform',
                'layout' => 'inline',
                'method' => 'POST',
    ]);
    ?>
    <div class="row">
        <div class="col-xl-2 col-md-4 mb-2">
            <?= $form->field($model, 'name_of_the_field_officer') ?>
        </div>
        
            <?php
            if (isset(Yii::$app->user->identity) and !in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS, MasterRole::ROLE_DC_NRLM])) {
               echo '<div class="col-xl-2 col-md-4 mb-2">';
                echo $form->field($model, 'master_partner_bank_id')->widget(Select2::classname(), [
                    'data' => $model->bank_option,
                    'options' => ['placeholder' => 'Select Parner Bank', 'style' => 'width:200px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Partner Bank');
                echo '</div>';
            }
            ?>
        
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
            echo $form->field($model, 'block_code')->widget(Select2::classname(), [
                'data' => $model->block_option,
                'options' => ['placeholder' => 'Select Block', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Block');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'style' => 'padding:7px 20px;']) ?>
        </div>

    </div>


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