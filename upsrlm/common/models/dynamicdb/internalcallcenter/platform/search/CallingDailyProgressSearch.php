<?php

namespace common\models\dynamicdb\internalcallcenter\platform\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\internalcallcenter\platform\CallingDailyProgress;
use \yii\helpers\ArrayHelper;

/**
 * CallingDailyProgressSearch represents the model behind the search form of `common\models\dynamicdb\internalcallcenter\platform\CallingDailyProgress`.
 */
class CallingDailyProgressSearch extends CallingDailyProgress {

    public $scenario_option = ['soverall' => 'समस्त', 's1001' => 'SHG-CST यूज़र सत्यापन', 's1002' => 'SHG-CST द्ववरा रिश्ता ऐप का उपयोग', 's1003' => 'SHG-CST द्वारा WSS नामांकन', 's1004' => 'WSS अभ्यर्थी द्वारा रिश्ता ऐप का उपयोग', 's1005' => 'WSS अभ्यर्थी द्वारा फ़ॉर्म भरना शुरू करना', 's1013' => 'समूह सखि सत्यापन BMMU द्ववरा एंट्री '];
    public $scenario;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'upsrlm_user_id', 'upsrlm_user_role', 'upsrlm_user_group', 's1001', 's1002', 's1003', 's1004', 's1005', 's1013', 'stotal', 's1001_call_atempt', 's1001_call_continue', 's1001_call_achieve', 's1001_call_pending', 's1001_ivr_time', 's1001_talk_time', 's1002_call_atempt', 's1002_call_continue', 's1002_call_achieve', 's1002_call_pending', 's1002_ivr_time', 's1002_talk_time', 's1003_call_atempt', 's1003_call_continue', 's1003_call_achieve', 's1003_call_pending', 's1003_ivr_time', 's1003_talk_time', 's1004_call_atempt', 's1004_call_continue', 's1004_call_achieve', 's1004_call_pending', 's1004_ivr_time', 's1004_talk_time', 's1005_call_atempt', 's1005_call_continue', 's1005_call_achieve', 's1005_call_pending', 's1005_ivr_time', 's1005_talk_time', 's1013_call_atempt', 's1013_call_continue', 's1013_call_achieve', 's1013_call_pending', 's1013_ivr_time', 's1013_talk_time', 'total_call_atempt', 'total_call_continue', 'total_call_achieve', 'total_ivr_time', 'total_talk_time', 'work_hour', 'created_at', 'updated_at'], 'safe'],
            [['upsrlm_user_name', 'upsrlm_user_mobile_no', 'upsrlm_user_district', 'upsrlm_user_block', 'date', 'call_start_time', 'call_end_time'], 'safe'],
            [['scenario'], 'safe']
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
    public function search($params, $user_model = null, $pagination = true, $columns = null, $distinct = false) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = CallingDailyProgress::find();
        $query->andWhere("upsrlm_user_district is not null");
        if ($columns != NULL) {
            $query->select($columns);
        }
        if (isset($this->date) && $this->date != '') {
            $query->andFilterWhere(['=', CallingDailyProgress::getTableSchema()->fullName . '.date', $this->date]);
        }
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['date' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            CallingDailyProgress::getTableSchema()->fullName . '.id' => $this->id,
            CallingDailyProgress::getTableSchema()->fullName . '.upsrlm_user_id' => $this->upsrlm_user_id,
            CallingDailyProgress::getTableSchema()->fullName . '.upsrlm_user_role' => $this->upsrlm_user_role,
            CallingDailyProgress::getTableSchema()->fullName . '.upsrlm_user_group' => $this->upsrlm_user_group,
            CallingDailyProgress::getTableSchema()->fullName . '.date' => $this->date,
            CallingDailyProgress::getTableSchema()->fullName . '.s1001' => $this->s1001,
            CallingDailyProgress::getTableSchema()->fullName . '.s1002' => $this->s1002,
            CallingDailyProgress::getTableSchema()->fullName . '.s1003' => $this->s1003,
            CallingDailyProgress::getTableSchema()->fullName . '.s1004' => $this->s1004,
            CallingDailyProgress::getTableSchema()->fullName . '.s1005' => $this->s1005,
            CallingDailyProgress::getTableSchema()->fullName . '.s1013' => $this->s1013,
            CallingDailyProgress::getTableSchema()->fullName . '.stotal' => $this->stotal,
            CallingDailyProgress::getTableSchema()->fullName . '.s1001_call_atempt' => $this->s1001_call_atempt,
            CallingDailyProgress::getTableSchema()->fullName . '.s1001_call_continue' => $this->s1001_call_continue,
            CallingDailyProgress::getTableSchema()->fullName . '.s1001_call_achieve' => $this->s1001_call_achieve,
            CallingDailyProgress::getTableSchema()->fullName . '.s1001_call_pending' => $this->s1001_call_pending,
            CallingDailyProgress::getTableSchema()->fullName . '.s1001_ivr_time' => $this->s1001_ivr_time,
            CallingDailyProgress::getTableSchema()->fullName . '.s1001_talk_time' => $this->s1001_talk_time,
            CallingDailyProgress::getTableSchema()->fullName . '.s1002_call_atempt' => $this->s1002_call_atempt,
            CallingDailyProgress::getTableSchema()->fullName . '.s1002_call_continue' => $this->s1002_call_continue,
            CallingDailyProgress::getTableSchema()->fullName . '.s1002_call_achieve' => $this->s1002_call_achieve,
            CallingDailyProgress::getTableSchema()->fullName . '.s1002_call_pending' => $this->s1002_call_pending,
            CallingDailyProgress::getTableSchema()->fullName . '.s1002_ivr_time' => $this->s1002_ivr_time,
            CallingDailyProgress::getTableSchema()->fullName . '.s1002_talk_time' => $this->s1002_talk_time,
            CallingDailyProgress::getTableSchema()->fullName . '.s1003_call_atempt' => $this->s1003_call_atempt,
            CallingDailyProgress::getTableSchema()->fullName . '.s1003_call_continue' => $this->s1003_call_continue,
            CallingDailyProgress::getTableSchema()->fullName . '.s1003_call_achieve' => $this->s1003_call_achieve,
            CallingDailyProgress::getTableSchema()->fullName . '.s1003_call_pending' => $this->s1003_call_pending,
            CallingDailyProgress::getTableSchema()->fullName . '.s1003_ivr_time' => $this->s1003_ivr_time,
            CallingDailyProgress::getTableSchema()->fullName . '.s1003_talk_time' => $this->s1003_talk_time,
            CallingDailyProgress::getTableSchema()->fullName . '.s1004_call_atempt' => $this->s1004_call_atempt,
            CallingDailyProgress::getTableSchema()->fullName . '.s1004_call_continue' => $this->s1004_call_continue,
            CallingDailyProgress::getTableSchema()->fullName . '.s1004_call_achieve' => $this->s1004_call_achieve,
            CallingDailyProgress::getTableSchema()->fullName . '.s1004_call_pending' => $this->s1004_call_pending,
            CallingDailyProgress::getTableSchema()->fullName . '.s1004_ivr_time' => $this->s1004_ivr_time,
            CallingDailyProgress::getTableSchema()->fullName . '.s1004_talk_time' => $this->s1004_talk_time,
            CallingDailyProgress::getTableSchema()->fullName . '.s1005_call_atempt' => $this->s1005_call_atempt,
            CallingDailyProgress::getTableSchema()->fullName . '.s1005_call_continue' => $this->s1005_call_continue,
            CallingDailyProgress::getTableSchema()->fullName . '.s1005_call_achieve' => $this->s1005_call_achieve,
            CallingDailyProgress::getTableSchema()->fullName . '.s1005_call_pending' => $this->s1005_call_pending,
            CallingDailyProgress::getTableSchema()->fullName . '.s1005_ivr_time' => $this->s1005_ivr_time,
            CallingDailyProgress::getTableSchema()->fullName . '.s1005_talk_time' => $this->s1005_talk_time,
            CallingDailyProgress::getTableSchema()->fullName . '.s1013_call_atempt' => $this->s1013_call_atempt,
            CallingDailyProgress::getTableSchema()->fullName . '.s1013_call_continue' => $this->s1013_call_continue,
            CallingDailyProgress::getTableSchema()->fullName . '.s1013_call_achieve' => $this->s1013_call_achieve,
            CallingDailyProgress::getTableSchema()->fullName . '.s1013_call_pending' => $this->s1013_call_pending,
            CallingDailyProgress::getTableSchema()->fullName . '.s1013_ivr_time' => $this->s1013_ivr_time,
            CallingDailyProgress::getTableSchema()->fullName . '.s1013_talk_time' => $this->s1013_talk_time,
            CallingDailyProgress::getTableSchema()->fullName . '.total_call_atempt' => $this->total_call_atempt,
            CallingDailyProgress::getTableSchema()->fullName . '.total_call_continue' => $this->total_call_continue,
            CallingDailyProgress::getTableSchema()->fullName . '.total_call_achieve' => $this->total_call_achieve,
            CallingDailyProgress::getTableSchema()->fullName . '.total_ivr_time' => $this->total_ivr_time,
            CallingDailyProgress::getTableSchema()->fullName . '.total_talk_time' => $this->total_talk_time,
            CallingDailyProgress::getTableSchema()->fullName . '.call_start_time' => $this->call_start_time,
            CallingDailyProgress::getTableSchema()->fullName . '.call_end_time' => $this->call_end_time,
            CallingDailyProgress::getTableSchema()->fullName . '.work_hour' => $this->work_hour,
            CallingDailyProgress::getTableSchema()->fullName . '.created_at' => $this->created_at,
            CallingDailyProgress::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', CallingDailyProgress::getTableSchema()->fullName . '.upsrlm_user_name', $this->upsrlm_user_name])
                ->andFilterWhere(['like', CallingDailyProgress::getTableSchema()->fullName . '.upsrlm_user_mobile_no', $this->upsrlm_user_mobile_no])
                ->andFilterWhere(['like', CallingDailyProgress::getTableSchema()->fullName . '.upsrlm_user_district', $this->upsrlm_user_district])
                ->andFilterWhere(['like', CallingDailyProgress::getTableSchema()->fullName . '.upsrlm_user_block', $this->upsrlm_user_block]);

        return $dataProvider;
    }

    public function getCallingdates() {
        $query = CallingDailyProgress::find();

        $query->distinct('date');
        $query->orderBy(['date' => SORT_DESC]);
        return ArrayHelper::map($query->all(), 'date', 'date');
    }

    public function getCallingagents() {
        $query = CallingDailyProgress::find();
        $query->andFilterWhere([
            CallingDailyProgress::getTableSchema()->fullName . '.id' => $this->id,
            CallingDailyProgress::getTableSchema()->fullName . '.upsrlm_user_id' => $this->upsrlm_user_id,
            CallingDailyProgress::getTableSchema()->fullName . '.upsrlm_user_role' => $this->upsrlm_user_role,
            CallingDailyProgress::getTableSchema()->fullName . '.upsrlm_user_group' => $this->upsrlm_user_group,
            CallingDailyProgress::getTableSchema()->fullName . '.date' => $this->date,
        ]);

        $query->distinct('upsrlm_user_id');
        return ArrayHelper::map($query->all(), 'upsrlm_user_id', 'upsrlm_user_name');
    }

    public function basicquery($query) {
        $query->andWhere("upsrlm_user_district is not null");
        $query->andFilterWhere([
            CallingDailyProgress::getTableSchema()->fullName . '.upsrlm_user_id' => $this->upsrlm_user_id,
            CallingDailyProgress::getTableSchema()->fullName . '.upsrlm_user_role' => $this->upsrlm_user_role,
            CallingDailyProgress::getTableSchema()->fullName . '.upsrlm_user_group' => $this->upsrlm_user_group,
            CallingDailyProgress::getTableSchema()->fullName . '.date' => $this->date,
        ]);

        return $query;
    }

    public function getTstotal() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('stotal');
        return $query->sum('stotal');
    }
    public function getTs1001() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1001');
        return $query->sum('s1001');
    }
    public function getTs1002() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1002');
        return $query->sum('s1002');
    }
    public function getTs1003() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1003');
        return $query->sum('s1003');
    }
    public function getTs1004() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1004');
        return $query->sum('s1004');
    }
    public function getTs1005() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1005');
        return $query->sum('s1005');
    }
    public function getTs1013() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1013');
        return $query->sum('s1013');
    }
    
    public function getTstotalatempt() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('total_call_atempt');
        return $query->sum('total_call_atempt');
    }
    public function getTs1001atempt() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1001_call_atempt');
        return $query->sum('s1001_call_atempt');
    }
    public function getTs1002atempt() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1002_call_atempt');
        return $query->sum('s1002_call_atempt');
    }
    public function getTs1003atempt() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1003_call_atempt');
        return $query->sum('s1003_call_atempt');
    }
    public function getTs1004atempt() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1004_call_atempt');
        return $query->sum('s1004_call_atempt');
    }
    public function getTs1005atempt() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1005_call_atempt');
        return $query->sum('s1005_call_atempt');
    }
    public function getTs1013atempt() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1013_call_atempt');
        return $query->sum('s1013_call_atempt');
    }
    public function getTstotalcontinue() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('total_call_continue');
        return $query->sum('total_call_continue');
    }
    public function getTs1001continue() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1001_call_continue');
        return $query->sum('s1001_call_continue');
    }
    public function getTs1002continue() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1002_call_continue');
        return $query->sum('s1002_call_continue');
    }
    public function getTs1003continue() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1003_call_continue');
        return $query->sum('s1003_call_continue');
    }
    public function getTs1004continue() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1004_call_continue');
        return $query->sum('s1004_call_continue');
    }
    public function getTs1005continue() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1005_call_continue');
        return $query->sum('s1005_call_continue');
    }
    public function getTs1013continue() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1013_call_continue');
        return $query->sum('s1013_call_continue');
    }
    
    public function getTstotalachieve() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('total_call_achieve');
        return $query->sum('total_call_achieve');
    }
    public function getTs1001achieve() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1001_call_achieve');
        return $query->sum('s1001_call_achieve');
    }
    public function getTs1002achieve() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1002_call_achieve');
        return $query->sum('s1002_call_achieve');
    }
    public function getTs1003achieve() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1003_call_achieve');
        return $query->sum('s1003_call_achieve');
    }
    public function getTs1004achieve() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1004_call_achieve');
        return $query->sum('s1004_call_achieve');
    }
    public function getTs1005achieve() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1005_call_achieve');
        return $query->sum('s1005_call_achieve');
    }
    public function getTs1013achieve() {
        $query = CallingDailyProgress::find();
        $this->basicquery($query);
        $query->select('s1013_call_achieve');
        return $query->sum('s1013_call_achieve');
    }
}
