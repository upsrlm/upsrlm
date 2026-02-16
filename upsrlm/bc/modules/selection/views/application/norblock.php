<?php

use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use common\models\User;
use yii\bootstrap4\Modal;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2
?>
<div class="master-block-index">

    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <!--Basic tables-->
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <!--                    <h2>
                    <?= $this->title ?>
                                        </h2>-->
                    <div class="panel-toolbar">

                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
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
                                ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%']],
                                [
                                    'attribute' => 'District',
                                    'contentOptions' => ['style' => 'width: 15%'],
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return $model->district != null ? $model->district->district_name : '';
                                    },
                                ],
                                [
                                    'attribute' => 'block_name',
                                    'contentOptions' => ['style' => 'width: 15%'],
                                    'enableSorting' => false,
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
                               
                            ],
                        ]);
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>        
