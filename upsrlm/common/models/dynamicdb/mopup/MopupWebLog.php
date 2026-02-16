<?php

namespace common\models\dynamicdb\mopup;

use Yii;
use common\models\dynamicdb\mopup\MopupactiveRecord;

/**
 * This is the model class for table "mopup_web_log".
 *
 * @property int $id
 * @property int|null $type
 * @property int|null $type_id
 * @property string|null $type_url
 * @property int|null $user_id
 * @property float|null $app_version
 * @property int $ajax
 * @property string|null $datetime
 */
class MopupWebLog extends MopupactiveRecord {

    

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'mopup_web_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['type', 'type_id', 'user_id', 'ajax'], 'integer'],
            [['app_version'], 'number'],
            [['datetime'], 'safe'],
            [['type_url'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'type_id' => 'Type ID',
            'type_url' => 'Type Url',
            'user_id' => 'User ID',
            'app_version' => 'App Version',
            'ajax' => 'Ajax',
            'datetime' => 'Datetime',
        ];
    }
}
