<?php

use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use app\models\UserModel;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\master\MasterBlockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'District';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="master-block-index">
    <div style="text-align: right"> Time : <?= date('d-m-Y h:i:s') ?></div><br/>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}<div class=\"row\">",
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
            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%']],
            [
                'attribute' => 'district_code',
                'contentOptions' => ['style' => 'width: 15%'],
                'enableSorting' => false,
            ],
            [
                'attribute' => 'District',
                'contentOptions' => ['style' => 'width: 15%'],
                'enableSorting' => false,
                'value' => function ($model) {
                    return $model->district_name;
                },
            ],
            [
                'attribute' => 'Total Registration',
                'header' => 'Total Registration',
                'format' => 'raw',
                'contentOptions' => ['data-title' => 'Total Registration'],
                'value' => function($model) {
                    return $model->getBcall()->count();
                }
            ],
            [
                'attribute' => 'Registration Start',
                'header' => 'Registration Start',
                'format' => 'raw',
                'contentOptions' => ['data-title' => 'Registration Start'],
                'value' => function($model) {
                    return $model->getBasicprofile()->count();
                }
            ],
            [
                'attribute' => 'Application complete',
                'format' => 'raw',
                'contentOptions' => ['data-title' => 'Application complete'],
                'value' => function($model) {
                    return $model->getPart4()->count();
                }
            ],
        ],
    ]);
    ?>


</div>        
