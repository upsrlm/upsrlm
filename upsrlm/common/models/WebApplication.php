<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_application".
 *
 * @property int $id
 * @property string $app_name
 * @property string $app_description
 */
class WebApplication extends \yii\db\ActiveRecord {

    const WEB_APP_UPSRLM_ID = 1;
    const WEB_APP_BC_ID = 2;
    const WEB_APP_CBO_ID = 3;
    const WEB_APP_ADMIN_ID = 4;
    const WEB_APP_HR_ID = 5;
    const WEB_APP_SAKHI_ID = 6;
    const WEB_APP_SUPPORT_ID = 7;
    const WEB_APP_WADA_ID = 8;
    const WEB_APP_RISHTASUPPORT_ID = 9;
    const WEB_APP_SAHELI_ID = 10;
    const WEB_APP_CALL_CENTER_ID = 11;
    const WEB_APP_DBT_CALL_CENTER_ID = 12;
    const WEB_APP_BC_CALL_CENTER_ID = 13;
    const WEB_APP_ULTRA_POOR_ID = 14;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'web_application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['app_name', 'app_description'], 'required'],
            [['app_name'], 'string', 'max' => 50],
            [['app_description'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'app_name' => 'App Name',
            'app_description' => 'App Description',
        ];
    }

}
