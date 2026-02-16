<?php

namespace cbo\models;

use Yii;

/**
 * This is the model class for table "cbo_vo_shg".
 *
 * @property int $id
 * @property int|null $cbo_vo_id
 * @property int|null $cbo_shg_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class CboVoShg extends \yii\db\ActiveRecord {

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function() {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'cbo_vo_shg';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['cbo_vo_id', 'cbo_shg_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['cbo_vo_id', 'cbo_shg_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_vo_id' => 'Cbo Vo ID',
            'cbo_shg_id' => 'Cbo Shg ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getVo() {
        return $this->hasOne(CboVo::className(), ['id' => 'cbo_vo_id']);
    }

    public function getShg() {
        return $this->hasOne(\app\modules\shg\models\Shg::className(), ['id' => 'cbo_shg_id']);
    }

}
