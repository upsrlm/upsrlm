<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\internalcallcenter\platform\UltraPoorAgentPardhanDailyProgress;
use yii\helpers\ArrayHelper;

/**
 * UltraPoorAgentPardhanDailyProgressSearch represents the model behind the search form of `common\models\dynamicdb\internalcallcenter\platform\UltraPoorAgentPardhanDailyProgress`.
 */
class UltraPoorAgentPardhanDailyProgressSearch extends UltraPoorAgentPardhanDailyProgress {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'upsrlm_user_id', 'upsrlm_user_role', 'upsrlm_user_group', 'target', 'attempt_call', 'sms_sent', 'app_download', 'no_of_user_add', 'goverment_order_sent', 'total_ivr_time', 'total_talk_time', 'work_hour', 'created_at', 'updated_at'], 'safe'],
            [['upsrlm_user_name', 'upsrlm_user_mobile_no', 'upsrlm_user_district', 'upsrlm_user_block', 'date', 'call_start_time', 'call_end_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = UltraPoorAgentPardhanDailyProgress::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'upsrlm_user_id' => $this->upsrlm_user_id,
            'upsrlm_user_role' => $this->upsrlm_user_role,
            'upsrlm_user_group' => $this->upsrlm_user_group,
            'date' => $this->date,
            'target' => $this->target,
            'attempt_call' => $this->attempt_call,
            'sms_sent' => $this->sms_sent,
            'app_download' => $this->app_download,
            'no_of_user_add' => $this->no_of_user_add,
            'goverment_order_sent' => $this->goverment_order_sent,
            'total_ivr_time' => $this->total_ivr_time,
            'total_talk_time' => $this->total_talk_time,
            'call_start_time' => $this->call_start_time,
            'call_end_time' => $this->call_end_time,
            'work_hour' => $this->work_hour,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'upsrlm_user_name', $this->upsrlm_user_name])
                ->andFilterWhere(['like', 'upsrlm_user_mobile_no', $this->upsrlm_user_mobile_no])
                ->andFilterWhere(['like', 'upsrlm_user_district', $this->upsrlm_user_district])
                ->andFilterWhere(['like', 'upsrlm_user_block', $this->upsrlm_user_block]);

        return $dataProvider;
    }

    public function searcha($params) {
        $query = UltraPoorAgentPardhanDailyProgress::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 100],
            'sort' => [
                'defaultOrder' =>
                [
                    'date' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $this->basicquery($query);

        return $dataProvider;
    }

    public function getCallingdates() {
        $query = UltraPoorAgentPardhanDailyProgress::find();
        $query->andFilterWhere(['>', 'date', '2023-06-24']);
        $query->andFilterWhere(['<', 'date', date('Y-m-d')]);
        $query->andFilterWhere([
            'id' => $this->id,
            'upsrlm_user_id' => $this->upsrlm_user_id,
            'upsrlm_user_role' => $this->upsrlm_user_role,
            'upsrlm_user_group' => $this->upsrlm_user_group,
            'target' => $this->target,
            'attempt_call' => $this->attempt_call,
            'sms_sent' => $this->sms_sent,
            'app_download' => $this->app_download,
            'no_of_user_add' => $this->no_of_user_add,
            'goverment_order_sent' => $this->goverment_order_sent,
            'total_ivr_time' => $this->total_ivr_time,
            'total_talk_time' => $this->total_talk_time,
            'call_start_time' => $this->call_start_time,
            'call_end_time' => $this->call_end_time,
            'work_hour' => $this->work_hour,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->distinct('date');
        $query->orderBy(['date' => SORT_DESC]);
        return ArrayHelper::map($query->all(), 'date', 'date');
    }

    /**
     * Calling Agnets List
     *
     * @return void
     */
    public function getCallingagents() {
        $query = UltraPoorAgentPardhanDailyProgress::find();
        $query->andFilterWhere([
            'id' => $this->id,
            'upsrlm_user_role' => $this->upsrlm_user_role,
            'upsrlm_user_group' => $this->upsrlm_user_group,
            'date' => $this->date,
            'target' => $this->target,
            'attempt_call' => $this->attempt_call,
            'sms_sent' => $this->sms_sent,
            'app_download' => $this->app_download,
            'no_of_user_add' => $this->no_of_user_add,
            'goverment_order_sent' => $this->goverment_order_sent,
            'total_ivr_time' => $this->total_ivr_time,
            'total_talk_time' => $this->total_talk_time,
            'call_start_time' => $this->call_start_time,
            'call_end_time' => $this->call_end_time,
            'work_hour' => $this->work_hour,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->distinct('upsrlm_user_id');
        return ArrayHelper::map($query->all(), 'upsrlm_user_id', 'upsrlm_user_name');
    }

    public function basicquery($query) {
        $query->andFilterWhere([
            'id' => $this->id,
            'upsrlm_user_id' => $this->upsrlm_user_id,
            'upsrlm_user_role' => $this->upsrlm_user_role,
            'upsrlm_user_group' => $this->upsrlm_user_group,
            'date' => $this->date,
            'target' => $this->target,
            'attempt_call' => $this->attempt_call,
            'sms_sent' => $this->sms_sent,
            'app_download' => $this->app_download,
            'no_of_user_add' => $this->no_of_user_add,
            'goverment_order_sent' => $this->goverment_order_sent,
            'total_ivr_time' => $this->total_ivr_time,
            'total_talk_time' => $this->total_talk_time,
            'call_start_time' => $this->call_start_time,
            'call_end_time' => $this->call_end_time,
            'work_hour' => $this->work_hour,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $query;
    }

    public function getTotalagent() {
        $query = UltraPoorAgentPardhanDailyProgress::find();
        $this->basicquery($query);
        $query->select('upsrlm_user_id');
        return $query->distinct('upsrlm_user_id')->count();
    }

    public function getTotaldays() {
        $query = UltraPoorAgentPardhanDailyProgress::find();
        $this->basicquery($query);
        $query->select('date');
        return $query->distinct('date')->count();
    }

    public function getTotalatemptcall() {
        $query = UltraPoorAgentPardhanDailyProgress::find();
        $this->basicquery($query);
        $query->select('attempt_call');
        return $query->sum('attempt_call');
    }

    public function getTotalappddownload() {
        $query = UltraPoorAgentPardhanDailyProgress::find();
        $this->basicquery($query);
        $query->select('app_download');
        return $query->sum('app_download');
    }

    public function getTotaluseradd() {
        $query = UltraPoorAgentPardhanDailyProgress::find();
        $this->basicquery($query);
        $query->select('no_of_user_add');
        return $query->sum('no_of_user_add');
    }

    public function getTotaltarget() {
        $query = UltraPoorAgentPardhanDailyProgress::find();
        $this->basicquery($query);
        $query->select('target');
        return $query->sum('target');
    }

    public function getTotalsmssent() {
        $query = UltraPoorAgentPardhanDailyProgress::find();
        $this->basicquery($query);
        $query->select('sms_sent');
        return $query->sum('sms_sent');
    }

    public function getTotalgosent() {
        $query = UltraPoorAgentPardhanDailyProgress::find();
        $this->basicquery($query);
        $query->select('goverment_order_sent');
        return $query->sum('goverment_order_sent');
    }

    public function getTotalbothanswered() {
        $query = UltraPoorAgentPardhanDailyProgress::find();
        $this->basicquery($query);
        $query->select('both_answered');
        return $query->sum('both_answered');
    }

    public function getTotalivrduration() {
        $query = UltraPoorAgentPardhanDailyProgress::find();
        $this->basicquery($query);
        $query->select('total_ivr_time');
        return self::seconds2human($query->sum('total_ivr_time'));
    }

    public function getTotaltalkduration() {
        $query = UltraPoorAgentPardhanDailyProgress::find();
        $this->basicquery($query);
        $query->select('total_talk_time');
        return self::seconds2human($query->sum('total_talk_time'));
    }

    /**
     * Get Hours:Minute:Seconds From Seconds
     *
     * @param [type] $seconds
     * @return void
     */
    public static function seconds2human($seconds) {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds / 60) % 60);
        $seconds = $seconds % 60;
        if ($hours < 9) {
            $hours = '0' . $hours;
        }
        if ($minutes < 9) {
            $minutes = '0' . $minutes;
        }
        if ($seconds < 9) {
            $seconds = '0' . $seconds;
        }
        return "$hours:$minutes:$seconds";
    }

    public function getFirstcall() {
        $query = BcCallingAgentProgress::find();
        $this->basicquery($query);
        $query->select('start_time');
        $first = $query->orderBy(['start_time' => SORT_ASC])->limit(1)->one();
        if ($first) {
            return $first->start_time;
        }
    }

    /**
     * Agent Last Call
     *
     * @return void
     */
    public function getLastcall() {
        $query = BcCallingAgentProgress::find();
        $this->basicquery($query);
        $query->select('end_time');
        $last = $query->orderBy(['end_time' => SORT_DESC])->limit(1)->one();
        if ($last) {
            return $last->end_time;
        }
    }

    public function getWorkhour() {
        if ($this->firstcall && $this->lastcall) {
            echo gmdate("H:i:s", round(abs(strtotime($this->lastcall) - strtotime($this->firstcall)), 0));
        }
    }
}
