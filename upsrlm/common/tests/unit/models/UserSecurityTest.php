<?php
/**
 * Comprehensive test suite for User model
 * 
 * Tests password hashing, OTP validation, auth, and mass assignment protection
 * 
 * Run with: vendor/bin/codecept run common/tests/unit/models/UserSecurityTest.php
 */

namespace common\tests\unit\models;

use common\fixtures\UserFixture;
use common\models\User;
use Codeception\Test\Unit;
use Yii;

class UserSecurityTest extends Unit {
    
    protected $tester;
    
    /**
     * Load test fixtures
     */
    public function _fixtures() {
        return [
            'users' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ];
    }

    // ==================== PASSWORD HASHING TESTS ====================

    /**
     * Test: Password is hashed using bcrypt
     */
    public function testPasswordIsHashedOnSet() {
        $user = new User();
        $plainPassword = 'SecurePassword123!@#';
        
        // Set password
        $user->setPassword($plainPassword);
        
        // Assertions
        $this->assertNotEmpty($user->password_hash, 'password_hash should not be empty');
        $this->assertNotEquals($plainPassword, $user->password_hash, 
            'password_hash should not equal plain password');
        $this->assertTrue(
            strpos($user->password_hash, '$2y$') === 0,
            'password_hash should be bcrypt (start with $2y$)'
        );
    }

    /**
     * Test: Password validation with correct password
     */
    public function testValidateCorrectPassword() {
        $user = new User();
        $plainPassword = 'MySecurePassword123!';
        $user->setPassword($plainPassword);
        
        $this->assertTrue($user->validatePassword($plainPassword),
            'Should validate correct password');
    }

    /**
     * Test: Password validation with incorrect password
     */
    public function testValidateIncorrectPassword() {
        $user = new User();
        $plainPassword = 'MySecurePassword123!';
        $user->setPassword($plainPassword);
        
        $this->assertFalse($user->validatePassword('WrongPassword'),
            'Should reject wrong password');
        $this->assertFalse($user->validatePassword(''),
            'Should reject empty password');
    }

    /**
     * Test: Password cannot be empty
     */
    public function testSetPasswordThrowsOnEmpty() {
        $user = new User();
        
        $this->expectException(\yii\base\InvalidArgumentException::class);
        $user->setPassword('');
    }

    // ==================== AUTH KEY TESTS ====================

    /**
     * Test: Auth key is generated
     */
    public function testAuthKeyIsGenerated() {
        $user = new User();
        $this->assertEmpty($user->auth_key, 'auth_key should initially be empty');
        
        $user->generateAuthKey();
        
        $this->assertNotEmpty($user->auth_key, 'generateAuthKey should set auth_key');
        $this->assertGreaterThan(20, strlen($user->auth_key), 
            'auth_key should be at least 20 chars');
    }

    /**
     * Test: Auth key validates correctly
     */
    public function testAuthKeyValidation() {
        $user = new User();
        $user->generateAuthKey();
        $generatedKey = $user->auth_key;
        
        $this->assertTrue($user->validateAuthKey($generatedKey),
            'Should validate matching auth key');
        $this->assertFalse($user->validateAuthKey('wrong_key'),
            'Should reject non-matching auth key');
    }

    // ==================== PASSWORD RESET TESTS ====================

    /**
     * Test: Password reset token is generated
     */
    public function testGeneratePasswordResetToken() {
        $user = new User();
        $user->generatePasswordResetToken();
        
        $this->assertNotEmpty($user->password_reset_token,
            'password_reset_token should be generated');
        $this->assertStringContainsString('_', $user->password_reset_token,
            'password_reset_token should contain underscore (format: random_timestamp)');
    }

    /**
     * Test: Password reset token is valid immediately after generation
     */
    public function testPasswordResetTokenIsValidImmediately() {
        $user = new User();
        $user->generatePasswordResetToken();
        $token = $user->password_reset_token;
        
        $this->assertTrue(User::isPasswordResetTokenValid($token),
            'Newly generated token should be valid');
    }

    /**
     * Test: Password reset token expires after configured time
     */
    public function testPasswordResetTokenExpiry() {
        $user = new User();
        $user->generatePasswordResetToken();
        
        // Manually set token with old timestamp (simulate expiry)
        $expireTime = Yii::$app->params['user.passwordResetTokenExpire'];
        $oldTimestamp = time() - $expireTime - 1;  // Past expiry
        $user->password_reset_token = Yii::$app->security->generateRandomString() . '_' . $oldTimestamp;
        
        $this->assertFalse(User::isPasswordResetTokenValid($user->password_reset_token),
            'Expired token should not be valid');
    }

    /**
     * Test: Find user by password reset token
     */
    public function testFindByPasswordResetToken() {
        // Use fixture user
        $user = $this->tester->grabFixture('users', 0);
        $user->generatePasswordResetToken();
        $user->save(false);
        
        $token = $user->password_reset_token;
        $foundUser = User::findByPasswordResetToken($token);
        
        $this->assertNotNull($foundUser);
        $this->assertEquals($user->id, $foundUser->id);
    }

    // ==================== OTP TESTS ====================

