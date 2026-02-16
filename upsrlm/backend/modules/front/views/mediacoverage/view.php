<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\MediaCoverage */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Media Coverage', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'title',
                            'description:ntext',
                            'date',
                            'url:url',
                            'media_by',
                            [
                                'attribute' => 'type',
                                'value' => function ($model) {
                                    return $model->mediatype;
                                },
                            ],
                            [
                                'attribute' => 'file',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->file != null ? Html::a('<span class="fa fa-download"> Download</span>', Yii::$app->params['app_url']['www'] . '/uploads/media_coverage/' . $model->file, [
                                        'target' => '_blank',
                                        'data-pjax' => "0",
                                        'class' => 'btn btn-sm btn-primary',
                                    ]) : '';
                                }
                            ],
                        ],
                    ])
                    ?>

                </div>
            </div>     
        </div>
    </div>
</div>