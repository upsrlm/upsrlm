<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model bc\models\NotificationLog */

$this->title = $model->message_title;
$this->params['breadcrumbs'][] = ['label' => 'Notification Logs', 'url' => ['index']];
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
                            'notification_type',
                            'notification_sub_type',
                            'detail_id',
                            'user_id',
                            'app_id',
                            'visible',
                            'acknowledge',
                            'message_title:ntext',
                            'message:ntext',
                            'genrated_on',
                            'send_datetime',
                            'acknowledge_status',
                            'acknowledge_date',
                            'send_count',
                            'cron_status',
                            'status',
                        ],
                    ])
                    ?>
                </div>
            </div>     
        </div>
    </div>     
</div>
