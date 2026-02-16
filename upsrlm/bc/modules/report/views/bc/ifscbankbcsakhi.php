<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\helpers\Utility;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use yii\bootstrap4\Modal;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-2" class="panel">

            <div class="panel-container show">
                <div class="panel-content">

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'name',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return Html::a($model->name, "/report/bc/setelmentac194n?bcid=" . $model->id, ['target' => '_blank', 'data-pjax' => "0"]);
                                    return Html::a($model->name, '#', ['value' => '/report/bc/setelmentac194n?bcid=' . $model->id, 'data-pjax' => "0", 'title' => $model->name, 'class' => 'popb']);
                                }
                            ],
                            [
                                'attribute' => 'district_name',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->district_name;
                                }
                            ],
                            [
                                'attribute' => 'block_name',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->block_name;
                                }
                            ],
                            [
                                'attribute' => 'gram_panchayat_name',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->gram_panchayat_name;
                                }
                            ],
                            [
                                'attribute' => 'name_of_bank',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->bc_settlement_account_bank_name;
                                }
                            ],
                            [
                                'attribute' => 'onboarding_date_time',
                                'format' => 'html',
                                'header' => 'Onboarding Date',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->onboarding_date_time;
                                }
                            ],
                            [
                                'attribute' => 'bc_settlement_ac_194n',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'header' => 'BC settlement a/c tagged for 194N',
                                'value' => function ($model) {
                                    return $model->bc_settlement_ac_194n == '1' ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'pendency',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'header' => 'Pendency',
                                'value' => function ($model) {
                                    return round((time() - strtotime($model->onboarding_date_time)) / (60 * 60 * 24));
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_RBI]),
                                'template' => '{bc194n}',
                                'buttons' => [
                                    'bc194n' => function ($url, $model) {
                                        $html = '';
                                        if ($model->bc_settlement_ac_194n == 0) {

                                            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_RBI])) {
                                                
                                                $html.=Html::a('BC settlement a/c tagged for 194N', "/report/bc/setelmentac194n?bcid=" . $model->id, ['target' => '_blank', 'data-pjax' => "0",'class' => 'btn  btn-danger',]);
//                                                $html .= Html::button('<span class="">BC settlement a/c tagged for 194N</span>', [
//                                                            'data-pjax' => "0",
//                                                            'class' => 'btn  btn-danger popb',
//                                                            'value' => '/report/bc/setelmentac194n?bcid=' . $model->id,
//                                                            'title' => 'BC settlement a/c tagged for 194N of ' . $model->name
//                                                ]);
                                            }
                                        }
                                        return $html;
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
