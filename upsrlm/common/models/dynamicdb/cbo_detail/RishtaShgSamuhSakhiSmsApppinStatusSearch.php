<?php

namespace common\models\dynamicdb\cbo_detail;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\cbo_detail\RishtaShgSamuhSakhiSmsApppinStatus;

/**
 * RishtaShgSamuhSakhiSmsApppinStatusSearch represents the model behind the search form of `common\models\dynamicdb\cbo_detail\RishtaShgSamuhSakhiSmsApppinStatus`.
 */
class RishtaShgSamuhSakhiSmsApppinStatusSearch extends RishtaShgSamuhSakhiSmsApppinStatus {

    public $district_option = [];
    public $block_option = [];
    public $saheli;
    public $wada;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'user_id', 'cbo_shg_id', 'role', 'district_code', 'block_code', 'apppin_sms_status', 'created_at', 'updated_at'], 'integer'],
            [['mobile_no', 'apppin_sms_time', 'ack_time'], 'safe'],
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
    public function search($params, $user_model = null, $pagination = true, $columns = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = RishtaShgSamuhSakhiSmsApppinStatus::find();

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
            RishtaShgSamuhSakhiSmsApppinStatus::getTableSchema()->fullName . '.id' => $this->id,
            RishtaShgSamuhSakhiSmsApppinStatus::getTableSchema()->fullName . '.user_id' => $this->user_id,
            RishtaShgSamuhSakhiSmsApppinStatus::getTableSchema()->fullName . '.cbo_shg_id' => $this->cbo_shg_id,
            RishtaShgSamuhSakhiSmsApppinStatus::getTableSchema()->fullName . '.role' => $this->role,
            RishtaShgSamuhSakhiSmsApppinStatus::getTableSchema()->fullName . '.district_code' => $this->district_code,
            RishtaShgSamuhSakhiSmsApppinStatus::getTableSchema()->fullName . '.block_code' => $this->block_code,
            RishtaShgSamuhSakhiSmsApppinStatus::getTableSchema()->fullName . '.apppin_sms_status' => $this->apppin_sms_status,
            RishtaShgSamuhSakhiSmsApppinStatus::getTableSchema()->fullName . '.apppin_sms_time' => $this->apppin_sms_time,
            RishtaShgSamuhSakhiSmsApppinStatus::getTableSchema()->fullName . '.ack_time' => $this->ack_time,
            RishtaShgSamuhSakhiSmsApppinStatus::getTableSchema()->fullName . '.created_at' => $this->created_at,
            RishtaShgSamuhSakhiSmsApppinStatus::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'mobile_no', $this->mobile_no]);

        return $dataProvider;
    }

}
