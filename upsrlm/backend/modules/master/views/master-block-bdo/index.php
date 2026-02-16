
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MasterTownSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Block BDO List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-town-index">

    <?php
    Pjax::begin([
        'id' => 'grid-data',
        'enablePushState' => FALSE,
        'enableReplaceState' => FALSE,
        'timeout' => false,
    ]);
    ?>
    <div class="card">
        <div class="card-body">
            <?php
            echo $this->render('_search', ['model' => $searchModel]);
            ?>
        </div>
    </div>
    </br>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <strong class="card-title"><h2><i class="ace-icon fa fa fa-table"> </i> <?= $this->title ?></h2></strong>
                </div>
                <div class="col-md-6">
                    <div class="text-right"> <?= Html::a('<span class="glyphicon glyphicon-download"></span>Download ', ['download'], ['class' => 'btn btn-info pull-right', 'data-pjax' => 0]) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body"> 

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'id' => 'grid-datar',
                'layout' => "<div class=\"row\"><div class=\"col-lg-6\">{summary}</div></div>{items}<div class=\"row\"><div class=\"col-lg-6\">{summary}</div><div class=\"col-lg-6 pull-right\">{pager}</div></div>",
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
                    ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 6s%']],
                    [
                        'attribute' => 'district',
                        'format' => 'raw',
                        'enableSorting' => false,
                        'label' => 'District Name',
                        'value' => function($data) {
                            return $data->district ? $data->district : '';
                        }
                    ],
                    [
                        'attribute' => 'role',
                        'format' => 'raw',
                        'enableSorting' => false,
                        'value' => function($data) {
                            return $data->role ? $data->role : '';
                        }
                    ],
                    [
                        'attribute' => 'block',
                        'format' => 'raw',
                        'enableSorting' => false,
                        'label' => 'Block Name',
                        'value' => function($data) {
                            return $data->block ? $data->block : '';
                        }
                    ],
                    [
                        'attribute' => 'mobile_no',
                        'format' => 'raw',
                        'enableSorting' => false,
                        'label' => 'Mobile No.',
                        'value' => function($data) {
                            return $data->mobile_no ? $data->mobile_no : '';
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'enableSorting' => false,
                        'label' => 'Status',
                        'value' => function($data) {

                            if ($data->status == 1) {
                                return "Active";
                            } else {
                                return "Inactive";
                            }
                        }
                    ],
//                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>
        </div>
    </div>
            <?php Pjax::end(); ?> 

