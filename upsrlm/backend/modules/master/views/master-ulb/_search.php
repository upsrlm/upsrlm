<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
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
                'layout' => 'inline',
                'options' => [
                    'data-pjax' => true,
                    'id' => 'Searchform'
                ],
                'method' => 'get',
    ]);
    ?>
    
    <?php echo $form->field($model, 'district_code')->dropDownList(\yii\helpers\ArrayHelper::map(app\models\master\MasterTown::find()->orderBy('district_name asc')->all(), 'district_code', 'district_name'), ['prompt' => 'District Name', 'style' => 'width:250px', 'style' => 'height:40px'])->label(false); ?>
     <?php
    //  print_r(Yii::$app->request->get());
     
        echo $form->field($model, 'sub_district_code')->widget(DepDrop::classname(), [
            'options' => ['prompt' => 'Sub District Name','style' => 'width:250px', 'style' => 'height:40px'],
            'data' => \yii\helpers\ArrayHelper::map(app\models\master\MasterTown::find()->orderBy('sub_district_name asc')->all(), 'sub_district_code', 'sub_district_name'),
            'pluginOptions' => [
                'allowClear' => true,
                'depends' => ['mastertownsearch-district_code'],
                'url' => Url::to(['/site/subdistrict']),
            ]
        ])->label(false);
    ?>

    <div class = "form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>Search', ['class' => 'btn btn-primary']) ?>

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
