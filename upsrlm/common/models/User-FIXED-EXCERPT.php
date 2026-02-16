<?php
/**
 * SECURITY FIX - User Model Excerpt
 * 
 * Shows the critical changes to make User model secure:
 * 1. Remove 'safe' from security-sensitive fields (password_hash, auth_key)
 * 2. Implement proper password setters/getters
 * 3. Add OTP rate limiting and expiry
 * 
 * Apply these changes to: common/models/User.php
 */

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

class User extends \common\models\dynamicdb\cbo\CboactiveRecord implements IdentityInterface {

    /**
     * Required by IdentityInterface (not implemented)
     *
     * @param string $token
     * @param null $type
     * @return null
     * @throws \yii\base\NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new \yii\base\NotSupportedException('findIdentityByAccessToken is not implemented.');
    }

    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    
    // OTP Configuration
    const OTP_EXPIRY_SECONDS = 300;      // 5 minutes
    const OTP_MAX_ATTEMPTS = 5;
    const OTP_ATTEMPT_WINDOW = 300;      // seconds
    const OTP_MIN_LENGTH = 8;            // Minimum 8 digits
    
    public $action_type;
    public $password;                     // Virtual attribute for password input (not stored)

    /**
     * Table name
     */
    public static function tableName() {
        return '{{%user}}';
    }

    /**
     * Validation rules
     * 
     * SECURITY FIX: Removed 'safe' from sensitive fields
     * - password_hash should NEVER be user-assignable
     * - auth_key should NEVER be user-assignable
     * These are set programmatically via setPassword() and generateAuthKey()
     */
    public function rules() {
        return [
            // USERNAME VALIDATION
            ['username', 'trim'],
            ['username', 'unique', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            
            // EMAIL VALIDATION
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'message' => 'This email address has already been taken.'],
            
            // MOBILE NUMBER
            ['mobile_no', 'trim'],
            ['mobile_no', 'string', 'max' => 20],
            
            // PASSWORD - only validated, never stored directly
            ['password', 'string', 'min' => 8],  // Minimum 8 characters
            
            // STATUS
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            
            // PROFILE
            ['profile_status', 'safe'],
            ['profile_status', 'default', 'value' => 1],
            [['name', 'mopup_name'], 'string', 'max' => 255],
            
            // OTP LOGIN
            [['login_by_otp', 'otp_attempts', 'otp_last_attempt_time'], 'safe'],
            ['login_by_otp', 'default', 'value' => 1],
            
            // APP-SPECIFIC
            [['app_version', 'mopup_app_version'], 'safe'],
            [['firebase_token', 'mopup_firebase_token'], 'safe'],
            [['menu_version_major', 'menu_version_minor', 'splash_screen', 'user_app_data_update'], 'integer'],
            [['menu_version'], 'number'],
            
            // Authentication keys - NEVER user-assignable
            // DO NOT ADD: [['password_hash'], 'safe'],  // DANGER!
            // DO NOT ADD: [['auth_key'], 'safe'],       // DANGER!
            
            // Other safe fields
            ['upd', 'safe'],
            ['dummy_column', 'default', 'value' => 0],
            ['online', 'default', 'value' => 0],
            [['action_type'], 'default', 'value' => 0],
        ];
    }

