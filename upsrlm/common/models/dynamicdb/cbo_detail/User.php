<?php

namespace common\models\dynamicdb\cbo_detail;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
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
 * @property int $mopup
 * @property int $mopup_profile_status
 * @property string|null $mopup_name
 * @property string|null $mopup_designation
 * @property string|null $whatsapp_no
 * @property string|null $mopup_otp_value
 * @property int|null $menu_version_major
 * @property int|null $menu_version_minor
 * @property float|null $menu_version
 * @property string|null $last_menu_updatetime
 * @property int $splash_screen
 * @property int $user_app_data_update
 * @property int $online
 * @property int $offline
 * @property int $dep_agree
 * @property int $hhs
 * @property string $password write-only password
 */
class User extends CboDetailactiveRecord implements IdentityInterface {

    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            ['username', 'trim'],
            ['username', 'unique', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'message' => 'This email address has already been taken.'],
            ['email', 'string', 'max' => 255],
            ['mobile_no', 'trim'],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            ['upd', 'safe'],
            ['profile_status', 'safe'],
            ['profile_status', 'default', 'value' => 1],
            ['auth_key', 'default', 'value' => ''],
            [['login_by_otp', 'otp_value', 'otp_sendtime'], 'safe'],
            ['login_by_otp', 'default', 'value' => 1],
            ['dummy_column', 'default', 'value' => 0],
            ['flags', 'default', 'value' => 0],
            ['app_version', 'safe'],
            ['firebase_token', 'safe'],
            ['app_id', 'safe'],
            [['menu_version_major', 'menu_version_minor', 'splash_screen', 'user_app_data_update'], 'integer'],
            [['menu_version'], 'number'],
            [['last_menu_updatetime'], 'safe'],
            [['last_access_time', 'user_app_data_update'], 'safe'],
            ['online', 'default', 'value' => 0],
            [['name','mopup_name'], 'string', 'max' => 255],
            [['mobile_no'], 'safe'],
            [['password_hash'],'safe'],
            [['auth_key'],'safe'],
            [['registration_ip'],'safe'],
            [['password_digest', 'mopup_designation'], 'string', 'max' => 150],
            [['otp_value'],'safe'],
            [['app_version', 'mopup_app_version'],'safe'],
            [['firebase_token', 'mopup_firebase_token'],'safe'],
            [['whatsapp_no'],'safe'],
            [['mopup_otp_value'],'safe'],
            [['mopup'], 'integer'],
            [['mopup_profile_status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
//    public static function findIdentityByAccessToken($token, $type = null) {
//        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
//    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
                    'verification_token' => $token,
                    'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken() {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    public function generatePasswordDigest($password, $realm = 'api') {
        return md5(implode(':', [$this->username, $realm, $password]));
    }

    public function getUrole() {
        return $this->hasOne(master\MasterRole::className(), ['id' => 'role']);
    }

    public function getBlocks() {
        return $this->hasMany(RelationUserBdoBlock::className(), ['user_id' => 'id'])->where(['relation_user_bdo_block.status' => 1]);
    }

    public function getBlockdis() {
        return $this->hasOne(master\MasterBlock::className(), ['block_code' => 'block_code'])->via('blocks');
    }

    public function getDistricts() {
        return $this->hasMany(RelationUserDistrict::className(), ['user_id' => 'id'])->where(['relation_user_district.status' => 1]);
    }

    public function getDivision() {
        return $this->hasMany(RelationUserDivision::className(), ['user_id' => 'id'])->where(['relation_user_division.status' => 1]);
    }

    public function getGrampanchayat() {
        return $this->hasMany(RelationUserGramPanchayat::className(), ['user_id' => 'id'])->where(['relation_user_gram_panchayat.status' => 1]);
    }

    public function getGpchilduser() {
        return $this->hasMany(RelationUserGramPanchayat::className(), ['primary_user_id' => 'id'])->where(['relation_user_gram_panchayat.status' => 1])->select('user_id')->distinct('user_id');
    }

    public function getProfile() {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

    public function getApplication() {
        return $this->hasMany(WebApplicationRole::className(), ['role_id' => 'role']);
    }

    public function getLoginmethod() {
        $login_by_otp_option = [
            1 => 'Login By Password',
            2 => 'Login By OTP',
            3 => 'Login By Both (Password or OTP)',
        ];
        return isset($login_by_otp_option[$this->login_by_otp]) ? $login_by_otp_option[$this->login_by_otp] : '';
    }

    public function getProfilestatus() {
        $class = '';
        $txt = '';
        if ($this->profile != NULL) {
            if ($this->profile->is_profile_complete) {
                $class = 'label-success';
                $txt = 'Completed';
            } else {
                $class = 'label-info';
                $txt = 'Incomplete';
            }
        } else {
            $class = 'label-warning';
            $txt = 'Not Initiated';
        }
        $string = '<span class="block label ' . $class . '">';
        $string .= $txt;
        $string .= '</span>';
        return $string;
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        $user = self::findOne(['id' => $token->getClaim('uid')]);
        if ($user != null) {
            return $user;
        }
        return null;
    }

    public function getShg() {
        return $this->hasMany(CboMembers::className(), ['user_id' => 'id'])->andWhere([CboMembers::getTableSchema()->fullName . '.status' => 1, CboMembers::getTableSchema()->fullName . '.cbo_type' => CboMembers::CBO_TYPE_SHG]);
    }

}
