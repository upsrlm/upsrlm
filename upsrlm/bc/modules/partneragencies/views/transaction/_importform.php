<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use bc\models\transaction\BcTransactionFiles;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;

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

                <?php if (isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT])) { ?>
                    <?php echo Html::a('Transactions w/o BC ID', ['wouniquebcid'], ['class' => 'btn btn-danger']) ?>
                <?php } ?>

            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <?php
                    $form = ActiveForm::begin([
                                'enableClientValidation' => TRUE,
                                'enableAjaxValidation' => false,
                                'options' => ['class' => 'form-horizontal', 'id' => 'upload-form', 'enctype' => 'multipart/form-data'],
                    ]);
                    ?>
                    <?php
                    if (isset(Yii::$app->user->identity) and !in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
                        echo $form->field($model, 'master_partner_bank_id')->widget(Select2::classname(), [
                            'data' => $model->bank_option,
                            'options' => ['placeholder' => 'Select Parner Bank', 'style' => 'width:200px'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Partner Bank');
                    }
                    ?>
                    <?= $form->field($model, 'label')->textInput() ?>
                    <?= $form->field($model, 'csvfile')->fileInput() ?>


                    <div class="col-lg-12">

                        <?= Html::submitButton('Upload', ['id' => 'buttonsave', 'class' => 'btn btn-info', 'value' => 'save', 'name' => 'save']) ?>
                        <?= Html::a('<i class="fal fa-download"></i> Download Sample CSV', ['/partneragencies/transaction/sample'], ['class' => 'btn btn-success ']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>  
                </div>     
            </div> 
        </div>

    </div>     
</div>            
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= 'BC Transaction Upload History ' ?>
                </h2>



            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{items}\n{summary}\n{pager}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'file_name',
                                'header' => 'Download uploaded file',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return "<a data-pjax ='0'  href='/partneragencies/transaction/importfile?fileid=$model->id'>" . "<i class='fal fa-download'></i> Download" . '<a>';
                                }
                            ],
                            [
                                'attribute' => 'label',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->label) ? $model->label : '';
                                }
                            ],
                            [
                                'attribute' => 'master_partner_bank_id',
                                'header' => 'Partner agencie',
                                'visible' => (isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])),
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->pbank) ? $model->pbank->bank_short_name : '';
                                }
                            ],
                            [
                                'attribute' => 'row_count',
                                'header' => 'Number of rows',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->row_count;
                                }
                            ],
                            [
                                'attribute' => 'upload_datetime',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->upload_datetime;
                                }
                            ],
                            [
                                'attribute' => 'status',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $array = [-3 => 'Request Delete', -2 => 'Delete in Process', -1 => 'Deleted', 0 => 'File Uploaded', 1 => 'File In Process', 2 => 'File In Process', 3 => 'File Proccesed', 11 => 'File Error'];
                                    return $array[$model->new_process];
                                }
                            ],
                            [
                                'attribute' => 'new',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->new_process == 3 ? $model->new : '';
                                }
                            ],
                            [
                                'attribute' => 'repeats',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->new_process == 3 ? $model->repeats : '';
                                }
                            ],
                            [
                                'attribute' => 'error',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->new_process == 3 ? $model->error : '';
                                }
                            ],
                            [
                                'attribute' => 'file_name',
                                'header' => 'Download error file',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return ($model->new_process == 3 and $model->error) ? "<a data-pjax ='0'  href='/partneragencies/transaction/errorfile?fileid=$model->id'>" . "<i class='fal fa-download'></i> Download" . '<a>' : '';
                                }
                            ],
                            [
                                'attribute' => 'file_name',
                                'header' => 'View Error in file',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return ($model->new_process == 3 and $model->error) ? "<a data-pjax ='0'  href='/partneragencies/transaction/errordetail?fileid=$model->id'>" . "<i class='fal fa-error'></i> View error" . '<a>' : '';
                                }
                            ],
                            [
                                'attribute' => 'Action',
                                'format' => 'raw',
                                'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]),
                                'contentOptions' => ['style' => 'width: 5%'],
                                'value' => function ($model) {
                                    $html = '';
                                    if ($model->new_process == 3) {
                                        $html .= Html::a('<span class="fal fa-undo"> Delete</span>', ['/partneragencies/transaction/delete?fileid=' . $model->id], [
                                                    'data-pjax' => "0",
                                                    'class' => 'btn btn-sm btn-danger',
                                                    'data' => [
                                                        'confirm' => 'Are you absolutely sure this transaction file? this action not undon',
                                                        'method' => 'post',
                                                    ],
                                        ]);
                                    }
                                    return $html;
                                }
                            ],
                        ],
                    ]);
                    ?>
                </div>

            </div>

        </div>

    </div>
</div>














