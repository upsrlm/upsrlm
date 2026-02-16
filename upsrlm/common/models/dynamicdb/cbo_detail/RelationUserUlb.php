<?php

namespace common\models\dynamicdb\cbo_detail;

use Yii;

/**
 * This is the model class for table "relation_user_ulb".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $primary_user_id
 * @property int $master_ulb_id
 * @property int $ulb_code
 * @property int $district_code
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class RelationUserUlb extends CboDetailactiveRecord {

    use \common\traits\Signature;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'relation_user_ulb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'master_ulb_id', 'ulb_code', 'district_code'], 'required'],
            [['user_id', 'primary_user_id', 'master_ulb_id', 'ulb_code', 'district_code', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'primary_user_id' => 'Primary User',
            'master_ulb_id' => 'ULB',
            'ulb_code' => 'ULB',
            'district_code' => 'District',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {
        if (isset($this->ulb_code) and $this->ulb_code) {
            $model = \app\models\master\MasterUlb::findOne(['ulb_code' => $this->ulb_code]);
            if ($model != NULL) {
                $this->master_ulb_id = $model->id;
            }
        }
        return parent::beforeSave($insert);
    }

    public function getUser_detail() {
        return $this->hasOne(UserModel::className(), ['id' => 'user_id']);
    }

    public function getUlb() {
        return $this->hasOne(\app\models\master\MasterUlb::className(), ['ulb_code' => 'ulb_code']);
    }

    public function getDistrict() {
        return $this->hasOne(\app\models\master\MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getUser() {
        return $this->hasOne(\app\models\UserModel::className(), ['id' => 'user_id']);
    }

    public function getPrimaryuser() {
        return $this->hasOne(\app\models\UserModel::className(), ['id' => 'primary_user_id']);
    }

    public function getTodayprogress() {
        return $this->hasOne(report\ReportDailyEnumeratorWise::className(), ['user_id' => 'user_id'])->where(['date' => date('Y-m-d')]);
    }

    public function getHsc($search) {
        $query = nfsa\NfsaBaseSurvey::find();
        $query->andFilterWhere(['=', 'created_by', $this->user_id]);
        if (isset($search->district_code) and $search->district_code != '')
            $query->andFilterWhere(['district_code' => $search->district_code]);

        if (isset($search->ulb_code) and $search->ulb_code != '')
            $query->andFilterWhere(['ulb_code' => $search->ulb_code]);
        return $query->count();
    }

    public function getTcr() {
        $query = nfsa\NfsaBaseSurvey::find();
        $query->andFilterWhere(['=', 'created_by', $this->user_id]);
        $query->andFilterWhere(['=', 'form_date', date('Y-m-d')]);
        if (isset($search->district_code) and $search->district_code != '')
            $query->andFilterWhere(['district_code' => $search->district_code]);

        if (isset($search->ulb_code) and $search->ulb_code != '')
            $query->andFilterWhere(['ulb_code' => $search->ulb_code]);
        return $query->count();
    }

}
