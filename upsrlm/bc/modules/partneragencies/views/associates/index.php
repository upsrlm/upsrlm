<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
//use yii\bootstrap\Modal;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $searchModel bc\models\PartnerAssociatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Field Associates';
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
                    <?php if (isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) { ?>
                        <?= Html::a('Add Field Associates', ['create'], ['class' => 'btn btn-success']) ?>
                    <?php } ?>
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
                    <div class="clearfix pt-6"></div>

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{summary}\n{items}\n{summary}\n{pager}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
//                        'floatHeader' => true,
//                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                        'pager' => [
                            'options' => ['class' => 'pagination'],
                            'prevPageLabel' => 'Previous',
                            'nextPageLabel' => 'Next',
                            'firstPageLabel' => 'First',
                            'lastPageLabel' => 'Last',
                            'nextPageCssClass' => 'paginate_button page-item',
                            'prevPageCssClass' => 'paginate_button page-item',
                            'firstPageCssClass' => 'paginate_button page-item',
                            'lastPageCssClass' => 'paginate_button page-item',
                            'maxButtonCount' => 10,
                        ],
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
//                        'contentOptions' => ['style' => 'width: 4%']
                            ],
                            [
                                'attribute' => 'name_of_the_field_officer',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->name_of_the_field_officer;
                                }
                            ],
                            [
                                'attribute' => 'gender',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->gen;
                                }
                            ],
                            [
                                'attribute' => 'age',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->age;
                                }
                            ],
                            [
                                'attribute' => 'designation',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->designation;
                                }
                            ],
                            [
                                'attribute' => 'mobile_no',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->mobile_no;
                                }
                            ],
                            [
                                'attribute' => 'name_of_supervisor',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->name_of_supervisor;
                                }
                            ],
                            [
                                'attribute' => 'designation_of_supervisor',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->designation_of_supervisor;
                                }
                            ],
                            [
                                'attribute' => 'District',
                                'header' => 'District',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $html = '';

                                    $html .= implode(', ', array_unique(ArrayHelper::getColumn($model->disblock, 'district.district_name')));

                                    return $html;
                                },
                            ],
                            [
                                'attribute' => 'Block',
                                'header' => 'Block',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $html = '';

                                    $html .= '' . implode(', ', array_unique(ArrayHelper::getColumn($model->disblock, 'block.block_name')));

                                    return $html;
                                },
                            ],
                            //'name_of_supervisor',
                            //'designation_of_supervisor',
                            //'mobile_no_of_supervisor',
                            //'bank_name',
                            //'bank_branch',
                            //'bank_ifsc_code',
                            //'bank_account_number',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'visible' => isset(Yii::$app->user->identity) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DC_NRLM]),
                                'template' => '{view}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        return Html::a('<i class="fal fa fa-eye"></i>', ['view', 'id' => $model->id], [
                                            'title' => 'View',
                                            'data-pjax' => "0",
                                            'class' => 'btn  btn-info',
                                        ]) . ' ';
                                    },
                                    
                                ]
                            ],            
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'visible' => isset(Yii::$app->user->identity) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL]),
                                'template' => '{view}{update}{remove}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        return Html::a('<i class="fal fa fa-eye"> View</i>', ['view', 'id' => $model->id], [
                                            'title' => 'View',
                                            'data-pjax' => "0",
                                            'class' => 'btn  btn-info mb-2',
                                        ]) . ' ';
                                    },
                                    'update' => function ($url, $model) {
                                        return Html::a('<i class="fal fa fa-edit"> Update</i>', ['update', 'id' => $model->id], [
                                            'title' => 'Update',
                                            'data-pjax' => "0",
                                            'class' => 'btn  btn-info mb-2',
                                        ]) . ' ';
                                        ;
                                    },
                                    'remove' => function ($url, $model) {
                                        return Html::a('<i class="fal fa-times"> Delete</i>', ['remove?id=' . $model->id], [
                                                     'title' => 'delete',
                                                    'data-pjax' => "0",
                                                    'class' => 'btn btn-sm btn-danger mb-2',
                                                    'data' => [
                                                        'confirm' => 'Are you absolutely sure delete this Field Associate? this action not undon',
                                                        'method' => 'post',
                                                    ],
                                        ]) . ' ';
                                        ;
                                    },        
                                ]
                            ],
                        ],
                    ]);
                    ?>
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    
    $("#Searchform").attr("data-pjax", "True");                
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
                    <?php Pjax::end(); ?> 
                </div>
            </div>
        </div> 
    </div>
</div>
