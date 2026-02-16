<?php

namespace common\models\dynamicdb\internalcallcenter\platform\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use \yii\helpers\ArrayHelper;
use common\models\dynamicdb\internalcallcenter\CloudTeleApiCall;

/**
 * MyProgressSearch
 */
class MyProgressSearch extends \yii\base\Model
{
    public $calling_agent_id;
    public $calling_agent_role;
    public $calling_date;
    public $progress_type;
    public $progress_types = [2 => 'Inbound (IBD)', 1 => 'Outbound (CTC)'];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['calling_agent_id', 'calling_agent_role', 'calling_date', 'progress_type'], 'safe'],
        ];
    }

    /**
     * Progress Class
     *
     * @return void
     */
    public function getProgressclass()
    {
        if ($this->progress_type == 1) {
            return 'common\models\dynamicdb\internalcallcenter\platform\CallingAgentProgress';
        } else {
            return 'common\models\dynamicdb\internalcallcenter\platform\CallingAgentProgressIbd';
        }
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $this->load($params);
        $query = $this->progressclass::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 100],
            'sort' => [
                'defaultOrder' =>
                [
                    'calling_date' => SORT_DESC,
                ]
            ],
        ]);


        $this->basicquery($query);

        return $dataProvider;
    }

    /**
     * Call Detail
     *
     * @param [type] $params
     * @return void
     */
    public function calldetailsearch($params)
    {
        $query = CloudTeleApiCall::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 100],
            'sort' => [
                'defaultOrder' =>
                [
                    'api_request_datetime' => SORT_ASC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'upsrlm_user_id' => $this->calling_agent_id,
            'upsrlm_user_role' => $this->calling_agent_role,
            'upsrlm_call_type' => $this->progress_type,
        ]);

        $query->andFilterWhere(['>=', 'created_at', strtotime($this->calling_date . ' 00:00:00')])
            ->andFilterWhere(['<=', 'created_at', strtotime($this->calling_date . ' 23:59:59')]);

        return $dataProvider;
    }

    /**
     * Get Distnict Call Dates
     *
     * @return void
     */
    public function getCallingdates()
    {
        $query = $this->progressclass::find();
        $query->andFilterWhere([
            'calling_agent_id' => $this->calling_agent_id,
            'calling_agent_role' => $this->calling_agent_role
        ]);

        $query->distinct('calling_date');
        $query->orderBy(['calling_date' => SORT_DESC]);
        return ArrayHelper::map($query->all(), 'calling_date', 'calling_date');
    }

    /**
     * Calling Agnets List
     *
     * @return void
     */
    public function getCallingagents()
    {
        $query = $this->progressclass::find();
        $query->andFilterWhere([
            'calling_agent_role' => $this->calling_agent_role,
            'calling_date' => $this->calling_date,
        ]);

        $query->distinct('calling_agent_id');
        return ArrayHelper::map($query->all(), 'calling_agent_id', 'agentdetail.name');
    }

    public function getCallingagentsrole()
    {
        $query = $this->progressclass::find();
        $query->andFilterWhere([
            'calling_date' => $this->calling_date,
        ]);

        $query->distinct('calling_agent_role');
        return ArrayHelper::map($query->all(), 'calling_agent_role', 'agentdetail.urole.role_name');
    }

    public function getTotalagent()
    {
        $query = $this->progressclass::find();
        $this->basicquery($query);
        $query->select('calling_agent_id');
        return $query->distinct('calling_agent_id')->count();
    }

    public function getTotaldays()
    {
        $query = $this->progressclass::find();
        $this->basicquery($query);
        $query->select('calling_date');
        return $query->distinct('calling_date')->count();
    }

    public function getTotalctcclick()
    {
        $query = $this->progressclass::find();
        $this->basicquery($query);
        $query->select('ctc_click');
        return $query->sum('ctc_click');
    }

    public function getTotalagentcallrecived()
    {
        $query = $this->progressclass::find();
        $this->basicquery($query);
        $query->select('agent_call_recived');
        return $query->sum('agent_call_recived');
    }

    public function getTotalbothanswered()
    {
        $query = $this->progressclass::find();
        $this->basicquery($query);
        $query->select('both_answered');
        return $query->sum('both_answered');
    }

    public function getTotalivrduration()
    {
        $query = $this->progressclass::find();
        $this->basicquery($query);
        $query->select('ivr_duration');
        return self::seconds2human($query->sum('ivr_duration'));
    }

    public function getTotaltalkduration()
    {
        $query = $this->progressclass::find();
        $this->basicquery($query);
        $query->select('talk_duration');
        return self::seconds2human($query->sum('talk_duration'));
    }

    public function getTotalunanswered()
    {
        $query = $this->progressclass::find();
        $this->basicquery($query);
        $query->select('from_unanswered');
        return $query->sum('from_unanswered');
    }

    public function getTotalibdcall()
    {
        $query = $this->progressclass::find();
        $this->basicquery($query);
        $query->select('ibd_call');
        return $query->sum('ibd_call');
    }

    public function getTotalothercall()
    {
        $query = $this->progressclass::find();
        $this->basicquery($query);
        $query->select('other_call');
        return $query->sum('other_call');
    }

    public function getTotalregistredcall()
    {
        $query = $this->progressclass::find();
        $this->basicquery($query);
        $query->select('registred_call');
        return $query->sum('registred_call');
    }

    /**
     * Agent Detail
     */
    public function getAgentdetail()
    {
        return \common\models\User::find()->where(['id' => $this->calling_agent_id])->one();
    }

    /**
     * Get Hours:Minute:Seconds From Seconds
     *
     * @param [type] $seconds
     * @return void
     */
    public static function seconds2human($seconds)
    {
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

    public function getFirstcall()
    {
        $query = $this->progressclass::find();
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
    public function getLastcall()
    {
        $query = $this->progressclass::find();
        $this->basicquery($query);
        $query->select('end_time');
        $last = $query->orderBy(['end_time' => SORT_DESC])->limit(1)->one();
        if ($last) {
            return $last->end_time;
        }
    }

    public function getWorkhour()
    {
        if ($this->firstcall && $this->lastcall) {
            echo gmdate("H:i:s", round(abs(strtotime($this->lastcall) - strtotime($this->firstcall)), 0));
        }
    }

    public function basicquery($query)
    {
        $query->andFilterWhere([
            'calling_agent_id' => $this->calling_agent_id,
            'calling_agent_role' => $this->calling_agent_role,
            'calling_date' => $this->calling_date,
        ]);

        return $query;
    }
}
