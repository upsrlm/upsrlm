<?php

namespace common\models\rishta;

use Yii;

/**
 * This is the model class for table "rishta_user_data".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $menu_json
 * @property string|null $splash_screen_value
 * @property string|null $updated_time
 */
class RishtaUserData extends \common\models\dynamicdb\cbo\CboactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'rishta_user_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id'], 'integer'],
            [['menu_json', 'splash_screen_value'], 'string'],
            [['updated_time'], 'safe'],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'menu_json' => 'Menu Json',
            'splash_screen_value' => 'Splash Screen Value',
            'updated_time' => 'Updated Time',
        ];
    }

    public function getUser() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'user_id']);
    }

    public function beforeSave($insert) {
        $this->updated_time = date('Y-m-d H:i:s');

        return parent::beforeSave($insert);
    }

}
