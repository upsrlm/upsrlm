<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;
?>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= 'Batches formed/ batch size' ?>
                </h2>

            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
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
                                    $html .= $contact->user->name . " (" . $contact->user->mobile_no . ")" . "<br/>";
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
                            $html = '';
                            if ($model->bcbankpartner != null) {
                                foreach ($model->bcbankpartner as $bcbankpartner) {
                                    $html .= $bcbankpartner->user->name . "<br/>";
                                }
                            }
                            return $html;
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
                        'visible' => 0,//in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_MD, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_BACKEND_OPERATOR, MasterRole::ROLE_SPM_FI_MF]),
                        'template' => '{view}',
//                        'template' => '{view}',
                        'contentOptions' => ['style' => 'width: 6%'],
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<span class="fa fa-eye"></span>', ['view?trainingid=' . $model->id], [
                                  
                                    'data-pjax' => "0",
                                    'class' => 'btn  btn-primary',
                                ]) . '';
                            },
                                  
                        ]
                    ],
                
                ],
            ]);
            ?>
                </div>
            </div>
        </div>    
    </div>
</div>
<?php
$js = <<<JS
$(function () {      
   $('.popb').click(function(){
        $('#imagecontent').html('');
        $('#modal').modal('show')
         .find('#imagecontent')
         .load($(this).attr('value'));
         document.getElementById('modalHeader').innerHTML = '' + $(this).attr('title') + '<i class="fal fa-times pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i>';     
        });
});  
        
JS;
$this->registerJs($js);
?> 

<?php
Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
//    'options' => ['data-backdrop' => 'true',],
    'clientOptions' => [
//      'backdrop' => 'static',
//      'keyboard' => false,  
    ],
]);
echo "<div id='imagecontent'></div>";
Modal::end();
?>
<?php
Modal::begin([
    'headerOptions' => ['id' => 'modalHeader1'],
    'id' => 'modal1',
    'size' => 'modal-md',
//    'options' => ['data-backdrop' => 'true',],
    'clientOptions' => [
//      'backdrop' => 'static',
//      'keyboard' => false,  
    ],
]);
echo "<div id='fcontent'></div>";
Modal::end();
?>  


<?php
$this->registerJs(
        '
function init_click_handlers(){

  $(".popb").click(function(e) {
            var fID = $(this).closest("tr").data("key");
            $("#modal").modal("show")
         .find("#imagecontent")
         .load($(this).attr("value"));
        });
       

}

init_click_handlers(); //first run
$("#grid-data").on("pjax:success", function() {
  init_click_handlers(); //reactivate links in grid after pjax update
});

');
?>
