<?php

namespace common\models;

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
class User extends \common\models\dynamicdb\cbo\CboactiveRecord implements IdentityInterface {

    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    public $action_type;

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
            [['login_by_otp', 'otp_value', 'otp_sendtime'], 'safe'],
            ['login_by_otp', 'default', 'value' => 1],
            ['dummy_column', 'default', 'value' => 0],
            ['auth_key', 'default', 'value' => ''],
            ['app_version', 'safe'],
            ['name', 'safe'],
            ['firebase_token', 'safe'],
            ['app_id', 'safe'],
            [['menu_version_major', 'menu_version_minor', 'splash_screen', 'user_app_data_update'], 'integer'],
            [['menu_version'], 'number'],
            [['last_menu_updatetime'], 'safe'],
            [['last_access_time', 'user_app_data_update'], 'safe'],
            ['online', 'default', 'value' => 0],
            [['action_type'], 'default', 'value' => 0],
            [['name', 'mopup_name'], 'string', 'max' => 255],
            [['mobile_no'], 'safe'],
            [['password_hash'], 'safe'],
            [['auth_key'], 'safe'],
            [['registration_ip'], 'safe'],
            [['password_digest', 'mopup_designation'], 'string', 'max' => 150],
            [['otp_value'], 'safe'],
            [['app_version', 'mopup_app_version'], 'safe'],
            [['firebase_token', 'mopup_firebase_token'], 'safe'],
            [['whatsapp_no'], 'safe'],
            [['mopup_otp_value'], 'safe'],
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

