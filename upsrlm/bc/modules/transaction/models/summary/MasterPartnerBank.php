<?php

namespace bc\modules\transaction\models\summary;

use Yii;

/**
 * This is the model class for table "master_partner_bank".
 *
 * @property int $id
 * @property string|null $bank_name
 * @property string|null $bank_short_name
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class MasterPartnerBank extends SummaryActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_partner_bank';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['bank_name'], 'string', 'max' => 100],
            [['bank_short_name'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bank_name' => 'Bank Name',
            'bank_short_name' => 'Bank Short Name',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
