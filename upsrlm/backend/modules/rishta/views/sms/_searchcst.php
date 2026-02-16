<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use common\models\base\GenralModel;
use common\models\User;
use common\models\master\MasterRole;
?>

<div class="row">
    <div class="col-xl-2 col-md-4 mb-2">
    <?=

$form->field($model, 'mobile_no', [
    'template' => '{label}<div class="col-xs-12">{input}</div>',
])->textInput(['placeholder' => 'Mobile No.'])->label('Mobile No.')
?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
    <?php

echo $form->field($model, 'district_code')->widget(Select2::classname(), [
    'data' => $model->district_option,
    'options' => ['placeholder' => 'District', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
    <?php

echo $form->field($model, 'block_code')->widget(Select2::classname(), [
    'data' => $model->block_option,
    'options' => ['placeholder' => 'Block', 'style' => 'width:250px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
    </div>
    <?php echo $form->field($model, 'change_type')->hiddenInput()->label(false); ?>
    <div class="col-xl-4 col-md-4 mb-2">
    <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'margin-left:10px;padding:7px 20px;']) ?>
    <?= Html::button('Reset', ['class' => 'btn  btn-primary reset', 'style' => ' padding:7px 20px;', 'id' => 'reloads']) ?>
    </div>
</div>









<?php

$js = <<<JS

$('#reloads').click(function() {
    location.reload();
});        
JS;
$this->registerJs($js);

$css = <<<cs
 .select2-selection__rendered {
    width: 250px !important;
}
cs;
$this->registerCss($css);
?>
<?php

$js = <<<js
        
        $(document).ready(function(){
            
         
        $("#searchbtn").click(function(event){
               
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

$this->registerJs($js);
?>

