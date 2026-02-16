<?php

use common\models\dynamicdb\cbo_detail\RishtaShgMember;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;
?>

<div id="panel-101" class="panel">
    <div class="panel-hdr">
        <h2>
            <?= 'कॉल हिस्ट्री' ?>
        </h2>

    </div>
    <div class="panel-container show">
        <div class="panel-content">
            <?php
            if ($model->rishtashgmemberdetail) {
                echo $this->render('_memberprofile', ['model' => $model->rishtashgmemberdetail]);
            } else {
                if ($model->cbo_vo_id) {
                    $vo_model = \cbo\models\CboVo::findOne($model->cbo_vo_id);
                    echo $this->render('_vomemberprofile', ['model' => $vo_model]);
                }
            }

            echo $this->render('_callhistory', ['dataProvider' => $dataProvider]);
            ?>

            <?php
            $suggest_samuh_sakhi = 0;
            $wadapplication = 0;
            $user = common\models\User::findOne(['username' => $model->customer_number]);
            if ($model->rishta_shg_member_id) {
                $suggest_samuh_sakhi = RishtaShgMember::find()->select('id')->where([
                            'cbo_shg_id' => $model->cbo_shg_id,
                            'suggest_wada_sakhi' => 1
                        ])->count();

                if ($user) {
                    $wadapplication = \common\models\wada\WadaApplication::find()->where([
                                'cbo_shg_id' => $model->cbo_shg_id,
                                'user_id' => $user->id
                            ])->andWhere("`status`=2")
                            ->count();
                }
            }
            if ($model->upsrlm_call_type == '2') {
                ?>
                <div class="col-lg-12 text-center">
                    <?php
                    if ($user == null and $model->rishta_shg_member_id && in_array($model->member_role, [1, 2, 3])) {
                        echo \yii\helpers\Html::a('<i class="fal fa-eye"></i> User Verification Pending', ['attentcall?calling_list_id=' . $model->id . '&default_call_scenario_id=1001'], ['data-toggle' => "tooltip", 'data-pjax' => 0, 'class' => 'btn btn-info']);
                    } else if ($user && $user->dummy_column == 0 && !isset($user->app_id) && in_array($model->member_role, [1, 2, 3])) {
                        echo \yii\helpers\Html::a('<i class="fal fa-eye"></i> User not used Rishta App', ['attentcall?calling_list_id=' . $model->id . '&default_call_scenario_id=1002'], ['data-toggle' => "tooltip", 'data-pjax' => 0, 'class' => 'btn btn-info']);
                    } else if (
                            $user && $user->dummy_column == 0 && isset($user->app_id) &&
                            $model->rishtashgmemberdetail &&
                            in_array($model->member_role, [1, 2, 3]) &&
                            !$suggest_samuh_sakhi
                    ) {
                        echo \yii\helpers\Html::a('<i class="fal fa-eye"></i> Samuh Sakhi Not Nominated by Chairperson/Secretary/Treasurer', ['attentcall?calling_list_id=' . $model->id . '&default_call_scenario_id=1003'], ['data-toggle' => "tooltip", 'data-pjax' => 0, 'class' => 'btn btn-info']);
                    } else if (
                            $user && !isset($user->app_id) &&
                            $model->rishtashgmemberdetail &&
                            $model->rishtashgmemberdetail->suggest_wada_sakhi == 1
                    ) {
                        echo \yii\helpers\Html::a('<i class="fal fa-eye"></i> Samuh Sakhi Not used Rishta APP', ['attentcall?calling_list_id=' . $model->id . '&default_call_scenario_id=1004'], ['data-toggle' => "tooltip", 'data-pjax' => 0, 'class' => 'btn btn-info']);
                    } else if (
                            $user && isset($user->app_id) &&
                            $model->rishtashgmemberdetail &&
                            $model->rishtashgmemberdetail->suggest_wada_sakhi == 1 &&
                            $wadapplication == 0
                    ) {
                        echo \yii\helpers\Html::a('<i class="fal fa-eye"></i> Samuh Sakhi Not fill form in Rishta APP', ['attentcall?calling_list_id=' . $model->id . '&default_call_scenario_id=1005'], ['data-toggle' => "tooltip", 'data-pjax' => 0, 'class' => 'btn btn-info']);
                    } else if (
                            $model->rishta_shg_member_id == 0 &&
                            $model->cbo_vo_id
                    ) {
                        echo \yii\helpers\Html::a('<i class="fal fa-eye"></i> Samuh Sakhi Verification entry by BMMU', ['attentcall?calling_list_id=' . $model->id . '&default_call_scenario_id=1013'], ['data-toggle' => "tooltip", 'data-pjax' => 0, 'class' => 'btn btn-info']);
                    } else {
                        echo \yii\helpers\Html::a('No Pending Scenario Return Back', ['/platform/default/inbound'], ['data-toggle' => "tooltip", 'data-pjax' => 0, 'class' => 'btn btn-info']);
                    }
                    ?>
                </div>
            <?php } else { ?>
                <div class="col-lg-12 text-center">
                    <?php
                    $continuecallrequest = \yii\helpers\Html::a('<i class="fal fa-phone"></i> Continue', ['callrequest?calling_list_id=' . $model->id], ['data-toggle' => "tooltip", 'data-pjax' => 0, 'class' => 'btn btn-info']);
                    $closecallrequest = \yii\helpers\Html::a('Scenario Already Completed Close Call', ['closecallrequest?calling_list_id=' . $model->id], ['data-toggle' => "tooltip", 'data-pjax' => 0, 'class' => 'btn btn-info']);

                    if ($model->default_call_scenario_id == 1001) {
                        if ($user == null and $model->rishta_shg_member_id && in_array($model->member_role, [1, 2, 3])) {
                            echo $continuecallrequest;
                        } else {
                            echo $closecallrequest;
                        }
                    } else if ($model->default_call_scenario_id == 1002) {
                        if ($user && $user->dummy_column == 0 && !isset($user->app_id) && in_array($model->member_role, [1, 2, 3])) {
                            echo $continuecallrequest;
                        } else {
                            echo $closecallrequest;
                        }
                    } else if ($model->default_call_scenario_id == 1003) {
                        if (
                                $user && $user->dummy_column == 0 && isset($user->app_id) &&
                                $model->rishtashgmemberdetail &&
                                in_array($model->member_role, [1, 2, 3]) &&
                                !$suggest_samuh_sakhi
                        ) {
                            echo $continuecallrequest;
                        } else {
                            echo $closecallrequest;
                        }
                    } else if ($model->default_call_scenario_id == 1004) {
                        if (
                                $user && !isset($user->app_id) &&
                                $model->rishtashgmemberdetail &&
                                $model->rishtashgmemberdetail->suggest_wada_sakhi == 1
                        ) {
                            echo $continuecallrequest;
                        } else {
                            echo $closecallrequest;
                        }
                    } else if ($model->default_call_scenario_id == 1005) {
                        if (
                                $user && isset($user->app_id) &&
                                $model->rishtashgmemberdetail &&
                                $model->rishtashgmemberdetail->suggest_wada_sakhi == 1 &&
                                $wadapplication == 0
                        ) {
                            echo $continuecallrequest;
                        } else {
                            echo $closecallrequest;
                        }
                    }
                    ?>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            <?php }
            ?>

        </div>
    </div>
</div>

<?php
$script = <<< JS
    $(".pagination li a").click(function(){
        $("#modalform").load($(this).attr('href'));
        return false;
});
JS;
$this->registerJs($script);
?>