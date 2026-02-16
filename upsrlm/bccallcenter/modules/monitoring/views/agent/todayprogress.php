<?php

use yii\widgets\Pjax;
use common\models\dynamicdb\internalcallcenter\CloudTeleApiCall;

$this->title = 'Agent Progress:' . $searchModel->api_request_datetime;
?>

<?php
Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => FALSE,
    'enableReplaceState' => FALSE,
    'timeout' => false,
]);
?>
<?php echo $this->render('_today_search', ['model' => $searchModel]);
?>


<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2><?= $this->title ?></h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top table-condensed">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Agent Name</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Work Hours</th>
                                <th>Total CTC Click</th>
                                <th>Agent Call Recivied</th>
                                <th>Both Answered</th>
                                <th>Talk Duration</th>
                                <th>IVR Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($agentids) :
                                $srn = 1;
                                foreach ($agentids as $calling_agent) :

                            ?>
                                    <tr>
                                        <td><?= $srn ?></td>
                                        <td><?= $calling_agent->user != null ? $calling_agent->user->name : '' ?></td>
                                        <td><?php
                                            $first =  CloudTeleApiCall::find()->select(['api_request_datetime'])->where(['upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_call_type' => 1])->andFilterWhere(['>=', 'created_at', strtotime($searchModel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($searchModel->api_request_datetime . ' 23:59:59')])->orderBy(['api_request_datetime' => SORT_ASC])->limit(1)->one();
                                            if ($first) {
                                                echo $start_time = $first->api_request_datetime;
                                            } ?></td>
                                        <td><?php
                                            $last =  CloudTeleApiCall::find()->select(['api_request_datetime'])->where(['upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_call_type' => 1])->andFilterWhere(['>=', 'created_at', strtotime($searchModel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($searchModel->api_request_datetime . ' 23:59:59')])->orderBy(['api_request_datetime' => SORT_DESC])->limit(1)->one();
                                            if ($last) {
                                                echo $end_time = $last->api_request_datetime;
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($first && $last) {
                                                echo gmdate("H:i:s", round(abs(strtotime($end_time) - strtotime($start_time)), 0));
                                            }
                                            ?>
                                        </td>
                                        <td><?= CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_call_type' => 1])->andFilterWhere(['>=', 'created_at', strtotime($searchModel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($searchModel->api_request_datetime . ' 23:59:59')])->count() ?></td>
                                        <td><?= CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_call_type' => 1, 'upsrlm_agent_call_received' => 1])->andFilterWhere(['>=', 'created_at', strtotime($searchModel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($searchModel->api_request_datetime . ' 23:59:59')])->count() ?></td>
                                        <td><?= CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'callStatus' => 3, 'upsrlm_call_type' => 1])->andFilterWhere(['>=', 'created_at', strtotime($searchModel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($searchModel->api_request_datetime . ' 23:59:59')])->count(); ?></td>
                                        <td><?= gmdate("H:i:s", CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_call_type' => 1])->andFilterWhere(['>=', 'created_at', strtotime($searchModel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($searchModel->api_request_datetime . ' 23:59:59')])->sum('talkDuration')) ?></td>
                                        <td><?= gmdate("H:i:s", CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_call_type' => 1])->andFilterWhere(['>=', 'created_at', strtotime($searchModel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($searchModel->api_request_datetime . ' 23:59:59')])->sum('ivrDuration')) ?></td>
                                    </tr>
                            <?php
                                    $srn++;
                                endforeach;
                            endif; ?>
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<?php Pjax::end(); ?>