<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_history".
 *
 * @property int $id
 * @property string|null $name
 * @property string $username
 * @property string $email
 * @property string|null $mobile_no
 * @property int $role
 * @property string $password_hash
 * @property string $auth_key
 * @property int|null $confirmed_at
 * @property string|null $unconfirmed_email
 * @property int|null $blocked_at
 * @property string|null $registration_ip
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int $flags
 * @property string|null $upd
 * @property int|null $last_login_at
 * @property string|null $password_digest
 * @property string|null $password_reset_token
 * @property int $status
 * @property int|null $profile_status
 * @property int|null $login_by_otp
 * @property string|null $otp_value
 * @property int|null $otp_sendtime
 * @property string|null $app_version
 * @property string|null $mopup_app_version
 * @property int|null $app_id
 * @property int|null $mopup_app_id
 * @property string|null $last_access_time
 * @property int $dummy_column
 * @property string|null $firebase_token
 * @property string|null $mopup_firebase_token
 * @property int|null $menu_version_major
 * @property int|null $menu_version_minor
 * @property float|null $menu_version
 * @property string|null $last_menu_updatetime
 * @property int $splash_screen
 * @property int $user_app_data_update
 * @property int $online
 * @property int $offline
 * @property int $action_type
 * @property int|null $parent_id
 */
class UserHistory extends \common\models\dynamicdb\cbo\CboactiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_history';
    }

    /**
     * Use the main 'db' connection (ho_upsrlm) instead of dbcbo
     */
    public static function getDb()
    {
        return \Yii::$app->db;
    }

    public function behaviors() {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            [['password_hash', 'auth_key'], 'safe'],
            [['role', 'confirmed_at', 'blocked_at', 'created_at', 'updated_at', 'created_by', 'updated_by', 'flags', 'last_login_at', 'status', 'profile_status', 'login_by_otp', 'otp_sendtime', 'app_id', 'mopup_app_id', 'dummy_column', 'menu_version_major', 'menu_version_minor', 'splash_screen', 'user_app_data_update', 'online', 'offline', 'action_type', 'parent_id'], 'integer'],
            [['last_access_time', 'last_menu_updatetime'], 'safe'],
            [['menu_version'], 'number'],
            [['name', 'username', 'email', 'unconfirmed_email', 'upd', 'password_reset_token'], 'string', 'max' => 255],
            [['mobile_no'], 'string', 'max' => 15],
            [['password_hash'], 'string', 'max' => 60],
            [['auth_key'], 'string', 'max' => 32],
            [['registration_ip'], 'string', 'max' => 45],
            [['password_digest'], 'string', 'max' => 150],
            [['otp_value'], 'string', 'max' => 6],
            [['app_version', 'mopup_app_version'], 'string', 'max' => 50],
            [['firebase_token', 'mopup_firebase_token'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'username' => 'Username',
            'email' => 'Email',
            'mobile_no' => 'Mobile No',
            'role' => 'Role',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
            'confirmed_at' => 'Confirmed At',
            'unconfirmed_email' => 'Unconfirmed Email',
            'blocked_at' => 'Blocked At',
            'registration_ip' => 'Registration Ip',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'flags' => 'Flags',
            'upd' => 'Upd',
            'last_login_at' => 'Last Login At',
            'password_digest' => 'Password Digest',
            'password_reset_token' => 'Password Reset Token',
            'status' => 'Status',
            'profile_status' => 'Profile Status',
            'login_by_otp' => 'Login By Otp',
            'otp_value' => 'Otp Value',
            'otp_sendtime' => 'Otp Sendtime',
            'app_version' => 'App Version',
            'mopup_app_version' => 'Mopup App Version',
            'app_id' => 'App ID',
            'mopup_app_id' => 'Mopup App ID',
            'last_access_time' => 'Last Access Time',
            'dummy_column' => 'Dummy Column',
            'firebase_token' => 'Firebase Token',
            'mopup_firebase_token' => 'Mopup Firebase Token',
            'menu_version_major' => 'Menu Version Major',
            'menu_version_minor' => 'Menu Version Minor',
            'menu_version' => 'Menu Version',
            'last_menu_updatetime' => 'Last Menu Updatetime',
            'splash_screen' => 'Splash Screen',
            'user_app_data_update' => 'User App Data Update',
            'online' => 'Online',
            'offline' => 'Offline',
            'action_type' => 'Action Type',
            'parent_id' => 'Parent ID',
        ];
    }
}
