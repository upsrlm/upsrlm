<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">

            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6" >
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table table-striped table-bordered detail-view'],
                        //'template' =>'<tr><td}>{label}</td><th>{value}</th></tr>',
                        'attributes' => [
                            [
                                'attribute' => 'name',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->application_model->name;
                                }
                            ],
                            [
                                'attribute' => 'district_name',
                                'enableSorting' => false,
                                'value' => $model->application_model->district_name,
                            ],
                        ],
                    ])
                    ?>

                </div>
                <div class="col-sm-6 col-md-6 col-lg-6" >

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'block_name',
                                'format' => 'html',
                                'value' => function ($model) {
                                    return $model->application_model->block_name;
                                }
                            ],
                            [
                                'attribute' => 'gram_panchayat_name',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->application_model->gram_panchayat_name;
                                }
                            ],
                        ],
                    ])
                    ?>
                </div> 
            </div> 
            <div class="row">
                <?php if ($model->application_model->bank_account_no_of_the_bc != null) { ?>        


                    <div class="col-sm-6 col-md-6 col-lg-6" >
                        Bank Detail OF BC
                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'options' => ['class' => 'table table-striped table-bordered detail-view'],
                            //'template' =>'<tr><td}>{label}</td><th>{value}</th></tr>',
                            'attributes' => [
                                [
                                    'attribute' => 'bank_account_no_of_the_bc',
                                    'label' => 'Bank account no of BC',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->application_model->bank_account_no_of_the_bc;
                                    }
                                ],
                                [
                                    'attribute' => 'name_of_bank',
                                    'label' => 'Name of bank',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return $model->application_model->name_of_bank;
                                    }
                                ],
                                [
                                    'attribute' => 'branch',
                                    'label' => 'Branch',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        return $model->application_model->branch;
                                    }
                                ],
                                [
                                    'attribute' => 'branch_code_or_ifsc',
                                    'label' => 'Branch code or IFSC',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return $model->application_model->branch_code_or_ifsc;
                                    }
                                ],
                            ],
                        ])
                        ?>
                        <?php if ($model->application_model->passbook_photo != null) { ?>
                            <table class="table table-responsive">
                                <tr>
                                    <th>पासबुक फोटो</th>

                                </tr> 
                                <tr>
                                    <td><?= $model->application_model->passbook_photo != null ? '<span class="profile-picture">
                                        <img  src="' .\Yii::$app->params['app_url']['bc']. $model->application_model->passbook_photo_url . '" data-src="' .\Yii::$app->params['app_url']['bc'].$model->application_model->passbook_photo_url . '"  class="img-thumbnail lozad" title="Passbook Photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?></td> 
                                </tr>
                            </table>
                        <?php } ?>     
                    </div>


                <?php } ?>  


                <?php
                if ($model->application_model->cbo_shg_id) {
                    $shg_model = cbo\models\Shg::findOne($model->application_model->cbo_shg_id);
                    ?>        


                    <div class="col-sm-6 col-md-6 col-lg-6" >
                        Bank Detail OF SHG
                        <?=
                        DetailView::widget([
                            'model' => $shg_model,
                            'options' => ['class' => 'table table-striped table-bordered detail-view'],
                            //'template' =>'<tr><td}>{label}</td><th>{value}</th></tr>',
                            'attributes' => [
                                [
                                    'attribute' => 'bank_account_no_of_the_shg',
                                    'label' => 'Bank account no of SHG',
                                    'format' => 'raw',
                                    'visible' => $shg_model->bank_account_no_of_the_shg != null,
                                    'value' => function ($model) {
                                        return $model->bank_account_no_of_the_shg;
                                    }
                                ],
                                [
                                    'attribute' => 'name_of_bank',
                                    'label' => 'Name of bank',
                                    'format' => 'html',
                                    'visible' => $shg_model->name_of_bank != null,
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return $model->name_of_bank;
                                    }
                                ],
                                [
                                    'attribute' => 'branch',
                                    'label' => 'Branch',
                                    'format' => 'html',
                                    'visible' => $shg_model->branch != null,
                                    'value' => function ($model) {
                                        return $model->branch;
                                    }
                                ],
                                [
                                    'attribute' => 'branch_code_or_ifsc',
                                    'label' => 'Branch code or IFSC',
                                    'format' => 'html',
                                    'visible' => $shg_model->branch_code_or_ifsc != null,
                                    'value' => function ($model) {
                                        return $model->branch_code_or_ifsc;
                                    }
                                ],
                            ],
                        ])
                        ?>
                        <?php if ($shg_model->passbook_photo != null) { ?>
                            <table class="table table-responsive">
                                <tr>
                                    <th>पासबुक फोटो </th>

                                </tr> 
                                <tr>
                                    <td><?= $shg_model->passbook_photo != null ? '<span class="profile-picture">
                                        <img  src="' . $shg_model->passbookUrl . '" data-src="' . $shg_model->passbookUrl . '"  class="img-thumbnail lozad" title="Passbook Photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?></td> 
                                </tr>
                            </table>
                            <?php
                        }
                    }
                    ?>  
                </div>

            </div>
            <div class="col-xl-12">
                <?php
                $form = ActiveForm::begin([
                            'enableClientValidation' => FALSE,
                            'enableAjaxValidation' => TRUE,
                            'options' => ['class' => 'form-horizontal', 'id' => 'approve-form', 'enctype' => 'multipart/form-data'],
                            'fieldConfig' => [
                                'template' => "{label}\n<div class=\"col-lg-6\">{input}{error}</div>",
                                'labelOptions' => ['class' => 'col-md-6 control-label'],
                            ],
                ]);
                ?>


                <?php echo $form->field($model, 'revert')->checkbox(); ?> 
                <div class="col-md-12">
                    <div class="text-center">
                        <?= Html::submitButton('<i class="fa fa-save"></i> Revert', ['class' => 'btn btn-success']) ?>
                        <button type="button" class="btn btn-danger" id="btnclose" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>        
        </div>
    </div>  
</div> 