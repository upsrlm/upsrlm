<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use \yii\widgets\Pjax;
use kartik\depdrop\DepDrop;
use app\models\GenralModel;

ini_set("memory_limit", "1288888M");
ini_set('max_execution_time', 30000000);
/* @var $this yii\web\View */
/* @var $model app\models\MasterVillageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-village-search">
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
<?php echo $form->field($model, 'district_code')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\master\MasterVillage::find()->groupBy(['district_code'])->orderBy('district_name asc')->all(), 'district_code', 'district_name'), ['prompt' => 'District Name', 'style' => 'width:250px', 'style' => 'height:40px'])->label(false); ?>
</div>
<div class="col-xl-2 col-md-4 mb-2">
<?php
    echo $form->field($model, 'sub_district_code')->widget(DepDrop::classname(), [
        'data' => $model->getdistrict($model->sub_district_code),
        'options' => ['placeholder' => 'Select  sub district', 'multiple' => FALSE, 'style' => 'width:250px', 'style' => 'height:40px'],
        'pluginOptions' => [
            'allowClear' => true,
            'placeholder' => 'Select  sub district',
            'depends' => ['mastervillagesearch-district_code'],
            'url' => Url::to(['/ajax/subdisrict']),
        ],
    ])->label('');
    ?>
</div>
<div class="col-xl-2 col-md-4 mb-2">
  
<?php
    echo $form->field($model, 'block_code')->widget(DepDrop::classname(), [
        'data' => $model->getblock($model->block_code),
        'options' => ['prompt' => 'Select Block', 'style' => 'width:250px', 'style' => 'height:40px'],
        'pluginOptions' => [
            'allowClear' => true,
            'depends' => ['mastervillagesearch-district_code', 'mastervillagesearch-sub_district_code'],
            'url' => Url::to(['/ajax/block']),
        ]
    ])->label(false);
    ?>
</div>
<div class="col-xl-2 col-md-4 mb-2">
<?php echo $form->field($model, 'gram_panchayat_name')->textInput(['placeholder' => 'Gram Panchayat Name'])->label(false) ?>
</div>
<div class="col-xl-2 col-md-4 mb-2">
<?= Html::submitButton('Search', ['class' => 'btn btn-primary py-2 px-3']) ?>

</div>
</div>

    



 

   

 

    <?php ActiveForm::end(); ?>


</div>



