<?php

namespace common\models\dynamicdb\cbo_detail\master;

use Yii;

/**
 * This is the model class for table "rishta_master_permission".
 *
 * @property int $id
 * @property string $permission
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class RishtaMasterPermission extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {

    const SHG_VIEW = 1;
    const SHG_UPDATE = 2;
    const SHG_FEEDBACK = 3;
    const SHG_MEMBER_VIEW = 4;
    const SHG_MEMBER_MAKE_USER = 5;
    const SHG_MEMBER_ADD_UPDATE_DELETE = 6;
    const SHG_BANK_DETAIL_VIEW = 7;
    const SHG_BANK_DETAIL_ADD_UPDATE_DELETE = 8;
    const SHG_FUNDS_VIEW = 9;
    const SHG_FUNDS_ADD_UPDATE_DELETE = 10;
    const SHG_SUGGEST_WADA_SAKHI = 11;
    const SHG_WADA_SAKHI_FORM = 12;
    const SHG_WADA_SCHEME_FROM = 14;

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
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'rishta_master_permission';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['permission'], 'required'],
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['permission'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'permission' => 'Permission',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getAttachedrole() {
        return $this->hasMany(\common\models\dynamicdb\cbo_detail\RishtaRolePermission::className(), ['permission' => 'id'])->where(['rishta_role_permission.status' => 1]);
    }

}
