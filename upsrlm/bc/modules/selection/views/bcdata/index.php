<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;


$this->title = 'BC list';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => FALSE,
    'enableReplaceState' => FALSE,
    'timeout' => false,
]);
?>
<div class="pfa-domestic-premium-freight-index">

    <div class="box">
        <div class="box box-primary"> 
            <div class="box-body no-padding">

                <div class="row-fluid" style="padding-top:5px;padding-bottom:5px">
                    <?php
//                    echo $this->render('_search', [
//                        'model' => $searchModel
//                    ]);
                    ?>
                </div>
                <div class="clearfix"></div>
                <div id="no-more-tables" class="no-more-tables">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 50px;', 'data-title' => '#']],
                            [
                                'attribute' => 'district_name',
                                'header' => 'district',
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'District name'],
                                'contentOptions' => ['style' => 'width: 20%'],
                                'value' => function($model) {
                                    return "<a data-pjax ='0'   target='_blank' href='/nfsaSurvey/data/survey?DashboardSearchForm[district_code]=$model->district_code&DashboardSearchForm[area]=1$searchModel->filter_uri'>" . $model->district_name . '<a>';
                                    //return $model->district_name;
                                }
                            ],
//                            [
//                                'attribute' => 'Total Hhs Covered',
//                                'header' => 'Total Hhs Covered',
//                                'format' => 'raw',
//                                'contentOptions' => ['data-title' => 'Total Hhs Covered'],
//                                'value' => function($model) {
//                                    return "<a data-pjax ='0'   target='_blank' href='/nfsaSurvey/data/survey?DashboardSearchForm[district_code]=$model->district_code'>" . $model->getHhscovered()->count() . '<a>';
//                                }
//                            ],
//                            [
//                                'attribute' => 'Total Hhs Covered ',
//                                'header' => 'Total Hhs Covered (Urban)',
//                                'format' => 'raw',
//                                'contentOptions' => ['data-title' => 'Total Hhs Covered'],
//                                'value' => function($model) use ($searchModel) {
//                                    $query = $model->getHhscoveredurban();
//                                    if (isset($searchModel->filters) and is_array($searchModel->filters)) {
//                                        foreach ($searchModel->filters as $val) {
//                                            if ($val == 1) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.type_of_asset_house2' => 3]);
//                                            } elseif ($val == 2) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.type_of_asset_house2' => 1]);
//                                            } elseif ($val == 3) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.type_of_asset_house2' => 2]);
//                                            } elseif ($val == 4) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.toilet_facilities' => 4]);
//                                            } elseif ($val == 5) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.toilet_facilities' => 2]);
//                                            } elseif ($val == 6) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.ess_nrega_job_card' => 2]);
//                                            } elseif ($val == 7) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.bank_account_number' => 0]);
//                                            }
//                                        }
//                                    }
//                                    return "<a data-pjax ='0'   target='_blank' href='/nfsaSurvey/data/survey?DashboardSearchForm[district_code]=$model->district_code&DashboardSearchForm[area]=2$searchModel->filter_uri'>" . $query->count() . '<a>';
//                                }
//                            ],
                            [
                                'attribute' => 'Total Hhs Covered ',
                                'header' => 'Total Hhs',
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'Total Hhs Covered'],
                                'value' => function($model) use ($searchModel) {
                                    $query = $model->getHhscoveredrural();
                                    if (isset($searchModel->filters) and is_array($searchModel->filters)) {
                                        foreach ($searchModel->filters as $val) {
                                            if ($val == 1) {
                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.type_of_asset_house2' => 3]);
                                            } elseif ($val == 2) {
                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.type_of_asset_house2' => 1]);
                                            } elseif ($val == 3) {
                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.type_of_asset_house2' => 2]);
                                            } elseif ($val == 4) {
                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.toilet_facilities' => 4]);
                                            } elseif ($val == 5) {
                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.toilet_facilities' => 2]);
                                            } elseif ($val == 6) {
                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.ess_nrega_job_card' => 2]);
                                            } elseif ($val == 7) {
                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.bank_account_number' => 0]);
                                            }
                                        }
                                    }
                                    return "<a data-pjax ='0'   target='_blank' href='/nfsaSurvey/data/survey?DashboardSearchForm[district_code]=$model->district_code&DashboardSearchForm[area]=1$searchModel->filter_uri'>" . $query->count() . '<a>';
                                }
                            ],
