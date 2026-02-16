<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $model app\modules\shg\models\Shg */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bc-form">

    <?php $form = ActiveForm::begin(['id' => 'form-gp', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
    <div class="row">
        <div class="col-lg-6"> 
            <?php
            echo $form->field($model, 'district_code')->label('District')->dropDownList($model->district_option, ['prompt' => 'Select District']);
            ?>
            <?php
            echo $form->field($model, 'block_code')->label('block')->widget(DepDrop::classname(), [
                'data' => $model->block_option,
                'options' => ['placeholder' => 'Select Block', 'multiple' => FALSE],
                'pluginOptions' => [
                    'allowClear' => true,
                    'depends' => ['addgpform-district_code'],
                    'url' => Url::to(['/ajax/getblock']),
                ],
            ]);
            ?>
            <?php echo $form->field($model, 'gram_panchayat_code')->textInput(['maxlength' => 6]) ?>

            <?php echo $form->field($model, 'gram_panchayat_name')->textInput(['maxlength' => 132]) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

        </div>
        <div class="col-lg-6">
            <div id="gplist">

            </div>
        </div>  
    </div> 



    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs(
        '
	$(document).ready(function(){
        $("#addgpform-block_code").change(function(){
	var block_code = $(this).val();
	if(block_code != "")
	{
	$.ajax({
	type: "GET",
	url: "/master/grampanchayat/getblockgp",
	data: {block_code:block_code},
	success: function(data){
	$("#gplist").html(data);
	}
	});
	}
	else
	{
	$("#gplist").html("");
	}
});
});
');
?>