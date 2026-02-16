<?php

use common\models\dynamicdb\internalcallcenter\CloudTeleApiCall;
use common\models\dynamicdb\internalcallcenter\platform\CallingList;

$upsrlm_call_type = 2;
$api_request_datetime = date('Y-m-d');
$registred_call = 0;
$other_call = 0;
$start_time = NULL;
$end_time = NULL;
$first = CloudTeleApiCall::find()->select(['api_request_datetime'])->where(['upsrlm_user_id' => Yii::$app->user->identity->id, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->orderBy(['api_request_datetime' => SORT_ASC])->limit(1)->one();
$last = CloudTeleApiCall::find()->select(['api_request_datetime'])->where(['upsrlm_user_id' => Yii::$app->user->identity->id, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->orderBy(['api_request_datetime' => SORT_DESC])->limit(1)->one();
if ($first) {
    $start_time = $first->api_request_datetime;
}
if ($last) {
    $end_time = $last->api_request_datetime;
}
$work_hour = 0;
if ($first && $last) {
    $work_hour = round(abs(strtotime($start_time) - strtotime($end_time)), 0);
}
$ibd_call = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_user_id' => Yii::$app->user->identity->id, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
$ibd_calls = CloudTeleApiCall::find()->select(['id', 'customernumber'])->where(['upsrlm_user_id' => Yii::$app->user->identity->id, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->all();
if ($ibd_calls) {
    foreach ($ibd_calls as $ibdcall) {
        $member = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['mobile' => $ibdcall->customernumber, 'status' => 1])->one();
        if ($member != null) {
            $registred_call = $registred_call + 1;
        } else {
            $other_call = $other_call + 1;
        }
    }
}
$talk_duration = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_user_id' => Yii::$app->user->identity->id, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->sum('talkDuration');
$ivr_duration = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_user_id' => Yii::$app->user->identity->id, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->sum('ivrDuration');
$agent_call_recived = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_user_id' => Yii::$app->user->identity->id, 'upsrlm_call_type' => $upsrlm_call_type, 'upsrlm_agent_call_received' => 1])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
?>



<div class="row">
    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= isset($start_time) ? \Yii::$app->formatter->asDateTime(strtotime($start_time), "php:H:i:s") : '' ?>
                    <small class="m-0 l-h-n">First Call</small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= isset($end_time) ? \Yii::$app->formatter->asDateTime(strtotime($end_time), "php:H:i:s") : '' ?>
                    <small class="m-0 l-h-n">Last Call</small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>
        <div class="col-sm-6 col-xl-3">
            <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
    <?= isset($work_hour) ? gmdate("H:i:s", $work_hour) : '' ?>
                        <small class="m-0 l-h-n">Work Hours</small>
                    </h3>
                </div>
                <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
            </div>
        </div>

    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $ibd_call ?>
                    <small class="m-0 l-h-n">IBD Call</small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $other_call ?>
                    <small class="m-0 l-h-n">Total Unregistered Call</small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $registred_call ?>
                    <small class="m-0 l-h-n">Total Registred Call </small>
                </h3>
            </div>
            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= isset($talk_duration) ? gmdate("H:i:s", $talk_duration) : '' ?>
                    <small class="m-0 l-h-n">Talk Duration </small>
                </h3>
            </div>
            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $agent_call_recived ?>
                    <small class="m-0 l-h-n">Total Scneario Button Click </small>
                </h3>
            </div>
            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>

</div>