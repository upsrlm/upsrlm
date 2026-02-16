<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\shg\models\ShgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "SHG's";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12">
        <div class="panel panel-default">
            <div class='panel-body'>
                <?php
                Pjax::begin([
                    'id' => 'grid-data',
                    'enablePushState' => FALSE,
                    'enableReplaceState' => FALSE,
                    'timeout' => false,
                ]);
                ?>

                <?php if (MasterRole::ROLE_BMMU == Yii::$app->user->identity->role) { ?>
                    <p>
                        <?= Html::a('Add SHG', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                <?php } ?>
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                <div class="col-lg-12">
                    <div class="col-xs-8 col-sm-8">
                        <div style="margin: 0px 24px 0px 10px;border: 0px">
                            <label class="control-label">Legends</label>
                        </div>
                        <div class="widget-box widget-color-green" style="font-size: 14px;height: 40px;margin: 0px 20px;border: 0px">
                            <div class="widget-header" style="height:25px;border:0px"><span class="badge" style="height:25px;width:40px;background-color: #82AF6F;color: black;font: 18;font-weight: bold">1</span> Sewer & STP fully comissioned; HSC under progress</div>
                        </div>
                        <div class="widget-box widget-color-green" style="font-size: 14px;height: 40px;margin: 0px 20px;border: 0px">
                            <div class="widget-header" style="height:25px;border:0px"><span class="badge" style="height:25px;width:40px;background-color: #82AF6F;color: black;font: 18;font-weight: bold">2</span> STP is comissioned & laying of sewer lines with HSC under progress</div>
                        </div>
                        <div class="widget-box widget-color-red2" style="font-size: 14px;height: 40px;margin: 0px 20px;border: 0px">
                            <div class="widget-header" style="height:25px;border:0px"><span class="badge" style="height:25px;width:40px;background-color: #E04141;color: black;font: 18;font-weight: bold">3</span> STP is not comissioned & laying of sewer lines with HSC under progress</div>
                        </div>
                        <div class="widget-box widget-color-orange" style="font-size: 14px;height: 40px;margin: 0px 20px;border: 0px;background-color: #E04141;">
                            <div class="widget-header" style="height:25px;border:0px;background-color: #FFC657;"><span class="badge" style="height:25px;width:40px;background-color: #FFC657;color: black;font: 18;font-weight: bold">4</span> STP and laying of Sewer lines and HSC under progress</div>
                        </div>
                        <div class="widget-box widget-color-orange" style="font-size: 14px;height: 40px;margin: 0px 20px;border: 0px;background-color: #E04141;">
                            <div class="widget-header" style="height:25px;border:0px;background-color: #FFC657;"><span class="badge" style="height:25px;width:40px;background-color: #FFC657;color: black;font: 18;font-weight: bold">5</span> Sewer lines comissioned & STP construction with HSC under progress</div>
                        </div>
                    </div>
                </div>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                    'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                    'id' => 'grid-data',
                    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                    'pjax' => TRUE,
                    'floatHeader' => true,
                    'floatHeaderOptions' => ['scrollingTop' => '50'],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                        [
                            'attribute' => 'name_of_shg',
                            'contentOptions' => ['style' => 'width: 8%'],
                            'enableSorting' => false,
                        ],
                        [
                            'attribute' => 'district_name',
                            'label' => 'District',
                            'contentOptions' => ['style' => 'width: 8%'],
                            'enableSorting' => false,
                        ],
                        [
                            'attribute' => 'block_name',
                            'label' => 'Block ',
                            'contentOptions' => ['style' => 'width: 8%'],
                            'enableSorting' => false,
                        ],
                        [
                            'attribute' => 'gram_panchayat_name',
                            'label' => 'Gram Panchayat ',
                            'contentOptions' => ['style' => 'width: 10%'],
                            'enableSorting' => false,
                        ],
                        [
                            'attribute' => 'village_name',
                            'label' => 'Rev. Village',
                            'contentOptions' => ['style' => 'width: 10%'],
                            'enableSorting' => false,
                        ],
                        [
                            'attribute' => 'hamlet',
                            'contentOptions' => ['style' => 'width: 10%'],
                            'enableSorting' => false,
                        ],
                        [
                            'attribute' => 'no_of_members',
                            'contentOptions' => ['style' => 'width: 5%'],
                            'enableSorting' => false,
                        ],
                        [
                            'attribute' => 'chaire_person_name',
                            'label' => 'Chair Person',
                            'contentOptions' => ['style' => 'width: 10%'],
                            'format' => 'html',
                            'enableSorting' => false,
                            'value' => function ($model) {
                                $mmodel = $model->getRmembers()->andWhere(['role' => 1])->one();
                                return isset($mmodel) ? $mmodel->name . "<br/>" . $mmodel->mobile : '';
                                //return $model->chaire_person_name . "<br/>" . $model->chaire_person_mobile_no;
                            }
                        ],
//            [
//                'attribute' => 'chaire_person_mobile_no',
//                'label' => 'Chair Person Mobile No.',
//                'contentOptions' => ['style' => 'width: 10%'],
//                'enableSorting' => false,
//            ],
                        [
                            'attribute' => 'secretary_name',
                            'label' => 'Secretary',
                            'contentOptions' => ['style' => 'width: 10%'],
                            'format' => 'html',
                            'enableSorting' => false,
                            'value' => function ($model) {
                                $mmodel = $model->getRmembers()->andWhere(['role' => 2])->one();
                                return isset($mmodel) ? $mmodel->name . "<br/>" . $mmodel->mobile : '';
                                //return $model->secretary_name . "<br/>" . $model->secretary_mobile_no;
                            }
                        ],
//            [
//                'attribute' => 'secretary_mobile_no',
//                'contentOptions' => ['style' => 'width: 10%'],
//                'enableSorting' => false,
//            ],
                        [
                            'attribute' => 'treasurer_name',
                            'label' => 'Treasurer',
                            'contentOptions' => ['style' => 'width: 10%'],
                            'format' => 'html',
                            'enableSorting' => false,
                            'value' => function ($model) {
                                $mmodel = $model->getRmembers()->andWhere(['role' => 3])->one();
                                return isset($mmodel) ? $mmodel->name . "<br/>" . $mmodel->mobile : '';
                                //return $model->treasurer_name . "<br/>" . $model->treasurer_mobile_no;
                            }
                        ],
                        [
                            'attribute' => 'Action',
                            'format' => 'raw',
                            'visible' => MasterRole::ROLE_YOUNG_PROFESSIONAL == Yii::$app->user->identity->role,
                            'contentOptions' => ['style' => 'width: 5%'],
                            'value' => function ($model) {

                                $html = '<span id="' . $model->id . '">';
                                if ($model->verify_mobile_no == 0) {
                                    $html .= yii\helpers\Html::button('<i class="fa fa-thumb-up"></i> Verify', ['id' => 'take-verify-' . $model->id, 'class' => 'btn btn-sm btn-warning btn-block popb', 'value' => '/shg/shg/verify?id=' . $model->id, 'name' => 'takeaction', 'title' => 'Verify']);
                                }
                                $html .= "</span>";
                                return $html;
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            //'visible' => MasterRole::ROLE_BMMU == Yii::$app->user->identity->role,
                            'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BMMU, MasterRole::ROLE_SMMU, MasterRole::ROLE_MD, MasterRole::ROLE_DC_NRLM]),
                            'template' => '{update}{view}',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    return (in_array($model->block_code, \yii\helpers\ArrayHelper::getColumn(Yii::$app->user->identity->blocks, 'block_code')) and $model->shg_code == null and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BMMU])) ? Html::a('<span class="fal fa-pencil"></span>', ['update?shgid=' . $model->id], [
                                        'class' => '',
                                        'data-pjax' => "0",
                                        'class' => 'btn btn-sm btn-primary',
                                    ]) : '';
                                },
                                'view' => function ($url, $model) {
                                    return ' ' . Html::a('<span class="fal fa-eye"></span>', ['/shg/view?shgid=' . $model->id], [
                                        'class' => '',
                                        'data-pjax' => "0",
                                        'class' => 'btn btn-sm btn-primary',
                                    ]);
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
    var loader = $(".ajax");
    $(document).on({
        ajaxStart: function () {
            loader.addClass("loader");
        },
        ajaxStop: function () {
            loader.removeClass("loader");
        }
    });
JS;
                $this->registerJs($script);
                ?>
                <?php
                $js = <<<JS
$(function () {
         
    $('.popb').click(function(){
        $('#imagecontent').html('');
        $('#modal').modal('show')
         .find('#imagecontent')
         .load($(this).attr('value'));
         document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i></h4>';     
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
                <?php Pjax::end(); ?> 
            </div>
        </div>
    </div> 
</div>     
