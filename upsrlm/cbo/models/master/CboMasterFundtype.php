<?php

namespace cbo\models\master;

use Yii;

/**
 * This is the model class for table "cbo_master_fundtype".
 *
 * @property int $id
 * @property string|null $fund_type
 * @property int $shg
 * @property int $vo
 * @property int $clf
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class CboMasterFundtype extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'cbo_master_fundtype';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'status', 'shg', 'vo', 'clf'], 'integer'],
            [['fund_type'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'fund_type' => 'Fund Type',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

}
