<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

$this->title = 'Saree distribution';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                <div class="panel-toolbar">

                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <?php
                    $form = ActiveForm::begin([
                                'layout' => 'horizontal',
                                'fieldConfig' => [
                                    'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                                    'horizontalCssClasses' => [
                                        'label' => 'col-sm-3',
                                        'offset' => 'offset-sm-1',
                                        'input' => 'col-sm-4',
                                        'wrapper' => 'col-sm-8',
                                        'error' => 'col-sm-4',
                                        'hint' => '',
                                    ],
                                ],
                                'enableClientValidation' => TRUE,
                                'enableAjaxValidation' => false,
                                'options' => ['id' => 'upload-form', 'enctype' => 'multipart/form-data'],
                    ]);
                    ?>

                    <div class="row">
                        <div class="col-lg-10"> 
                            <div class="panel panel-info">
                                <div class="col-lg-12">

                                    <div class="panel-tag"> Note : Maximum 500 rows allowed</div>
                                    <?php
                                    echo $form->field($model, 'saree')->widget(Select2::classname(), [
                                        'bsVersion' => '4.x',
                                        'data' => [1 => 'First Saree', '2' => 'Second Saree'],
                                        'options' => ['placeholder' => 'Saree', 'style' => 'width:250px'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                    ?>
                                    
                                    <?php
                                    echo $form->field($model, "distribution_date")->widget(DatePicker::classname(), [
                                        'bsVersion' => '4.x',
                                        'value' => $model->distribution_date,
                                        'options' => ['placeholder' => 'Distribution Saree Date', 'class' => 'calculateday', 'readonly' => 'readonly'],
                                        'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                                        'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                                        'pluginOptions' => [
                                            'orientation' => 'bottom',
                                            'format' => 'yyyy-mm-dd',
                                            'todayHighlight' => true,
                                            'autoclose' => true,
                                            'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { console.log(dateText, inst) }'),
                                        ],
                                        'pluginEvents' => [
                                            "changeDate" => "function(e) { "
                                            . "}",
                                        ]
                                    ]);
                                    ?> 
                                    <?= $form->field($model, 'file_name')->fileInput() ?>

                                </div>

                                <div class="col-lg-12 pt-3">

                                    <?= Html::submitButton('Upload', ['id' => 'buttonsave', 'class' => 'btn btn-info', 'value' => 'save', 'name' => 'save']) ?>

                                    <?= Html::a('<i class="fal fa-download"></i> Download Sample CSV', [$model->sample_csv_url], ['class' => 'btn btn-info ']) ?>
                                </div>

                            </div>     
                        </div> 

                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

    </div>
</div>
<?php if (!empty($model->rows)) { ?>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        <?= 'Errors' ?>
                    </h2>

                </div>
                <table class="table">
                    <thead>
                        <tr>    

                            <th>Application Id</th>
                          
                            <th>Error</th>
                        </tr>
                    </thead>   
                    <tbody>
                        <?php
                        foreach ($model->rows as $row) {
                            $no = 1;
                            ?>
                            <tr>    

                                <td><?= $row[0] ?></td>      


                                <td><?= isset($row[1]) ? '<span class="text-danger">' . $row[1] . '</span>' : '<span class="text-success">success</span>' ?></td>    
                            </tr>  

                        <?php } ?>
                    </tbody>

                </table>   


            </div>
        </div>
    </div>
<?php } ?>











