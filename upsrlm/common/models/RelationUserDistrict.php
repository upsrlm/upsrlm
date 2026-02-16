<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "relation_user_district".
 *
 * @property int $id
 * @property int $user_id
 * @property string $district_code
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class RelationUserDistrict extends \common\models\dynamicdb\bc\BcactiveRecord {

    use \common\traits\Signature;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'relation_user_district';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'district_code'], 'required'],
            [['user_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['district_code'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'district_code' => 'District Code',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getDistrict() {
        return $this->hasOne(master\MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function afterSave($insert, $changedAttributes) {
        $attribute = $this;
        try {
            $bc = new \common\models\dynamicdb\bc\RelationUserDistrict();
            $modelbc = $bc::findOne($attribute->id);


            if (empty($modelbc)) {
                $modelbc = new \common\models\dynamicdb\bc\RelationUserDistrict();
            }
            $modelbc->setAttributes($attribute->attributes);
            $modelbc->id = $attribute->id;
            $modelbc->user_id = $attribute->user_id;
            $modelbc->district_code = $attribute->district_code;

            $modelbc->created_at = $attribute->created_at;
            $modelbc->updated_at = $attribute->updated_at;
            $modelbc->created_by = $attribute->created_by;
            $modelbc->updated_by = $attribute->updated_by;
            $modelbc->status = $attribute->status;

            if ($modelbc->save()) {
                
            } else {
                
            }
        } catch (\Exception $ex) {
            
        }


        return true;
    }

}
