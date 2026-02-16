<?php

namespace common\models\dynamicdb\cbo_detail;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\cbo_detail\RishtaShgMemberAppPin;

/**
 * RishtaShgMemberAppPinSearch represents the model behind the search form of `common\models\dynamicdb\cbo_detail\RishtaShgMemberAppPin`.
 */
class RishtaShgMemberAppPinSearch extends RishtaShgMemberAppPin {

    public $district_option = [];
    public $block_option = [];
    public $saheli;
    public $wada;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'cbo_shg_id', 'role', 'district_code', 'block_code', 'app_sms_status', 'pin_sms_status', 'created_at', 'updated_at', 'no_of_call'], 'safe'],
            [['mobile_no', 'app_sms_time', 'ack_time', 'pin_sms_time'], 'safe'],
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
        $query = RishtaShgMemberAppPin::find();

        if (isset($this->no_of_call) && $this->no_of_call != '') {
            if ($this->no_of_call == '0') {
                $query->andFilterWhere(['=', RishtaShgMemberAppPin::getTableSchema()->fullName . '.no_of_call', $this->no_of_call]);
            }
            if ($this->no_of_call == '1') {
                $query->andFilterWhere(['>', RishtaShgMemberAppPin::getTableSchema()->fullName . '.no_of_call', 0]);
            }
        }

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
            RishtaShgMemberAppPin::getTableSchema()->fullName . '.id' => $this->id,
            RishtaShgMemberAppPin::getTableSchema()->fullName . '.cbo_shg_id' => $this->cbo_shg_id,
            RishtaShgMemberAppPin::getTableSchema()->fullName . '.role' => $this->role,
            RishtaShgMemberAppPin::getTableSchema()->fullName . '.district_code' => $this->district_code,
            RishtaShgMemberAppPin::getTableSchema()->fullName . '.block_code' => $this->block_code,
            RishtaShgMemberAppPin::getTableSchema()->fullName . '.app_sms_status' => $this->app_sms_status,
            RishtaShgMemberAppPin::getTableSchema()->fullName . '.pin_sms_status' => $this->pin_sms_status,
            RishtaShgMemberAppPin::getTableSchema()->fullName . '.app_sms_time' => $this->app_sms_time,
            RishtaShgMemberAppPin::getTableSchema()->fullName . '.ack_time' => $this->ack_time,
            RishtaShgMemberAppPin::getTableSchema()->fullName . '.pin_sms_time' => $this->pin_sms_time,
            RishtaShgMemberAppPin::getTableSchema()->fullName . '.created_at' => $this->created_at,
            RishtaShgMemberAppPin::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', RishtaShgMemberAppPin::getTableSchema()->fullName . '.mobile_no', $this->mobile_no]);

        return $dataProvider;
    }

}
