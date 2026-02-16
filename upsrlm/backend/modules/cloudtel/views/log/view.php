<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\dynamicdb\internalcallcenter\CloudTeleApiLog */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cloud Tele Api Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cloud-tele-api-log-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'bc_application_id',
            'upsrlm_user_id',
            'upsrlm_user_mobile_no',
            'customernumber',
            'serviceuserid',
            'token',
            'api_response:ntext',
            'api_status_code',
            'api_status',
            'api_message',
            'api_request_datetime',
            'callid',
            'did',
            'cType',
            'CTC:ntext',
            'ivrSTime',
            'ivrETime',
            'ivrDuration',
            'userId',
            'cNumber',
            'masterNumCTC',
            'masterAgent',
            'masterAgentNumber',
            'masterGroupId',
            'talkDuration',
            'agentOnCallDuration',
            'firstAttended',
            'firstAnswerTime',
            'lastHangupTime',
            'lastFirstDuration',
            'custAnswerSTime',
            'custAnswerETime',
            'custAnswerDuration',
            'callStatus',
            'ivrExecuteFlow',
            'HangupBySourceDetected',
            'forward',
            'totalHoldDuration',
            'totalCreditsUsed:ntext',
            'ivrIdArr:ntext',
            'aAnsH:ntext',
            'aH:ntext',
            'nH:ntext',
            'recordings:ntext',
            'recording_file',
            'cliArr:ntext',
            'aHDetail:ntext',
            'nHDetail:ntext',
            'full_response:ntext',
            'upsrlm_connection_status',
            'upsrlm_call_status',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
