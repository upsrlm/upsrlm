<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ApiLog */

$this->title = 'View';
$this->params['breadcrumbs'][] = ['label' => 'Api Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="api-log-view">
    <div class="card-box">

        <div class="row">
            <div class="col-12">
                <div class="table-header">    
                    <div><h2><i class="ace-icon fa fa-sun-o"> </i> <?= $this->title ?></h2></div>
                </div>

                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'app_id',
                        'version_no',
                        'imei_no',
                        'ip',
                        'time',
                        'request_body:ntext',
                        'request_url:url',
                        'http_response_code',
                        'api_response_status',
                        'response:ntext',
                        'created_at',
                    ],
                ])
                ?>

            </div>
        </div>
    </div>
</div>

