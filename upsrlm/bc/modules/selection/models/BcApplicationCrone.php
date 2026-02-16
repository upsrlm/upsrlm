<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "bc_application_crone".
 *
 * @property int $id
 * @property int $last_process_user_id
 * @property string|null $last_run_time_process_user
 * @property int $status
 */
class BcApplicationCrone extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_application_crone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['last_process_user_id', 'status'], 'integer'],
            [['last_run_time_process_user'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'last_process_user_id' => 'Last Process User ID',
            'last_run_time_process_user' => 'Last Run Time Process User',
            'status' => 'Status',
        ];
    }
}
