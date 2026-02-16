<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model bc\models\NotificationTemplate */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Notification Templates', 'url' => ['index']];
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
                            'id',
                            'name:ntext',
                            'template:ntext',
                            [
                                'attribute' => 'visible',
                                'value' => function ($model) {
                                    return $model->visible == 1 ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'acknowledge',
                                'value' => function ($model) {
                                    return $model->acknowledge == 1 ? 'Yes' : 'No';
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
