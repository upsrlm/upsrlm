<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\master\MasterVillage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-village-form">
    <div class="card-box">

        <div class="row">
            <div class="col-12">
                <?php
                $form = ActiveForm::begin([
                            'id' => 'entity-user-form',
                            'enableAjaxValidation' => true,
                            'enableClientValidation' => false,
                            'options' => ['class' => 'form-horizontal'],
                            'fieldConfig' => [
                                'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-lg-3\">{error}</div>",
                                'labelOptions' => ['class' => 'col-md-3 control-label'],
                            ],
                ]);
                ?>
                <div class="col-lg-6">
                    <?php // echo $form->field($model, 'state_code')->textInput(['maxlength' => true]) ?>

                    <?php // echo $form->field($model, 'state_name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'district_code')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'district_name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'sub_district_code')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'sub_district_name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'village_code')->textInput(['maxlength' => true]) ?>


                </div> 
                <div class="col-lg-6">
                    <?= $form->field($model, 'village_name')->textInput(['maxlength' => true]) ?>

                    <?php // echo $form->field($model, 'block_id')->textInput() ?>

                    <?= $form->field($model, 'block_code')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'block_name')->textInput(['maxlength' => true]) ?>

                    <?php // echo $form->field($model, 'gram_panchayat_id')->textInput() ?>

                    <?= $form->field($model, 'gram_panchayat_code')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'gram_panchayat_name')->textInput(['maxlength' => true]) ?>
                </div>    


                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-11">

                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>


            </div>
        </div>
    </div>
</div>

<?php
$css = <<<css
   div.required label.control-label:after {
    content: " *";
    color: red;
}
css;
$this->registerCss($css);
?>