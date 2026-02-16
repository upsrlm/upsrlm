<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
use common\models\master\MasterRole;
$this->title = 'Create SHG';
$this->params['breadcrumbs'][] = ['label' => 'Certified BC', 'url' => ['/bc/certified']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shg-create">
    <div class="panel panel-default">
        <div class='panel-body'>
            <h1><?= Html::encode($this->title) ?></h1>

<div class="shg-form">
    <p>
        <span style="color:#478fca !important">Notice: <b>ये सभी सूचनाएं मेरे स्वयं के द्वारा सत्यापित की हुई है I सूचनाओं के प्रावधान में किसी भी त्रुटि की जवाबदेही सम्बद्ध होगी </b>I</span>
    </p>
    <?php $form = ActiveForm::begin(['id' => 'form-clf', 'enableAjaxValidation' => false, 'enableClientValidation' => true, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
    <div class="row">
        <div class="col-lg-6">    
            <?php
            echo $form->field($model, 'gram_panchayat_code')->widget(kartik\select2\Select2::classname(), [
                'data' => $model->gp_option,
                'size' => Select2::MEDIUM,
                'options' => ['placeholder' => 'Select GP', 'multiple' => FALSE],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>

            <?php
            echo $form->field($model, 'village_code')->widget(DepDrop::classname(), [
                'data' => $model->village_option,
                'options' => ['placeholder' => 'Select Village', 'multiple' => FALSE],
                'pluginOptions' => [
                    'placeholder' => 'SelectVillage',
                    'depends' => ['shgform-gram_panchayat_code'],
                    'url' => Url::to(['/ajax/getvillage']),
                ],
            ]);
            ?> 

            <?= $form->field($model, 'hamlet')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'name_of_shg')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'shg_code')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'no_of_members')->textInput() ?>
        </div>
        <div class="col-lg-6">    
            <?= $form->field($model, 'chaire_person_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'chaire_person_mobile_no')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'secretary_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'secretary_mobile_no')->textInput() ?>

            <?= $form->field($model, 'treasurer_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'treasurer_mobile_no')->textInput(['maxlength' => true]) ?>
        </div>   
    </div> 

<?php if(in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_RSETIS_STATE_UNIT])){ ?>
   <div class="row">
		<h3 class="header smaller lighter blue">Bank details/ बैंक का विवरण</h3>
		<div class="col-lg-6">
<?= $form->field($model, 'bank_account_no_of_the_shg')->label("Bank account no. of the SHG/ SHG का बैंक अकाउंट नंबर")->textInput() ?>
		</div>
		<div class="col-lg-6">
<?= $form->field($model, 'bank_id')->label("Name Of Bank/ बैंक का नाम")->dropDownList($model->bank_option, ['prompt' => "Select Bank"]) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
<?= $form->field($model, 'branch')->label("Branch/ बैंक शाखा का नाम")->textInput() ?>
		</div>
		<div class="col-lg-6">
<?= $form->field($model, 'branch_code_or_ifsc')->label("Branch Code Or IFSC/ ब्रांच कोड/ या IFSC कोड")->textInput() ?>
		</div>
	</div>
   <div class="row">
		<div class="col-lg-6">
			<?php
			echo $form->field($model, 'date_of_opening_the_bank_account')->widget(DatePicker::classname(), [
				'value' => $model->date_of_opening_the_bank_account,
				'options' => ['placeholder' => 'Date of opening the bank account', 'class' => 'calculateday', 'readonly' => 'readonly'],
				'pluginOptions' => [
					'readonly' => 'readonly',
					'format' => 'dd-mm-yyyy',
					'todayHighlight' => true,
					'autoclose' => true,
					'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { console.log(dateText, inst) }'),
				],
				'pluginEvents' => [
					"changeDate" => "function(e) { "
					. "}",
				]
			])->label("Date Of Opening The Bank Account/ बैंक अकाउंट खोलने की तिथि");
			?>

		</div>
		<div class="col-lg-6">
			<?php
			echo $form->field($model, 'passbook_photo')->widget(FileInput::classname(), [
				'options' => ['accept' => 'image/*'],
				'pluginOptions' => [
					'showPreview' => false,
					'showCaption' => true,
					'showRemove' => false,
					'showUpload' => false,
					'initialPreview' => [
					],
					'overwriteInitial' => true,
				],
			])->label('Passbook Photo)');
			?>
		</div>
	</div>
    <?php } ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success px-2 px-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
    </div>     
</div>
