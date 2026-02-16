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
                'method' => 'get',
    ]);
    ?>
    <div class="row">
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'master_partner_bank_id')->widget(Select2::classname(), [
                'data' => $model->bank_option,
                'options' => ['placeholder' => 'Select Partner agencies', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Partner agencies');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'margin-left:10px']) ?>
            <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS]) and $model->master_partner_bank_id) { ?>

                <?php echo Html::button('<i class="glyphicon glyphicon-download-alt"></i> Download CSV', ['class' => 'btn btn-primary ', 'style' => 'margin-left:10px;', 'id' => 'download', 'name' => 'download', 'value' => 'download']) ?>

            <?php } ?>
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