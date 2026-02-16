
<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use \yii\widgets\Pjax;
use kartik\depdrop\DepDrop;
use app\models\GenralModel;

/* @var $this yii\web\View */
/* @var $model app\models\MasterTownSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-town-search">
    <?php
    $form = ActiveForm::begin([
                'options' => [
                    'class' => 'form-inline',
                    'data-pjax' => true,
                ],
                'method' => 'get',
    ]);
    ?>
    
    <?php echo $form->field($model, 'district')->dropDownList(\yii\helpers\ArrayHelper::map(app\models\master\MasterListBlockBdo::find()->orderBy('district asc')->all(), 'district', 'district'), ['prompt' => 'District Name', 'style' => 'width:250px', 'style' => 'height:40px'])->label(false); ?>
    
  <?= $form->field($model, 'block')->dropDownList(\yii\helpers\ArrayHelper::map(app\models\master\MasterListBlockBdo::find()->orderBy('block asc')->all(), 'block', 'block'), ['prompt' => 'Block Name', 'style' => 'width:250px', 'style' => 'height:40px'])->label(false); ?>
    <?= $form->field($model, 'status')->dropDownList(['1'=>'Active','0'=>'Inactive'], ['prompt' => 'Select Status', 'style' => 'width:250px', 'style' => 'height:40px'])->label(false); ?>
    <div class = "form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>Search', ['class' => 'btn btn-primary']) ?>

    </div>

    <?php ActiveForm::end(); ?>


</div>
