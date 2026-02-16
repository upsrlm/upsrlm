<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;

$this->title = "Training list";
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
            Pjax::begin([
                'id' => 'grid-data',
                'enablePushState' => FALSE,
                'enableReplaceState' => FALSE,
                'timeout' => false,
            ]);
            ?>


            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
             <div class="clearfix pt-3"></div>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                'id' => 'grid-data',
                'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                'pjax' => TRUE,
//                'floatHeader' => true,
//                'floatHeaderOptions' => ['scrollingTop' => '50'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn', 'contentOptions' => [ 'class' => 'text-center']],
                    [
                        'attribute' => 'batch_name',
                        // 'contentOptions' => ['style' => 'width: 12%;'],
                        'format' => 'raw',
                        'enableSorting' => false,
                        'value' => function($model) {
                            return isset($model->tbatch) ? $model->tbatch->batch_name : '';
                        }
                    ],
                    [
                        'attribute' => 'training_start_date',
                        //'contentOptions' => ['style' => 'width: 8%;'],
                        'format' => 'raw',
                        'enableSorting' => false,
                        'value' => function($model) {
                            return date("d-m-Y", strtotime($model->training_start_date));
                        }
                    ],
                    [
                        'attribute' => 'training_end_date',
                        // 'contentOptions' => ['style' => 'width: 8%;'],
                        'format' => 'raw',
                        'enableSorting' => false,
                        'value' => function($model) {
                            return date("d-m-Y", strtotime($model->training_end_date));
                        }
                    ],
                    [
                        'attribute' => 'contact person',
                        //'contentOptions' => ['style' => 'width: 12%;'],
                        'format' => 'raw',
                        'enableSorting' => false,
                        'value' => function($model) {
                            $html = '';
                            if ($model->contacts != null) {
                                foreach ($model->contacts as $contact) {
                                    $html .= $contact->user->name . " (" . common\helpers\Utility::mask($contact->user->mobile_no) . ")" . "<br/>";
                                }
                            }
                            return $html;
                        }
                    ],
                    [
                        'attribute' => 'lead_bank',
                        'header' => 'RSETI Bank',
                        'format' => 'html',
                        // 'contentOptions' => ['style' => 'width: 12%'],
                        'enableSorting' => false,
                        'value' => function($model) {
                            return implode("<br/>", array_unique(yii\helpers\ArrayHelper::getColumn($model->rsethileadbank, 'profile.bank_name')));
                        },
                    ],
                    [
                        'attribute' => 'bc_bank_partner',
                        'header' => 'BC Partner Bank',
                        'format' => 'html',
                        //'contentOptions' => ['style' => 'width: 12%'],
                        'enableSorting' => false,
                        'value' => function($model) {
                            return isset($model->pbank->parnerbank)?$model->pbank->parnerbank->bank_name:'';
                        },
                    ],
                    [
                        'attribute' => 'District Name',
                        'header' => 'District',
                        'format' => 'html',
                        //'contentOptions' => ['style' => 'width: 8%'],
                        'enableSorting' => false,
                        'value' => function($model) {
                            return $model->district_name;
                        }
                    ],
                    [
                        'attribute' => 'schedule_date_of_exam',
                        // 'contentOptions' => ['style' => 'width: 10%'],
                        'enableSorting' => false,
                        'value' => function($model) {
                            return $model->schedule_date_of_exam != null ? \Yii::$app->formatter->asDatetime($model->schedule_date_of_exam, "php:d-m-Y") : "";
                        }
                    ],
                    [
                        'attribute' => 'no_of_participant',
                        'format' => 'html',
                        // 'contentOptions' => ['style' => 'width: 10%'],
                        'enableSorting' => false,
                        'value' => function($model) {
                            return $model->no_of_participant;
                        }
                    ],
                    [
                        'attribute' => 'batch_status',
                        'format' => 'html',
                        //'contentOptions' => ['style' => 'width: 10%'],
                        'enableSorting' => false,
                        'value' => function($model) {
                            return $model->batchstatus;
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_MD, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_BACKEND_OPERATOR, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_SPM_FINANCE,MasterRole::ROLE_VIEWER,MasterRole::ROLE_UPSRLM_RSETI_ANCHOR]),
                        'template' => '{view} {download}',
                        //'template' => '{view}',
                        'contentOptions' => ['style' => 'width: 6%'],
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<span class="fal fa-eye"></span>', ['view?trainingid=' . $model->id], [
                                    'title'=>'View training',
                                    'data-pjax' => "0",
                                    'class' => 'btn  btn-primary',
                                ]) . '';
                            },
                             'download' => function ($url, $model) {
                                return  Html::a('<span class="fal fa-download"></span>', ['/training/training/pdf/?trainingid=' . $model->id], [
                                    'title'=>'Download training',
                                    'data-pjax' => "0",
                                    'class' => 'btn  btn-primary',
                                    
                                ]);
                            },          
                        ]
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT]),
                        'template' => '{update}{delete}{unconculed}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<span class="fal fa-eye"></span>', ['view?trainingid=' . $model->id], [
                                    'title'=>'View training',
                                    'data-pjax' => "0",
                                    'class' => 'btn  btn-primary',
                                ]) . ' ';
                            },
                            'update' => function ($url, $model) {
                                return $model->status == 1 ? Html::a('<span class="fal fa-pencil"></span>', ['update?trainingid=' . $model->id], [
                                    'title'=>'Update training',
                                    'data-pjax' => "0",
                                    'class' => 'btn  btn-primary',
                                ]) . ' ' : '';
                            },
                            'delete' => function ($url, $model) {
                                return $model->no_of_participant == 0 ? Html::a('<span class="fal fa-times"></span>', ['/training/training/remove?trainingid=' . $model->id], [
                                    'title'=>'Delete training',
                                    'data-pjax' => "0",
                                    'class' => 'btn  btn-danger',
                                    'data' => [
                                        'confirm' => 'Are you absolutely sure remove this training ?this action not undone',
                                        'method' => 'post',
                                    ],
                                ]) : '';
                            },
                           'unconculed' => function ($url, $model) {
                                return ($model->status == 2 and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) ? Html::a('<span class="fa fa-undo"></span>', ['/training/training/unconclude?trainingid=' . $model->id], [
                                    'title'=>'Unconcluded training',
                                    'data-pjax' => "0",
                                    'class' => 'btn  btn-danger',
                                    'data' => [
                                        'confirm' => 'Are you absolutely sure Not Concluded this training ?this action not undone',
                                        'method' => 'post',
                                    ],
                                ]) : '';
                            },         
                        ]
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Upload Batch Group photo',
                        'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT]),
                        'template' => '{upload}',
                        'buttons' => [
                            'upload' => function ($url, $model) {
                                return ($model->no_of_participant !== 0 and $model->group_photo_status == 0) ? yii\helpers\Html::button('<i class="fa fa-upload"></i> Upload Group Photo', ['id' => 'call' . $model->id, 'class' => 'btn  btn-info popbc', 'value' => '/training/training/uploadgroupphoto?trainingid=' . $model->id, 'name' => 'upload', 'title' => 'Upload Group Photo: ']) : '';
                            },
                        ]
                    ],
                ],
            ]);
            ?>

            <?php
            $script = <<< JS
    $('form select').on('change', function(){
    $(this).closest('form').submit();
});            
    
