<?php

namespace common\models\dynamicdb\support;

use Yii;

/**
 * This is the model class for table "web_application_role".
 *
 * @property int $id
 * @property int $role_id
 * @property int $web_application_id
 * @property int $status
 */
class WebApplicationRole extends SupportDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'web_application_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['role_id', 'web_application_id'], 'required'],
            [['role_id', 'web_application_id', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'web_application_id' => 'Web Application ID',
            'status' => 'Status',
        ];
    }

    public function getRole() {
        return $this->hasOne(master\MasterRole::className(), ['id' => 'role_id']);
    }

    public function getWebapp() {
        return $this->hasOne(WebApplication::className(), ['id' => 'web_application_id']);
    }

}
