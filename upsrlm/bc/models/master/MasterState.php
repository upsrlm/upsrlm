<?php

namespace bc\models\master;

use Yii;

/**
 * This is the model class for table "master_state".
 *
 * @property int $id
 * @property int $state_code
 * @property string $state_name
 * @property string $short_name
 * @property string $state_type
 * @property int $status
 */
class MasterState extends \bc\modules\selection\models\BcactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'master_state';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['state_code', 'state_name', 'short_name'], 'required'],
            ['state_code', 'unique'],
            [['state_code', 'status'], 'integer'],
            [['state_name'], 'string', 'max' => 127],
            [['short_name'], 'string', 'max' => 5],
            [['short_type'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'state_code' => 'State Code',
            'state_name' => 'State Name',
            'short_name' => 'Short Name',
            'state_type' => 'State Type'
        ];
    }

}
