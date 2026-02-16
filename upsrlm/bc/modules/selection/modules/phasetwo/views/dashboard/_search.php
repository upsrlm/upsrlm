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
    echo $form->field($model, 'block_code')->label('Block')->widget(Select2::classname(), [
        'data' => $model->block_option,
        'options' => ['placeholder' => 'Block', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
    echo $form->field($model, 'gram_panchayat_code')->widget(Select2::classname(), [
        'data' => $model->gp_option,
        'options' => ['placeholder' => 'GP', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    </div>
    <div class="col-xl-2 col-md-4 mb-2">
        <?php
    echo $form->field($model, 'village_code')->widget(Select2::classname(), [
        'data' => $model->village_option,
        'options' => ['placeholder' => 'Village', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
            <?php
    $form->field($model, 'section_at')->widget(Select2::classname(), [
        'data' => [1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'],
        'options' => ['placeholder' => 'Select Section At', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    </div>

    <?php echo $form->field($model, 'change_type')->hiddenInput()->label(false); ?>
    <div class="col-xl-2 col-md-4 mb-2">
        <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;']) ?>
        <?= Html::button('Reset', ['class' => 'btn  btn-primary reset', 'style' => 'padding:7px 20px;margin-left:10px', 'id' => 'reloads']) ?>
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
            $("#download").click(function(event){
              $("#Searchform").attr({ "action":"/selection/phase2/dashboard/download"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
         
        $("#searchbtn").click(function(event){
                $("#Searchform").attr({ "action":"/selection/phase2/dashboard"});
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

    $this->registerJs($js);
    ?>