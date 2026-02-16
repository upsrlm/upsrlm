<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use bc\modules\selection\models\base\GenralModel;
use common\models\User;
use common\models\master\MasterRole
?>   
<?php

$form = ActiveForm::begin([
            'layout' => 'inline',
            'options' => [
                'class' => 'form-inline',
                'data-pjax' => true,
                'id' => 'search-form'
            ],
            'method' => 'get',
        ]);
?>

<?php

echo $form->field($model, 'district_code')->label('District')->widget(Select2::classname(), [
    'data' => $model->district_option,
    'options' => ['placeholder' => 'District', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>

<?php

echo $form->field($model, 'block_code')->label('Block')->widget(Select2::classname(), [
    'data' => $model->block_option,
    'options' => ['placeholder' => 'Block', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>

<?php

echo $form->field($model, 'gram_panchayat_code')->label('Gram Panchayat')->widget(Select2::classname(), [
    'data' => $model->gp_option,
    'options' => ['placeholder' => 'Gram Panchayat', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>


<?php

echo $form->field($model, 'village_code')->widget(Select2::classname(), [
    'data' => $model->village_option,
    'options' => ['placeholder' => 'Village', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?> 

<?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN])) { ?>

    <?php

    echo $form->field($model, 'training_status')->widget(Select2::classname(), [
        'data' => [0 => 'Default', 1 => 'Agree', '2' => 'Registered(Assign Batch)', '3' => 'Certified', '4' => 'Not Certified', '5' => 'ineligible', '6' => 'Absent', '-2' => 'Unwilling'],
        'options' => ['placeholder' => 'Training Status', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Training Status');
    ?>
<?php } ?>

<?= Html::submitButton('<i class="fal fa-search"></i>Search', ['class' => 'btn btn-primary ', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search']) . '&nbsp;' ?>
<?= Html::button('Reset', ['class' => 'btn  btn-primary reset', 'id' => 'reloads']) ?>





<?php ActiveForm::end(); ?>

<?php

$css = <<<cs
 .select2-selection__rendered {
    width: 250px !important;
}
cs;
$this->registerCss($css);
?>
<?php

$js = <<<js
  $('form select').on('change', function(){ 
    $(this).closest('form').submit();
});      
        $(document).ready(function(){
        $('#reloads').click(function() {
               location.reload();
         }); 
         
       }) 
js;

$this->registerJs($js);
?>