    /**
     * Test: OTP is generated with correct format
     */
    public function testGenerateOTP() {
        $user = new User([
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);
        
        $otp = $user->generateOTP();
        
        $this->assertNotEmpty($otp);
        $this->assertIsNumeric($otp);
        $this->assertGreaterThanOrEqual(User::OTP_MIN_LENGTH, strlen($otp),
            'OTP should be at least ' . User::OTP_MIN_LENGTH . ' digits');
        $this->assertNotEmpty($user->otp_sendtime);
    }

    /**
     * Test: OTP validates correctly
     */
    public function testValidateOTP() {
        $user = new User([
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);
        
        $otp = $user->generateOTP();
        
        // Should validate correct OTP
        $this->assertTrue($user->validateOTP($otp));
        
        // OTP should be cleared after validation
        $this->assertEmpty($user->otp_value);
        $this->assertEmpty($user->otp_sendtime);
    }

    /**
     * Test: OTP validation fails with wrong OTP
     */
    public function testValidateWrongOTP() {
        $user = new User([
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);
        
        $user->generateOTP();
        
        $this->expectException(\yii\web\BadRequestHttpException::class);
        $user->validateOTP('00000000');  // Wrong OTP
    }

    /**
     * Test: OTP expires after configured timeout
     */
    public function testOTPExpiry() {
        $user = new User([
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);
        
        $user->generateOTP();
        $otp = $user->otp_value;
        
        // Simulate expiry by modifying timestamp
        $user->otp_sendtime = time() - User::OTP_EXPIRY_SECONDS - 1;
        
        $this->expectException(\yii\web\BadRequestHttpException::class);
        $this->expectExceptionMessage('expired');
        $user->validateOTP($otp);
    }

    /**
     * Test: OTP validation rate limiting
     */
    public function testOTPRateLimiting() {
        $user = new User([
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);
        
        $user->generateOTP();
        
        // Try validation with wrong OTP multiple times
        for ($i = 0; $i < User::OTP_MAX_ATTEMPTS; $i++) {
            try {
                $user->validateOTP('00000000');
            } catch (\yii\web\BadRequestHttpException $e) {
                // Expected
            }
        }
        
        // Next attempt should be rate limited
        $this->expectException(\yii\web\BadRequestHttpException::class);
        $this->expectExceptionMessage('Too many attempts');
        $user->validateOTP('00000000');
    }

    /**
     * Test: OTP cleared after successful validation
     */
    public function testOTPClearedAfterSuccess() {
        $user = new User([
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);
        
        $otp = $user->generateOTP();
        $this->assertNotEmpty($user->otp_value);
        
        $user->validateOTP($otp);
        
        $this->assertNull($user->otp_value);
        $this->assertNull($user->otp_sendtime);
        $this->assertEquals(0, $user->otp_attempts);
    }

    // ==================== MASS ASSIGNMENT PROTECTION TESTS ====================

    /**
     * Test: Cannot mass-assign password_hash via load()
     * 
     * This is the CRITICAL security fix - password_hash should NOT be in rules
     */
    public function testMassAssignmentProtection_PasswordHash() {
        $user = new User();
        
        // Try to mass-assign dangerous attributes
        $user->load([
            'password_hash' => 'fake_bcrypt_hash_$2y$10$abc...',
            'username' => 'testuser',
            'email' => 'test@example.com',
        ], '');
        
        // password_hash should NOT be changed via load()
        $this->assertEmpty($user->password_hash,
            'SECURITY: password_hash must not be mass-assignable');
        
        // Safe fields should load
        $this->assertEquals('testuser', $user->username);
        $this->assertEquals('test@example.com', $user->email);
    }

    /**
     * Test: Cannot mass-assign auth_key via load()
     */
    public function testMassAssignmentProtection_AuthKey() {
        $user = new User();
        
        $user->load([
            'auth_key' => 'fake_key_12345',
            'username' => 'testuser',
            'email' => 'test@example.com',
        ], '');
        
        // auth_key should NOT be changed via load()
        $this->assertEmpty($user->auth_key,
            'SECURITY: auth_key must not be mass-assignable');
        
        // Safe fields should load
        $this->assertEquals('testuser', $user->username);
    }

    /**
     * Test: Proper way to set password (via setter, not load())
     */  
    public function testProperPasswordSetting() {
        $user = new User([
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);
        
        $plainPassword = 'SecurePassword123!';
        
        // Correct way: use setter method
        $user->setPassword($plainPassword);
        $user->generateAuthKey();
        
        // Verify password works
        $this->assertTrue($user->validatePassword($plainPassword));
        $this->assertNotEmpty($user->auth_key);
    }

    // ==================== IDENTITY INTERFACE TESTS ====================

    /**
     * Test: Find identity by ID
     */
    public function testFindIdentity() {
        $user = $this->tester->grabFixture('users', 0);
        
        // findIdentity should find active users
        $found = User::findIdentity($user->id);
        $this->assertNotNull($found);
        $this->assertEquals($user->id, $found->id);
        
        // findIdentity should NOT find inactive users
        $inactiveUser = new User([
            'username' => 'inactive',
            'email' => 'inactive@example.com',
            'status' => User::STATUS_INACTIVE,
        ]);
        $inactiveUser->save(false);
        
        $notFound = User::findIdentity($inactiveUser->id);
        $this->assertNull($notFound);
    }

    /**
     * Test: Find user by username
     */
    public function testFindByUsername() {
        $user = $this->tester->grabFixture('users', 0);
        
        $found = User::findByUsername($user->username);
        $this->assertNotNull($found);
        $this->assertEquals($user->id, $found->id);
    }

    /**
     * Test: ID getter
     */
    public function testGetId() {
        $user = $this->tester->grabFixture('users', 0);
        
        $this->assertEquals($user->id, $user->getId());
    }
}
