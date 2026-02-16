<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use kartik\widgets\DateTimePicker;
use kartik\widgets\DatePicker;
use common\models\base\GenralModel;
use common\models\User;
use common\models\master\MasterArea;
?>
<div class="col-xl-12">
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
    echo $form->field($model, 'gram_panchayat_code')->label('Gram Panchayat')->widget(Select2::classname(), [
        'data' => $model->gp_option,
        'options' => ['placeholder' => 'Gram Panchayat', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?php
    echo $form->field($model, 'member')->label('Member belongs')->widget(Select2::classname(), [
        'data' => $model->member_option,
        'options' => ['placeholder' => 'Select Member belongs', 'style' => 'width:250px', 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Member belongs');
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?php
    echo $form->field($model, 'rishta_access_page')->widget(Select2::classname(), [
        'bsVersion' => '4.x',
        'data' => $model->rishta_access_option,
        'options' => ['placeholder' => 'Rishta App', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?> 
        </div>
        <div class="col-xl-2 col-md-4 mb-2">

        <?php
    echo $form->field($model, 'transaction_start')->widget(Select2::classname(), [
        'bsVersion' => '4.x',
        'data' => [0 => 'Transaction not started', 1 => 'Transaction started'],
        'options' => ['placeholder' => 'Transaction Status', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Transaction Status');
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?php
    echo $form->field($model, 'ctc_call')->widget(Select2::classname(), [
        'bsVersion' => '4.x',
        'data' => [0 => 'No', 1 => 'Yes'],
        'options' => ['placeholder' => 'CTC Call', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?> 
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?php
    echo $form->field($model, 'ibd_call')->widget(Select2::classname(), [
        'bsVersion' => '4.x',
        'data' => [0 => 'No', 1 => 'Yes'],
        'options' => ['placeholder' => 'IBD Call', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('IBD Call');
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?php
    echo $form->field($model, 'from_date_time')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'From Date'],
        'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
        'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
            'format' => 'yyyy-mm-dd',
            'minDate' => '2021-01-01',
        ]
    ]);
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">

        <?php
    echo $form->field($model, 'to_date_time')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'To Date'],
        'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
        'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
            'format' => 'yyyy-mm-dd',
            'minDate' => '2021-01-01',
        ]
    ]);
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
        <?= Html::submitButton('Search', ['class' => 'btn btn-sm btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;margin-left:10px']) ?>
    <?= Html::button('Reset', ['class' => 'btn btn-sm btn-primary reset', 'style' => 'padding:7px 20px;', 'id' => 'reloads']) ?>
        </div>
    </div>

   

 
 
 
 

   

    <?php ActiveForm::end(); ?>
</div>
    <?php
    $js = <<<JS
$('#reloads').click(function() {
    location.reload();
});        
JS;
    $this->registerJs($js);
    $js = <<<JS
    $(".reset").click(function() {
   $("select").each(function() { this.selectedIndex = 0 });
        $(this).closest('form').submit();
});
$('#reloads').click(function() {
    location.reload();
});        
JS;
    $this->registerJs($js);

    $css = <<<cs
 .select2-selection__rendered {
    width: 180px !important;
}
cs;
    $this->registerCss($css);
    ?>
<?php
$js = <<<js
        
        $(document).ready(function(){
            $("#download").click(function(event){
              $("#Searchform").attr({ "action":"/srlm/data/bcselection/reportpdf"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
        $("#searchbtn").click(function(event){
                
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

$this->registerJs($js);
?>

