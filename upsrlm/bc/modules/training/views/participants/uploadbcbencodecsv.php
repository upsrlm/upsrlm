<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use bc\modules\selection\models\BcFiles;
use kartik\grid\GridView;
use yii\widgets\Pjax;

$this->title = $model->page_title;
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

                    <?php if (!empty($model->rows) and $model->form == BcFiles::FORM_REPLACE_BC_PFMS) { ?>
                        <table class="table">
                            <thead>
                                <tr>    
                                    <th>Sr No.</th>    
                                    <th>District</th>
                                    <th>Block</th>
                                    <th>GP</th>
                                    <th>BC Beneficiaries Code</th>
                                    <th>New Vender Code</th>
                                    <th>BC Sakhi Name</th>
                                    <th>Error</th>
                                </tr>
                            </thead>   
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($model->rows as $row) {
                                    ?>

                                    <tr>    
                                        <td><?= $no ?></td>    
                                        <td><?= $row[0] ?></td>    
                                        <td><?= $row[1] ?></td>    
                                        <td><?= $row[2] ?></td>    
                                        <td><?= $row[3] ?></td>    
                                        <td><?= $row[4] ?></td>    
                                        <td><?= $row[5] ?></td>    

                                        <td><?= isset($row[6]) ? '<span class="text-danger">' . $row[6] . '</span>' : '<span class="text-success">success</span>' ?></td>    
                                    </tr>  

                                    <?php
                                    $no++;
                                }
                                ?>
                            </tbody>

                        </table>
                    <?php } ?>        

                </div>
                <?php
                $form = ActiveForm::begin([
                            'enableClientValidation' => TRUE,
                            'enableAjaxValidation' => false,
                            'options' => ['class' => 'form-horizontal', 'id' => 'upload-form', 'enctype' => 'multipart/form-data'],
                ]);
                ?>
                <div class="hide">
                    <?= $form->field($model, 'fileid')->hiddenInput()->label('') ?>
                </div> 
                <div class="row">
                    <div class="col-lg-5"> 
                        <div class="panel panel-info">
                            <div class="col-lg-12">
                                <?php if ($model->error == true or $model->fileid == null) { ?>
                                    <div class="alert"> Note : Maximum 100 rows allowed</div>
                                    <?= $form->field($model, 'label')->textInput() ?>
                                    <?= $form->field($model, 'csvfile')->fileInput() ?>
                                <?php } ?>
                            </div>

                            <div class="col-lg-12 pt-3">
                                <?php if ($model->error == true or $model->fileid == null) { ?>
                                    <?= Html::submitButton('Upload', ['id' => 'buttonsave', 'class' => 'btn btn-info', 'value' => 'save', 'name' => 'save']) ?>
                                <?php } else { ?>
                                    <?= Html::submitButton('Continue', ['id' => 'buttoncontinue', 'class' => 'btn btn-info', 'value' => 'continue', 'name' => 'continue']) ?>
                                <?php } ?>
                                <?= Html::a('<i class="fal fa-download"></i> Download Sample CSV', [$model->sample_csv_url], ['class' => 'btn btn-info ']) ?>
                            </div>

                        </div>     
                    </div> 
                    
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>