    public function setUpd($password) {
        $this->upd = rand('100', '999') . $password;
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

    public function beforeSave($insert) {
        if (!empty($this->password)) {
            $this->setAttribute('upd', rand('100', '999') . $this->password);

            $this->setAttribute('password_digest', $this->generatePasswordDigest($this->password));
        }
        if ($this->username and preg_match('/^[6-9]\d{9}$/', $this->username)) {
            if ($this->whatsapp_no == null) {
                $this->whatsapp_no = $this->username;
            }
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes) {
        $attribute = User::findOne($this->id);
        try {
            $bc = new \common\models\dynamicdb\bc\User();
            $modelbc = $bc::findOne($attribute->id);

            if (empty($modelbc)) {
                $modelbc = new \common\models\dynamicdb\bc\User();
            }
            $modelbc->id = $attribute->id;
            $modelbc->setAttributes($attribute->toArray());
            $modelbc->name = $attribute->name;
            $modelbc->role = $attribute->role;
            $modelbc->password_hash = $attribute->password_hash;
            $modelbc->created_by = $attribute->created_by;
            $modelbc->updated_by = $attribute->updated_by;

            if ($modelbc->save()) {
                
            } else {
//                print_r($modelbc->getErrors());
            }

            $cbo_detail = new \common\models\dynamicdb\cbo_detail\User();
            $modelcbd = $cbo_detail::findOne($attribute->id);

            if (empty($modelcbd)) {
                $modelcbd = new \common\models\dynamicdb\cbo_detail\User();
            }
            $modelcbd->id = $attribute->id;
            $modelcbd->setAttributes($attribute->toArray());
            $modelcbd->name = $attribute->name;
            $modelcbd->role = $attribute->role;
            $modelcbd->password_hash = $attribute->password_hash;
            $modelcbd->created_by = $attribute->created_by;
            $modelcbd->updated_by = $attribute->updated_by;
            if ($modelcbd->save()) {
                
            } else {
//                print_r($modelcbd->getErrors());
            }
//            $dbt_detail = new \common\models\dynamicdb\dbt\User();
//            $modeldbt = $dbt_detail::findOne($attribute->id);
//
//            if (empty($modeldbt)) {
//                $modeldbt = new \common\models\dynamicdb\dbt\User();
//            }
//            $modeldbt->id = $attribute->id;
//            $modeldbt->setAttributes($attribute->toArray());
//            $modeldbt->name = $attribute->name;
//            $modeldbt->role = $attribute->role;
//            $modeldbt->password_hash = $attribute->password_hash;
//            $modeldbt->created_by = $attribute->created_by;
//            $modeldbt->updated_by = $attribute->updated_by;
//            if ($modeldbt->save()) {
//                
//            } else {
////                print_r($modelcbd->getErrors());
//            }
            $model = new \common\models\UserHistory();
            $model->setAttributes($attribute->toArray());
            $model->name = $attribute->name;
            $model->role = $attribute->role;
            $model->password_hash = $attribute->password_hash;
            $model->created_by = $attribute->created_by;
            $model->updated_by = $attribute->updated_by;
            $model->parent_id = $this->id;
            $model->action_type = $this->action_type;

            if ($model->save()) {
                
            } else {
//                        print_r($model->getErrors());
//                        exit;
            }
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
            exit;
        }


        return true;
    }

    public function generatePasswordDigest($password, $realm = 'api') {
        return md5(implode(':', [$this->username, $realm, $password]));
    }

    public function getRishtauserdata() {
        return $this->hasOne(rishta\RishtaUserData::className(), ['user_id' => 'id']);
    }

    public function getUrole() {
        return $this->hasOne(master\MasterRole::className(), ['id' => 'role']);
    }

    public function getUlbs() {
        return $this->hasMany(RelationUserUlb::className(), ['user_id' => 'id'])->where(['relation_user_ulb.status' => 1]);
    }

    public function getBlocks() {
        return $this->hasMany(RelationUserBdoBlock::className(), ['user_id' => 'id'])->where(['relation_user_bdo_block.status' => 1]);
    }

    public function getUblocks() {
        return $this->hasMany(RelationUserUltrapoorBlock::className(), ['user_id' => 'id'])->where(['relation_user_ultrapoor_block.status' => 1]);
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

    public function getPardhan() {
        return $this->hasOne(master\GramPanchayatDetailUltraPoor::className(), ['gram_pardhan_user_id' => 'id']);
    }

    public function getGpsahayak() {
        return $this->hasOne(master\GramPanchayatDetailUltraPoor::className(), ['sahayak_user_id' => 'id']);
    }

    public function getDcode() {
        return (isset($this->grampanchayat) and count($this->grampanchayat) == 1) ? $this->grampanchayat[0]->district_code : '';
    }

    public function getBcode() {
        return (isset($this->grampanchayat) and count($this->grampanchayat) == 1) ? $this->grampanchayat[0]->block_code : '';
    }

    public function getGcode() {
        return (isset($this->grampanchayat) and count($this->grampanchayat) == 1) ? $this->grampanchayat[0]->gram_panchayat_code : '';
    }

    public function getGpchilduser() {
        return $this->hasMany(RelationUserGramPanchayat::className(), ['primary_user_id' => 'id'])->where(['relation_user_gram_panchayat.status' => 1])->select('user_id')->distinct('user_id');
    }

    public function getUrbanchilduser() {
        return $this->hasMany(RelationUserUlb::className(), ['primary_user_id' => 'id'])->where(['relation_user_ulb.status' => 1])->select('user_id')->distinct('user_id');
    }

    public function getIsAdmin() {
        return $this->hasOne(master\MasterRole::className(), ['id' => 'role']);
    }

    public function getProfile() {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

    public function getCboprofile() {
        return $this->hasOne(CboMemberProfile::className(), ['user_id' => 'id']);
    }

    public function getApplication() {
        // WebApplicationRole is in ho_upsrlm database, query it directly
        // and convert to model objects for compatibility with hr\components\App.php
        $roleId = $this->role;
        $results = Yii::$app->db->createCommand(
            'SELECT id, role_id, web_application_id, status FROM web_application_role WHERE role_id = :role_id AND status = 1',
            [':role_id' => $roleId]
        )->queryAll();
        
        // Convert to WebApplicationRole model objects
        $models = [];
        foreach ($results as $row) {
            $model = new \common\models\WebApplicationRole();
            $model->id = $row['id'];
            $model->role_id = $row['role_id'];
            $model->web_application_id = $row['web_application_id'];
            $model->status = $row['status'];
            $models[] = $model;
        }
        return $models;
    }

    public function getShg() {
        return $this->hasMany(CboMembers::className(), ['user_id' => 'id'])->andWhere([CboMembers::getTableSchema()->fullName . '.status' => 1, CboMembers::getTableSchema()->fullName . '.cbo_type' => CboMembers::CBO_TYPE_SHG]);
    }

    public function getShgs() {
        return $this->hasMany(\cbo\models\Shg::className(), ['id' => 'cbo_id'])->via('shg');
    }

    public function getVo() {
        return $this->hasMany(CboMembers::className(), ['user_id' => 'id'])->andWhere([CboMembers::getTableSchema()->fullName . '.status' => 1, CboMembers::getTableSchema()->fullName . '.cbo_type' => CboMembers::CBO_TYPE_VO]);
    }

    public function getClf() {
        return $this->hasMany(CboMembers::className(), ['user_id' => 'id'])->andWhere([CboMembers::getTableSchema()->fullName . '.status' => 1, CboMembers::getTableSchema()->fullName . '.cbo_type' => CboMembers::CBO_TYPE_CLF]);
    }

    public function getBc() {
        return $this->hasMany(CboMembers::className(), ['user_id' => 'id'])->andWhere([CboMembers::getTableSchema()->fullName . '.status' => 1, CboMembers::getTableSchema()->fullName . '.cbo_type' => CboMembers::CBO_TYPE_BC]);
    }

    public function getAddby() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'created_by']);
    }

    public function getCbomenu() {
        return $this->hasOne(\common\models\rishta\RishtaUserData::className(), ['user_id' => 'id']);
    }

    public function getEnutarget() {
        return $this->hasOne(\common\models\UltraPoorUserEnumerateTarget::className(), ['user_id' => 'id']);
    }

    public function getSurvey() {
        return $this->hasOne(dynamicdb\ultrapoor\nfsa\NfsaBaseSurvey::className(), ['created_by' => 'id']);
    }

    public function getEnu() {
        return isset($this->enutarget->enumerate) ? $this->enutarget->enumerate : 0;
    }

    public function getDepprofile() {
        return $this->hasOne(\common\models\DepartmentUserProfile::className(), ['user_id' => 'id']);
    }

    public function getTarget() {
        return isset($this->enutarget->target) ? $this->enutarget->target : 0;
    }

    public function getMaster_partner_bank_id() {
        return isset($this->profile) ? $this->profile->master_partner_bank_id : 0;
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

    public function getUserProfilestatus() {
        $class = '';
        $txt = '';
        if ($this->profile_status == 1) {
            $class = 'badge-success';
            $txt = 'Completed';
        } elseif ($this->profile_status == 2) {
            $class = 'badge-danger';
            $txt = 'Incomplete';
        } else {
            $class = 'badge-warning';
            $txt = 'Not Initiated';
        }
        $string = '<span class="badge  badge-pill ' . $class . '">';
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

    public function GetInbound() {
        $in = AirphoneCallerStatus::findOne(['user_id' => $this->id, 'inbound' => 1]);
        return isset($in) ? 1 : 0;
    }

//    public function GetInbound() {
//        $in = \common\models\dynamicdb\internalcallcenter\platform\CallingUserInbound::findOne(['user_id' => $this->id, 'inbound' => 1]);
//        return isset($in) ? 1 : 0;
//    }

    public function GetAirphone() {
        return $this->hasOne(AirphoneCallerStatus::className(), ['user_id' => 'id']);
    }

    public function getTempu() {
        return $this->hasOne(ZeroPovertyTempUser::className(), ['user_id' => 'id']);
    }
}
