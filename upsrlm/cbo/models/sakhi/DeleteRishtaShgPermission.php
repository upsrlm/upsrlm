<?php

namespace cbo\models\sakhi;

use Yii;

/**
 * This is the model class for table "cbo_shg_permission".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $cbo_shg_id
 * @property int $shg_view
 * @property int $shg_update
 * @property int $shg_verify
 * @property int $shg_member_view
 * @property int $shg_member_add
 * @property int $shg_member_update
 * @property int $shg_member_delete
 * @property int $shg_funds_view
 * @property int $shg_funds_add
 * @property int $shg_funds_update
 * @property int $shg_funds_delete
 * @property int $shg_feedback_view
 * @property int $shg_feedback_form
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class DeleteRishtaShgPermission extends \yii\db\ActiveRecord {

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
        return 'rishta_shg_permission';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'cbo_shg_id', 'shg_view', 'shg_update', 'shg_verify', 'shg_member_view', 'shg_member_add', 'shg_member_update', 'shg_member_delete', 'shg_funds_view', 'shg_funds_add', 'shg_funds_update', 'shg_funds_delete', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'cbo_shg_id' => 'Shg ID',
            'shg_view' => 'Shg View',
            'shg_update' => 'Shg Update',
            'shg_verify' => 'Shg Verify',
            'shg_member_view' => 'Shg Member View',
            'shg_member_add' => 'Shg Member Add',
            'shg_member_update' => 'Shg Member Update',
            'shg_member_delete' => 'Shg Member Delete',
            'shg_funds_view' => 'Shg Funds View',
            'shg_funds_add' => 'Shg Funds Add',
            'shg_funds_update' => 'Shg Funds Update',
            'shg_funds_delete' => 'Shg Funds Delete',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

}