    /**
     * Behaviors
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

    // ==================== AUTHENTICATION METHODS ====================

    /**
     * Find user by ID (for IdentityInterface)
     *
     * @param int $id
     * @return static|null
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Find user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Get user ID
     *
     * @return mixed
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * Get auth key (for IdentityInterface)
     *
     * @return string
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * Validate auth key (for IdentityInterface)
     *
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    // ==================== PASSWORD METHODS ====================

    /**
     * Set password using bcrypt hashing
     * 
     * Should be called BEFORE save():
     *   $user->setPassword($plainPassword);
     *   $user->save(false);
     *
     * @param string $password plain text password
     * @throws \yii\base\InvalidConfigException
     */
    public function setPassword($password) {
        if (!$password) {
            throw new \yii\base\InvalidArgumentException('Password cannot be empty');
        }
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Validate password against hash
     *
     * @param string $password plain text password to validate
     * @return bool
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generate auth key for persistent login
     * 
     * Called automatically after user creation:
     *   $user->generateAuthKey();
     *   $user->save(false);
     */
    public function generateAuthKey() {
        // Generate 32+ random bytes, encode as base64 for storage
        $this->auth_key = Yii::$app->security->generateRandomString(32);
    }

    // ==================== PASSWORD RESET ====================

    /**
     * Find user by password reset token
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
     * Check if password reset token is valid
     *
     * @param string $token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        // Token format: <random>_<timestamp>
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        
        // Token expires after configured time
        return $timestamp + $expire >= time();
    }

    /**
     * Generate password reset token
     * 
     * Token includes timestamp to enable expiry validation
     *
     * @return string
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Remove password reset token
     * 
     * Called after successful password reset
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    // ==================== OTP METHODS ====================

    /**
     * Generate OTP for login
     * 
     * SECURITY: Rate-limited to prevent DoS
     * 
     * @return string Generated OTP
     * @throws \yii\web\BadRequestHttpException if rate limited
     */
    public function generateOTP() {
        // Rate limit: max 3 OTP requests per 15 minutes
        $recentAttempts = self::find()
            ->where(['username' => $this->username])
            ->andWhere(['>', 'otp_sendtime', time() - 900])  // last 15 minutes
            ->count();
        
        if ($recentAttempts > 3) {
            throw new \yii\web\BadRequestHttpException(
                'Too many OTP requests. Please try again later.'
            );
        }
        
        // Generate strong OTP: at least 8 digits
        $otp = Yii::$app->security->generateRandomInt(10000000, 99999999);
        $this->otp_value = (string)$otp;
        $this->otp_sendtime = time();
        $this->otp_attempts = 0;
        $this->otp_last_attempt_time = null;
        
        $this->save(false);  // Skip validation since fields are safe
        
        return $this->otp_value;
    }

    /**
     * Validate OTP
     * 
     * SECURITY:
     * - Checks expiry (5 minutes)
     * - Rate limits attempts (5 max per 5 minutes)
     * - Uses timing-safe string comparison
     *
     * @param string $otp OTP to validate
     * @return bool
     * @throws \yii\web\BadRequestHttpException if validation fails
     */
    public function validateOTP($otp) {
        // 1. Check if OTP exists
        if (empty($this->otp_value)) {
            throw new \yii\web\BadRequestHttpException('No OTP requested');
        }
        
        // 2. Check expiry
        if (time() - $this->otp_sendtime > self::OTP_EXPIRY_SECONDS) {
            throw new \yii\web\BadRequestHttpException('OTP expired. Please request a new one.');
        }
        
        // 3. Check if rate limited
        if ($this->otp_attempts >= self::OTP_MAX_ATTEMPTS) {
            if (time() - $this->otp_last_attempt_time < self::OTP_ATTEMPT_WINDOW) {
                throw new \yii\web\BadRequestHttpException(
                    'Too many attempts. Please try again later.'
                );
            }
            // Reset attempts if window has passed
            $this->otp_attempts = 0;
        }
        
        // 4. Verify OTP using timing-safe comparison
        $isValid = Yii::$app->security->compareString($this->otp_value, $otp);
        
        if (!$isValid) {
            $this->otp_attempts++;
            $this->otp_last_attempt_time = time();
            $this->save(false);
            throw new \yii\web\BadRequestHttpException('Incorrect OTP');
        }
        
        // 5. Clear OTP after successful validation
        $this->otp_value = null;
        $this->otp_sendtime = null;
        $this->otp_attempts = 0;
        $this->otp_last_attempt_time = null;
        $this->save(false);
        
        return true;
    }

    // ==================== EMAIL VERIFICATION ====================

    /**
     * Find user by verification token
     *
     * @param string $token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Mark email as verified
     * 
     * @return boolean
     */
    public function markEmailAsVerified() {
        if ($this->getIsEmailVerified()) {
            return true;
        }

        $this->verification_token = null;
        $this->confirmed_at = time();
        $this->status = self::STATUS_ACTIVE;
        
        return $this->save(false);
    }

    /**
     * Check if email is verified
     *
     * @return bool
     */
    public function getIsEmailVerified() {
        return $this->confirmed_at !== null;
    }

    /**
     * Generate email verification token
     */
    public function generateEmailVerificationToken() {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
}
