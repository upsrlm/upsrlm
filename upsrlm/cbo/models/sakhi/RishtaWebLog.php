<?php

namespace cbo\models\sakhi;

use Yii;

/**
 * This is the model class for table "rishta_web_log".
 *
 * @property int $id
 * @property int|null $type
 * @property int|null $type_id
 * @property string|null $type_url
 * @property int|null $user_id
 * @property float|null $app_version
 * @property string|null $datetime
 */
class RishtaWebLog extends \common\models\dynamicdb\rishta_log\RishtalogactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'rishta_web_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['type', 'type_id', 'user_id'], 'integer'],
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
            'datetime' => 'Datetime',
        ];
    }

    public function getUser() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'user_id']);
    }

    public function getTmodule() {
        $arr = [1 => 'SHG', 2 => 'VO', 3 => 'CLF', 4 => 'BC', 7 => 'PAGE'];
        return isset($arr[$this->type]) ? $arr[$this->type] : '';
    }

}
