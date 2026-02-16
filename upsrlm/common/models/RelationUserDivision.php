<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "relation_user_division".
 *
 * @property int $id
 * @property int $user_id
 * @property int $division_code
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class RelationUserDivision extends \common\models\dynamicdb\bc\BcactiveRecord {

    use \common\traits\Signature;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'relation_user_division';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'division_code'], 'required'],
            [['user_id', 'division_code', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'division_code' => 'Division',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getDivision() {
        return $this->hasOne(master\MasterDivision::className(), ['division_code' => 'division_code']);
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function afterSave($insert, $changedAttributes) {
        $attribute = $this;
        try {
            $bc = new \common\models\dynamicdb\bc\RelationUserGramPanchayat();
            $modelbc = $bc::findOne($attribute->id);


            if (empty($modelbc)) {
                $modelbc = new \common\models\dynamicdb\bc\RelationUserGramPanchayat();
            }
            $modelbc->setAttributes($attribute->attributes);
            $modelbc->id = $attribute->id;
            $modelbc->user_id = $attribute->user_id;
            $modelbc->division_code = $attribute->division_code;

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