//                            [
//                                'attribute' => 'Total Hhs Verified',
//                                'header' => 'Total Hhs Verified',
//                                'format' => 'raw',
//                                'contentOptions' => ['data-title' => 'Total Hhs Eligible'],
//                                'value' => function($model) use ($searchModel) {
//                                    $query = $model->getHhseligble();
//                                    if (isset($searchModel->filters) and is_array($searchModel->filters)) {
//                                        foreach ($searchModel->filters as $val) {
//                                            if ($val == 1) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.type_of_asset_house2' => 3]);
//                                            } elseif ($val == 2) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.type_of_asset_house2' => 1]);
//                                            } elseif ($val == 3) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.type_of_asset_house2' => 2]);
//                                            } elseif ($val == 4) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.toilet_facilities' => 4]);
//                                            } elseif ($val == 5) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.toilet_facilities' => 2]);
//                                            } elseif ($val == 6) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.ess_nrega_job_card' => 2]);
//                                            } elseif ($val == 7) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.bank_account_number' => 0]);
//                                            }
//                                        }
//                                    }
//                                    return "<a data-pjax ='0'   target='_blank' href='/nfsaSurvey/data/survey?DashboardSearchForm[district_code]=$model->district_code&DashboardSearchForm[status]=33$searchModel->filter_uri'>" . $query->count() . '<a>';
//                                    //return $model->getHhseligble()->count();
//                                }
//                            ],
//                            [
//                                'attribute' => 'Submitted to DSO',
//                                'header' => 'Submitted to DSO',
//                                'format' => 'raw',
//                                'contentOptions' => ['data-title' => 'Submitted to DSO'],
//                                'value' => function($model) use ($searchModel) {
//                                    $query = $model->getHhssubmittedtodso();
//                                    if (isset($searchModel->filters) and is_array($searchModel->filters)) {
//                                        foreach ($searchModel->filters as $val) {
//                                            if ($val == 1) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.type_of_asset_house2' => 3]);
//                                            } elseif ($val == 2) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.type_of_asset_house2' => 1]);
//                                            } elseif ($val == 3) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.type_of_asset_house2' => 2]);
//                                            } elseif ($val == 4) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.toilet_facilities' => 4]);
//                                            } elseif ($val == 5) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.toilet_facilities' => 2]);
//                                            } elseif ($val == 6) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.ess_nrega_job_card' => 2]);
//                                            } elseif ($val == 7) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.bank_account_number' => 0]);
//                                            }
//                                        }
//                                    }
//                                    return "<a data-pjax ='0'   target='_blank' href='/nfsaSurvey/data/survey?DashboardSearchForm[district_code]=$model->district_code&DashboardSearchForm[status]=33&DashboardSearchForm[submitted_to_dso ]=1$searchModel->filter_uri'>" . $query->count() . '<a>';
//                                    //return $model->getHhseligble()->count();
//                                }
//                            ],
//                            [
//                                'attribute' => 'Not Submitted to DSO',
//                                'header' => 'Not Submitted to DSO',
//                                'format' => 'raw',
//                                'contentOptions' => ['data-title' => 'Not Submitted to DSO'],
//                                'value' => function($model) use ($searchModel) {
//                                    $query = $model->getHhsnotsubmittedtodso();
//                                    if (isset($searchModel->filters) and is_array($searchModel->filters)) {
//                                        foreach ($searchModel->filters as $val) {
//                                            if ($val == 1) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.type_of_asset_house2' => 3]);
//                                            } elseif ($val == 2) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.type_of_asset_house2' => 1]);
//                                            } elseif ($val == 3) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.type_of_asset_house2' => 2]);
//                                            } elseif ($val == 4) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.toilet_facilities' => 4]);
//                                            } elseif ($val == 5) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.toilet_facilities' => 2]);
//                                            } elseif ($val == 6) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.ess_nrega_job_card' => 2]);
//                                            } elseif ($val == 7) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.bank_account_number' => 0]);
//                                            }
//                                        }
//                                    }
//                                    return "<a data-pjax ='0'   target='_blank' href='/nfsaSurvey/data/survey?DashboardSearchForm[district_code]=$model->district_code&DashboardSearchForm[status]=33&DashboardSearchForm[submitted_to_dso ]=0$searchModel->filter_uri'>" . $query->count() . '<a>';
//                                    //return $model->getHhseligble()->count();
//                                }
//                            ],
//                            [
//                                'attribute' => 'Application Received',
//                                'header' => 'Application Received',
//                                'format' => 'raw',
//                                'contentOptions' => ['data-title' => 'Application Received'],
//                                'value' => function($model) use ($searchModel) {
//                                    $query = $model->getHhsapplicationrecivedbydso();
//                                    if (isset($searchModel->filters) and is_array($searchModel->filters)) {
//                                        foreach ($searchModel->filters as $val) {
//                                            if ($val == 1) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.type_of_asset_house2' => 3]);
//                                            } elseif ($val == 2) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.type_of_asset_house2' => 1]);
//                                            } elseif ($val == 3) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.type_of_asset_house2' => 2]);
//                                            } elseif ($val == 4) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.toilet_facilities' => 4]);
//                                            } elseif ($val == 5) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.toilet_facilities' => 2]);
//                                            } elseif ($val == 6) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.ess_nrega_job_card' => 2]);
//                                            } elseif ($val == 7) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.bank_account_number' => 0]);
//                                            }
//                                        }
//                                    }
//                                    return "<a data-pjax ='0'   target='_blank' href='/nfsaSurvey/data/survey?DashboardSearchForm[district_code]=$model->district_code&DashboardSearchForm[status]=5$searchModel->filter_uri'>" . $query->count() . '<a>';
//                                    //return $model->getHhseligble()->count();
//                                }
//                            ],
//                            [
//                                'attribute' => 'Total Hhs Not Eligible',
//                                'format' => 'raw',
//                                'contentOptions' => ['data-title' => 'Total Hhs Not Eligible'],
//                                'value' => function($model) use ($searchModel) {
//                                    $query = $model->getHhsnoteligble();
//                                    if (isset($searchModel->filters) and is_array($searchModel->filters)) {
//                                        foreach ($searchModel->filters as $val) {
//                                            if ($val == 1) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.type_of_asset_house2' => 3]);
//                                            } elseif ($val == 2) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.type_of_asset_house2' => 1]);
//                                            } elseif ($val == 3) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.type_of_asset_house2' => 2]);
//                                            } elseif ($val == 4) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.toilet_facilities' => 4]);
//                                            } elseif ($val == 5) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.toilet_facilities' => 2]);
//                                            } elseif ($val == 6) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.ess_nrega_job_card' => 2]);
//                                            } elseif ($val == 7) {
//                                                $query->andWhere([NfsaBaseSurvey::getTableSchema()->fullName . '.bank_account_number' => 0]);
//                                            }
//                                        }
//                                    }
//                                    return "<a data-pjax ='0'   target='_blank' href='/nfsaSurvey/data/survey?DashboardSearchForm[district_code]=$model->district_code&DashboardSearchForm[status]=34$searchModel->filter_uri'>" . $query->count() . '<a>';
//                                    //return $model->getHhsnoteligble()->count();
//                                }
//                            ],
//                            [
//                                'attribute' => 'Total Hhs Skip',
//                                'format' => 'raw',
//                                'contentOptions' => ['data-title' => 'Total Hhs Skip'],
//                                'value' => function($model) {
//                                     return "<a data-pjax ='0'   target='_blank' href='/nfsaSurvey/data/survey?DashboardSearchForm[district_code]=$model->district_code&DashboardSearchForm[status]=4'>" . $model->getHhsskip()->count() . '<a>';
//                                    //return $model->getHhsskip()->count();
//                                }
//                            ],
                            [
                                'class' => 'kartik\grid\ExpandRowColumn',
                                'width' => '100px',
                                'header' => 'Block',
                                'value' => function ($model, $key, $index, $column) use ($searchModel) {
                                    return GridView::ROW_COLLAPSED;
                                },
                                'detail' => function ($model, $key, $index, $column) use ($searchModel) {
                                    return Yii::$app->controller->renderPartial('block', ['model' => $model,'searchModel'=>$searchModel]);
                                },
                                'headerOptions' => ['class' => 'kartik-sheet-style'],
                                'expandOneOnly' => true
                            ],
                        ],
                    ]);
                    ?>

                </div>
            </div>
        </div>  
    </div>   
</div>
<?php Pjax::end(); ?>