JS;
            $this->registerJs($script);
            ?>
                        <?php
            $js = <<< JS
$(document).on('ready pjax:success', function() {
        function updateURLParameter(url, param, paramVal)
        {
        var TheAnchor = null;
        var newAdditionalURL = "";
        var tempArray = url.split("?");
        var baseURL = tempArray[0];
        var additionalURL = tempArray[1];
        var temp ="";                       
                                                              
        if (additionalURL)                                    
        {                                                     
            var tmpAnchor = additionalURL.split("#");         
            var TheParams = tmpAnchor[0];                     
            TheAnchor = tmpAnchor[1];                         
            if(TheAnchor)                                     
                additionalURL = TheParams;                    
                                                              
            tempArray = additionalURL.split("&");             
                                                              
            for (var i=0; i<tempArray.length; i++)            
            {                                                 
                if(tempArray[i].split('=')[0] != param)       
                {                                             
                    newAdditionalURL += temp + tempArray[i];  
                    temp = "&";                               
                }                                             
            }                                                 
        }                                                     
        else                                                  
        {                                                     
            var tmpAnchor = baseURL.split("#");               
            var TheParams = tmpAnchor[0];                     
            TheAnchor  = tmpAnchor[1];                        
                                                              
            if(TheParams)
                baseURL = TheParams;     
        }                                                                      
                                                                               
        if(TheAnchor)                                                          
            paramVal += "#" + TheAnchor;                                       
                                                                               
        var rows_txt = temp + "" + param + "=" + paramVal;                     
        return baseURL + "?" + newAdditionalURL + rows_txt;                    
    }

    $('.pagination li a').click(function(event){
            event.preventDefault(); 
            var page = $(this).data('page') + 1;
            var href = updateURLParameter(this.href, 'page', page); 
            $('#Searchform').prop('action', href);
            $('#Searchform').submit();
        });  
});
JS;
            $this->registerJs($js)
            ?>
            <?php
            $js = <<<JS
$(function () {      
   $('.popbc').click(function(){
        $('#imagecontent').html('');
        $('#modal').modal('show')
         .find('#imagecontent')
         .load($(this).attr('value'));
         document.getElementById('modalHeader').innerHTML = '' + $(this).attr('title') + '<i class="fal fa-times glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i>';     
        });
});  
        
JS;
            $this->registerJs($js);
            ?> 
            <?php
            Modal::begin([
                'headerOptions' => ['id' => 'modalHeader'],
                'id' => 'modal',
                'size' => 'modal-xl',
//    'options' => ['data-backdrop' => 'true',],
                'clientOptions' => [
//      'backdrop' => 'static',
//      'keyboard' => false,  
                ],
            ]);
            echo "<div id='imagecontent'></div>";
            Modal::end();
            ?>

            <?php Pjax::end(); ?> 
        </div>
    </div>
</div>    

