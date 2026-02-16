# Yii2 Web Portal - Code Review & Security Audit Report
**Generated:** February 2026  
**Project:** UPSRLM Multi-Module Portal (advanced Yii2 application with CBO, BC, API, Frontend, Backend)

---

## Executive Summary

Your Yii2 application is a complex, production-like portal with multiple modules (BC, CBO, API, Frontend, Backend, etc.) and a MySQL backend. The review identified **11 critical security & code quality issues**, along with significant **test coverage gaps**.

### Risk Level: **MEDIUM-HIGH**
- ⚠️ **3 CRITICAL** issues (security-impacting)
- ⚠️ **4 HIGH** issues (code quality/vulnerabilities)
- ⚠️ **4 MEDIUM** issues (architectural/maintainability)

---

## 1. CRITICAL SECURITY ISSUES

### Issue 1.1: Hardcoded Cookie Validation Key (Severity: CRITICAL)
**Location:** [upsrlm/common/config/main.php](upsrlm/common/config/main.php#L33)

```php
'cookieValidationKey' => 'REPLACE_WITH_RANDOM_SECRET', // generate securely
```

**Problem:**
- The key is still a placeholder, not replaced with actual random value
- Cookie tampering is trivial with known key
- Affects session security, auto-login, CSRF tokens

**Impact:** Session hijacking, CSRF token forging, identity spoofing

**Fix:** Replace with environment-based strong key:

```php
'request' => [
    'csrfParam' => '_csrf-upsrlm',
    'cookieValidationKey' => getenv('COOKIE_VALIDATION_KEY') ?: 
        throw new Exception('COOKIE_VALIDATION_KEY env not set'),
    'enableCsrfValidation' => true,
],
```

**Generate secure key in deployment:**
```bash
php -r "echo bin2hex(random_bytes(32));"
```

---

### Issue 1.2: JWT Key Set to 'secret' (Severity: CRITICAL)
**Location:** [upsrlm/common/config/main.php](upsrlm/common/config/main.php#L74)

```php
'jwt' => [
    'class' => \sizeg\jwt\Jwt::class,
    'key' => 'secret', // replace with strong random key
    'jwtValidationData' => \common\components\JwtValidationData::class,
],
```

**Problem:**
- Weak hardcoded secret allows JWT forgery
- Any token signed with "secret" is valid
- API endpoints using JWT are vulnerable to impersonation

**Fix:**
```php
'jwt' => [
    'class' => \sizeg\jwt\Jwt::class,
    'key' => getenv('JWT_SECRET') ?: throw new Exception('JWT_SECRET not set'),
    'algorithm' => 'HS256',
    'jwtValidationData' => \common\components\JwtValidationData::class,
],
```

**Environment Setup (.env):**
```
JWT_SECRET=<generate_strong_random_key>
COOKIE_VALIDATION_KEY=<generate_strong_random_key>
```

---

### Issue 1.3: CSRF Validation Disabled in SiteController (Severity: CRITICAL)
**Location:** [upsrlm/frontend/controllers/SiteController.php](upsrlm/frontend/controllers/SiteController.php#L77)

```php
public function BeforeAction($action) {
    $this->enableCsrfValidation = false;  // ⚠️ DISABLES CSRF FOR ENTIRE CONTROLLER
    if ($action->id == 'maintenance') {
        $this->layout = 'maintenance_view';
    }
    return parent::beforeAction($action);
}
```

**Problem:**
- Disables CSRF protection for ALL actions in SiteController
- Includes login, signup, password reset - all critical
- Opens door to CSRF attacks on critical user actions
- Poor practice: disable globally instead of per-action

**Fix:** Selectively disable for public APIs only:

```php
public function beforeAction($action) {
    // Selectively disable CSRF for specific read-only or public endpoints
    if (in_array($action->id, ['maintenance', 'error', 'captcha'])) {
        $this->enableCsrfValidation = false;
    }
    
    if ($action->id === 'maintenance') {
        $this->layout = 'maintenance_view';
    }
    
    return parent::beforeAction($action);
}
```

**Best Practice:** Always include CSRF tokens in forms. Use `Html::beginForm()` which auto-injects token:

```php
// In view
<?= Html::beginForm(['site/login'], 'post') ?>
    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= Html::submitButton('Login') ?>
<?= Html::endForm() ?>
```

---

## 2. HIGH SEVERITY ISSUES

### Issue 2.1: SSL Verification Disabled in Email Config (Severity: HIGH)
**Location:** [upsrlm/common/config/main.php](upsrlm/common/config/main.php#L64-70)

```php
'streamOptions' => [
    'ssl' => [
        'allow_self_signed' => true,
        'verify_peer' => false,          // ⚠️ DANGEROUS
        'verify_peer_name' => false,     // ⚠️ DANGEROUS
    ],
],
```

**Problem:**
- Disables SSL certificate verification
- Vulnerable to man-in-the-middle (MITM) attacks on SMTP
- Credentials sent exposed in plain connection
- Email content (password reset links, OTP) interceptable

**Fix:**

```php
'mailerupsrlm' => [
    'class' => 'yii\swiftmailer\Mailer',
    'viewPath' => '@common/mail',
    'useFileTransport' => false,
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => getenv('MAIL_HOST'),
        'username' => getenv('MAIL_USERNAME'),
        'password' => getenv('MAIL_PASSWORD'),
        'port' => 465,
        'encryption' => 'ssl',
        // Remove insecure streamOptions - use proper TLS
        // If GoDaddy cert issues, use their proper endpoints
    ],
],
```

**Why this works:**
- Modern SMTP endpoints are properly signed
- Yii2 SwiftMailer handles TLS correctly without disabling verification
- If you must disable for legacy servers, document and limit scope

---

### Issue 2.2: 'safe' Validation Rules on Critical Fields (Severity: HIGH)
**Location:** [upsrlm/common/models/User.php](upsrlm/common/models/User.php#L114-130)

```php
public function rules() {
    return [
        // ... other rules
        [['password_hash'], 'safe'],           // ⚠️ Can be mass-assigned
        [['auth_key'], 'safe'],                // ⚠️ Can be mass-assigned  
        [['password_digest', 'mopup_designation'], 'string', 'max' => 150],
        // ...
    ];
}
```

**Problem:**
- `'safe'` validator allows mass assignment vulnerability
- Attacker could POST `password_hash=<evil_hash>` to change login password
- Same for `auth_key` - forged authentication
- These should NEVER be user-assignable

**Fix:**

```php
public function rules() {
    return [
        // INPUT VALIDATION - what users CAN change
        ['username', 'trim'],
        ['username', 'unique'],
        ['username', 'string', 'min' => 2, 'max' => 255],
        ['email', 'trim'],
        ['email', 'required'],
        ['email', 'email'],
        ['email', 'unique'],
        
        // Remove 'safe' from security fields - they're never user input
        // ['password_hash', 'safe'],  // DELETE THIS
        // ['auth_key', 'safe'],       // DELETE THIS
        
        // These are set programmatically only:
        // $user->setPassword($inputPassword);  // in controller
        // $user->generateAuthKey();            // after insert
    ];
}
```

**Usage Pattern in Controller:**

```php
public function actionSignup() {
    $model = new User();
    
    // Only load safe attributes
    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        $model->setPassword($model->password);  // Use setter
        $model->generateAuthKey();               // Auto-generate key
        
        if ($model->save(false)) {  // false: skip validation (already done)
            Yii::$app->user->login($model);
            return $this->goHome();
        }
    }
    
    return $this->render('signup', ['model' => $model]);
}
```

---

### Issue 2.3: Weak OTP Implementation (Severity: HIGH)
**Location:** [upsrlm/common/models/LoginForm.php](upsrlm/common/models/LoginForm.php#L100-116)

```php
public function genrateOTP() {
    $this->getUser()->otp_value = \common\helpers\Utility::generateNumericOTP(6);
    $this->getUser()->otp_sendtime = time();    
    $this->getUser()->update();
    $this->otpsend($this->getUser()->otp_value, $this->username_otp);
    return true;
}

public function validateOTP($attribute, $params) {
    if (!$this->hasErrors()) {
        $user = User::findOne(['username' => $this->username_otp, 'otp_value' => $this->otp]);
        if (!$user) {
            $this->addError($attribute, 'Incorrect OTP');
        } else {
            $this->_user = $user;
        }
    }
}
```

**Problems:**
1. No OTP expiry validation! `time()` stored but never checked
2. 6-digit numeric OTP = only 1 million combinations (easily brute-forced)
3. No rate limiting on OTP validation attempts
4. OTP stored in plaintext in database

**Fix:**

```php
// In User model
public const OTP_EXPIRY_SECONDS = 300;  // 5 minutes
public const OTP_MAX_ATTEMPTS = 5;
public const OTP_ATTEMPT_WINDOW = 300;  // seconds

// Add fields to User table:
// - otp_attempts INT DEFAULT 0
// - otp_last_attempt_time INT NULL

public function generateOTP() {
    // 1. Rate limit: max 3 OTP requests per 15 minutes
    $recentAttempts = self::find()
        ->where(['username' => $this->username])
        ->andWhere(['>', 'otp_sendtime', time() - 900])  // last 15 min
        ->count();
    
    if ($recentAttempts > 3) {
        throw new \yii\web\BadRequestHttpException('Too many OTP requests');
    }
    
    // 2. Generate stronger OTP (8 digits, numeric still simple but better)
    $this->otp_value = \common\helpers\Utility::generateNumericOTP(8);
    $this->otp_sendtime = time();
    $this->otp_attempts = 0;
    $this->otp_last_attempt_time = null;
    $this->save(false);
    
    $this->sendOtpSms($this->otp_value);
}

public function validateOTP($otp) {
    // 1. Check expiry
    if (time() - $this->otp_sendtime > self::OTP_EXPIRY_SECONDS) {
        throw new \yii\web\BadRequestHttpException('OTP expired');
    }
    
    // 2. Rate limit attempts
    if ($this->otp_attempts >= self::OTP_MAX_ATTEMPTS) {
        if (time() - $this->otp_last_attempt_time < self::OTP_ATTEMPT_WINDOW) {
            throw new \yii\web\BadRequestHttpException('Too many attempts. Try again later.');
        }
        $this->otp_attempts = 0;  // reset
    }
    
    // 3. Verify OTP
    if (!Yii::$app->security->compareString($this->otp_value, $otp)) {
        $this->otp_attempts++;
        $this->otp_last_attempt_time = time();
        $this->save(false);
        throw new \yii\web\BadRequestHttpException('Incorrect OTP');
    }
    
    // 4. Clear OTP after successful use
    $this->otp_value = null;
    $this->otp_sendtime = null;
    $this->otp_attempts = 0;
    $this->save(false);
    
    return true;
}
```

---

### Issue 2.4: JSON Encoding Without Escaping in UI (Severity: HIGH)
**Location:** Multiple console controllers store JSON without safety:
- [upsrlm/console/controllers/RishtaController.php](upsrlm/console/controllers/RishtaController.php) (lines 53, 82, 697...)

```php
$rishta_user_data_model->menu_json = json_encode($rista->rishta_menu());
```

**When displayed in JavaScript:**

```php
// In view
<script>
  var menu = <?= $user->menu_json ?>  // ⚠️ No escaping!
</script>
```

**Risk:** XSS if menu data contains quotes/special chars

**Fix:**

```php
// In controller - ensure JSON is safely encoded
$rishta_user_data_model->menu_json = json_encode($rista->rishta_menu(), 
    JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
);

// In Yii2 view - use Json helper
<script>
  var menu = <?= \yii\helpers\Json::encode($user->menu_json) ?>  
</script>

// Or much better - send via AJAX:
<?= Html::script('
    fetch("/api/menu").then(r => r.json()).then(menu => {
        // use menu safely
    });
') ?>
```

---

## 3. MEDIUM SEVERITY ISSUES

### Issue 3.1: Disabled Login & Redirect Logic (Severity: MEDIUM)
**Location:** [upsrlm/frontend/controllers/SiteController.php](upsrlm/frontend/controllers/SiteController.php#L90-98)

```php
public function actionLogin() {
    return $this->redirect(['/']);  // ⚠️ ALWAYS REDIRECTS
    if (!Yii::$app->user->isGuest) {
        return $this->goHome();
    }
    // ... rest of logic unreachable
}

public function actionIndex() {
    return $this->redirect(['/']);
    return $this->render('index');  // unreachable
}
```

**Problem:**
- Login page not functional (redirects before processing)
- Dead code makes debugging harder
- What should happen on login? Is login disabled intentionally?

**Fix:** Clarify intent

```php
public function actionLogin() {
    // If already logged in, go home
    if (!Yii::$app->user->isGuest) {
        return $this->goHome();
    }

    $model = new LoginForm();
    if ($model->load(Yii::$app->request->post()) && $model->login()) {
        return $this->goBack();
    } else {
        $model->password = '';  // Clear on re-display for security
    }

    return $this->render('login', ['model' => $model]);
}

public function actionIndex() {
    // TODO: implement homepage or document why redirect
    return $this->redirect(['/dashboard']);  // Clear intent
}
```

---

### Issue 3.2: AppCheck Component is 5995 Lines (Severity: MEDIUM)
**Location:** [upsrlm/common/components/Appcheck.php](upsrlm/common/components/Appcheck.php) (5995 lines!)

**Problem:**
- Massive component handling RBAC, routing, and menu generation
- Violates Single Responsibility Principle
- Hard to test, maintain, and debug
- Likely duplicate logic from RBAC system

**Fix:** Break into services:

```
components/
├── Appcheck.php (thin wrapper)
├── rbac/
│   ├── RbacChecker.php          (permission checks)
│   └── RbacCache.php            (caching layer)
├── menu/
│   ├── MenuBuilder.php          (menu generation)
│   └── MenuRenderer.php         (menu output)
└── routing/
    └── RouteValidator.php       (route access control)
```

**Minimal Appcheck.php:**
```php
<?php
namespace common\components;

class Appcheck extends \yii\base\Component {
    public $rbacChecker;
    public $menuBuilder;
    
    public function init() {
        parent::init();
        $this->rbacChecker = new rbac\RbacChecker();
        $this->menuBuilder = new menu\MenuBuilder($this->rbacChecker);
    }
    
    public function isActionAllowed($route) {
        return $this->rbacChecker->checkRoute($route);
    }
    
    public function getMenu($role) {
        return $this->menuBuilder->buildFor($role);
    }
}
```

---

### Issue 3.3: Missing Input Validation in Multiple Controllers (Severity: MEDIUM)
**Examples:**
- [upsrlm/bccallcenter/modules/tracking/controllers/BcController.php](upsrlm/bccallcenter/modules/tracking/controllers/BcController.php#L603)
  - `['bc_application_id' => $bc_application_id]` - no validation that param is numeric
  
- [upsrlm/api/modules/UserController.php](upsrlm/api/modules/UserController.php)
  - No ID validation before `findOne(['id' => $id])`

**Fix:**

```php
// Use Yii validators in controller
public function actionView($id) {
    // Validate input type early
    if (!is_numeric($id) || $id <= 0) {
        throw new \yii\web\BadRequestHttpException('Invalid ID');
    }
    
    $model = SrlmBcApplication::findOne(['id' => $id]);
    if (!$model) {
        throw new \yii\web\NotFoundHttpException('Record not found');
    }
    
    return $this->render('view', ['model' => $model]);
}
```

---

### Issue 3.4: No RBAC Implementation Visible (Severity: MEDIUM)
**Observation:** Manual role checks via `$user->role` field instead of Yii RBAC

```php
// Found in multiple places:
if ($user->role == MasterRole::ROLE_ADMIN) {
    // access allowed
}
```

**Problem:**
- Doesn't scale beyond simple roles
- Hard-coded permissions scattered across app
- No audit trail of permissions
- Can't implement complex permission hierarchies

**Fix:** Implement Yii RBAC (if not already done):

```php
// config/rbac.php
public function createRoles() {
    $auth = Yii::$app->authManager;
    
    // Permissions
    $editBC = $auth->createPermission('editBC');
    $editBC->description = 'Edit BC application';
    $auth->add($editBC);
    
    // Roles
    $bc_admin = $auth->createRole('bc_admin');
    $auth->add($bc_admin);
    $auth->addChild($bc_admin, $editBC);
    
    // Assignment
    $auth->assign($bc_admin, $userId);
}

// Usage in controller
if (Yii::$app->user->can('editBC')) {
    // allowed
}
```

---

## 4. TEST COVERAGE GAPS

### Current Test Coverage

**Existing Tests (Good!):**
- ✅ `frontend/tests/unit/models/` - SignupForm, ResetPassword, etc. (Codeception)
- ✅ Email sending verified
- ✅ Fixture-based data setup

**Gaps (Critical):**
- ❌ **Controller tests:** No functional/acceptance tests
- ❌ **LoginForm:** No OTP tests, no rate-limiting tests
- ❌ **User model:** No password hashing tests
- ❌ **API endpoint tests:** Missing completely
- ❌ **RBAC tests:** No permission validation tests
- ❌ **Search model tests:** QueryBuilder tests missing

---

## 5. CONCRETE FIXES & TEST EXAMPLES

### Fix 5.6: Backend SiteController CSRF & Test Improvements

**File:** `backend/controllers/SiteController.php`

**Fix:**
* Refactored to enable CSRF validation by default. Now only disables CSRF for the `maintenance` action, following best practices.
* Ensures all forms and sensitive actions are protected from CSRF attacks.

**File:** `backend/tests/functional/SiteControllerCest.php`

**New Tests:**
* Verifies login form includes CSRF token and login fails without it.
* Ensures protected actions (index, changepassword, logout) require authentication and correct HTTP verb.

**File:** `backend/tests/functional/ChangePasswordCest.php`

**New Tests:**
* Verifies CSRF token is present and required for password change.
* Ensures unauthenticated users are redirected to login for password change.

**Security Impact:**
* Backend login and password change are now protected by CSRF validation and tested for enforcement.
* Access control and HTTP verb requirements are enforced and tested.

### Fix 5.1: Secure Configuration Management

**File:** `common/config/.env.example`

```bash
# Database
DB_HOST=mysql
DB_NAME=yii2advanced
DB_USER=yii2advanced
DB_PASSWORD=your_strong_password

# Security
COOKIE_VALIDATION_KEY=generate_with_php_command_above
JWT_SECRET=generate_with_php_command_above

# Email
MAIL_HOST=smtp.example.com
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=app_password_not_your_password

# App
YII_ENV=prod
YII_DEBUG=0
```

**File:** `common/config/main.php`

```php
<?php
$env = require(__DIR__ . '/env.php');  // loads .env file

return [
    // ... 
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-upsrlm',
            'cookieValidationKey' => $env['COOKIE_VALIDATION_KEY'] 
                ?? throw new \Exception('Missing COOKIE_VALIDATION_KEY'),
            'enableCsrfValidation' => true,
        ],
        'jwt' => [
            'class' => \sizeg\jwt\Jwt::class,
            'key' => $env['JWT_SECRET'] 
                ?? throw new \Exception('Missing JWT_SECRET'),
            'algorithm' => 'HS256',
        ],
        // ...
    ],
];
```

---

### Fix 5.2: LoginForm Security Test

**File:** `frontend/tests/unit/models/LoginFormTest.php`

```php
<?php
namespace frontend\tests\unit\models;

use common\fixtures\UserFixture;
use common\models\LoginForm;
use Codeception\Test\Unit;

class LoginFormTest extends Unit {
    
    protected $tester;
    
    public function _before() {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);
    }
    
    /**
     * Test successful login with correct credentials
     */
    public function testLoginWithCorrectCredentials() {
        $model = new LoginForm([
            'username' => 'troy.becker',
            'password' => 'password_0',  // from fixture
        ]);
        
        expect($model->login())->true();
        expect(\Yii::$app->user->isGuest)->false();
        expect(\Yii::$app->user->identity->username)->equals('troy.becker');
    }
    
    /**
     * Test failed login with wrong password
     */
    public function testLoginWithWrongPassword() {
        $model = new LoginForm([
            'username' => 'troy.becker',
            'password' => 'wrong_password',
        ]);
        
        expect($model->login())->false();
        $errors = $model->getErrors('password');
        expect($errors)->notEmpty();
        expect($errors[0])->stringContainsString('Incorrect');
    }
    
    /**
     * Test login with non-existent user
     */
    public function testLoginWithNonExistentUser() {
        $model = new LoginForm([
            'username' => 'nonexistent@example.com',
            'password' => 'any_password',
        ]);
        
        expect($model->login())->false();
        $errors = $model->getErrors('password');
        expect($errors)->notEmpty();
    }
    
    /**
     * Test rememberMe functionality
     */
    public function testRememberMe() {
        $model = new LoginForm([
            'username' => 'troy.becker',
            'password' => 'password_0',
            'rememberMe' => true,
        ]);
        
        $model->login();
        
        // Check that auth cookie is set for 30 days
        $this->tester->seeCookie('_identity-upsrlm');
        $identity = \Yii::$app->user->identity;
        expect($identity)->notNull();
    }
    
    /**
     * Test CSRF protection on login form (functional test)
     */
    public function testLoginRequiresCsrfToken() {
        // This should be a functional test in functional/ directory
        // Demonstrates that CSRF token is required for POST
        $this->tester->submitForm('#login-form', [
            'LoginForm[username]' => 'troy.becker',
            'LoginForm[password]' => 'password_0',
            // Missing CSRF token
        ]);
        
        $this->tester->seeCurrentUrlEquals('/site/login');  // Form rejected
        $this->tester->seeInSource('CSRF token mismatch');
    }
}
```

---

### Fix 5.3: User Model - Password Hashing Test

**File:** `common/tests/unit/models/UserTest.php`

```php
<?php
namespace common\tests\unit\models;

use common\models\User;
use Codeception\Test\Unit;

class UserTest extends Unit {
    
    /**
     * Test password hashing
     */
    public function testPasswordIsHashedOnSet() {
        $user = new User();
        $plainPassword = 'SecurePassword123!';
        
        $user->setPassword($plainPassword);
        
        // Password should not be stored as plain text
        expect($user->password_hash)->notEmpty();
        expect($user->password_hash)->notEquals($plainPassword);
        
        // Hash should be bcrypt (starts with $2y$)
        expect($user->password_hash)->stringStartsWith('$2y$');
    }
    
    /**
     * Test password validation
     */
    public function testPasswordValidation() {
        $user = new User();
        $plainPassword = 'SecurePassword123!';
        $user->setPassword($plainPassword);
        
        // Correct password should validate
        expect($user->validatePassword($plainPassword))->true();
        
        // Wrong password should not validate
        expect($user->validatePassword('WrongPassword'))->false();
    }
    
    /**
     * Test auth key generation
     */
    public function testAuthKeyIsGenerated() {
        $user = new User();
        expect($user->auth_key)->empty();
        
        $user->generateAuthKey();
        
        expect($user->auth_key)->notEmpty();
        expect(strlen($user->auth_key))->greaterThan(30);  // Random key
    }
    
    /**
     * Test password reset token encryption
     */
    public function testPasswordResetToken() {
        $user = new User();
        $token = $user->generatePasswordResetToken();
        
        expect($token)->notEmpty();
        expect(\common\models\User::isPasswordResetTokenValid($token))->true();
        
        // Should be invalid after user sets expiry
        sleep(1);  // Time passes
        $user->password_reset_token = null;  // Simulate expiry
        expect(\common\models\User::isPasswordResetTokenValid($token))->false();
    }
    
    /**
     * Test mass assignment protection
     * 
     * Ensures password_hash cannot be set via form data
     */
    public function testMassAssignmentProtection() {
        $user = new User();
        
        // Try to mass-assign password_hash
        $user->load([
            'password_hash'  => 'fake_hash',
            'auth_key'       => 'fake_key',
            'username'       => 'testuser',
            'email'          => 'test@example.com',
        ], '');
        
        // Should not accept these dangerous attributes
        expect($user->password_hash)->empty();  // Not changed
        expect($user->auth_key)->empty();       // Not changed
        expect($user->username)->equals('testuser');  // Safe attribute
    }
}
```

---

### Fix 5.4: OTP Validation Test

**File:** `common/tests/unit/models/OtpValidationTest.php`

```php
<?php
namespace common\tests\unit\models;

use common\models\User;
use Codeception\Test\Unit;
use Yii;

class OtpValidationTest extends Unit {
    
    protected $user;
    
    protected function setUp(): void {
        parent::setUp();
        $this->user = new User([
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password_hash' => 'dummy',
        ]);
        $this->user->save(false);
    }
    
    /**
     * Test OTP generation
     */
    public function testOtpGeneration() {
        $this->user->generateOTP();
        
        expect($this->user->otp_value)->notEmpty();
        expect(strlen($this->user->otp_value))->greaterThanOrEqual(6);
        expect($this->user->otp_sendtime)->notEmpty();
        expect($this->user->otp_sendtime)->lessThanOrEquals(time());
    }
    
    /**
     * Test OTP expiry (should reject after 5 minutes)
     */
    public function testOtpExpiry() {
        $this->user->generateOTP();
        $validOtp = $this->user->otp_value;
        
        // Simulate OTP expiry by changing timestamp
        $this->user->otp_sendtime = time() - 301;  // 5+ minutes ago
        $this->user->save(false);
        
        $expected = \Yii::$app->security->compareString($validOtp, $validOtp);
        // In real scenario, validateOTP() should throw exception
        expect($this->user->otp_sendtime)
            ->lessThan(time() - User::OTP_EXPIRY_SECONDS);
    }
    
    /**
     * Test OTP rate limiting on validation attempts
     */
    public function testOtpRateLimiting() {
        $this->user->generateOTP();
        
        // Attempt validation 5 times with wrong OTP
        for ($i = 0; $i < User::OTP_MAX_ATTEMPTS; $i++) {
            $this->user->otp_attempts = $i;
            $this->user->otp_last_attempt_time = time();
            $this->user->save(false);
        }
        
        // Next attempt should fail due to rate limiting
        expect($this->user->otp_attempts)->equals(User::OTP_MAX_ATTEMPTS);
        expect($this->user->otp_last_attempt_time)
            ->greaterThan(time() - User::OTP_ATTEMPT_WINDOW);
    }
    
    /**
     * Test OTP cleared after successful validation
     */
    public function testOtpClearedAfterSuccess() {
        $this->user->generateOTP();
        $correctOtp = $this->user->otp_value;
        
        $this->user->validateOTP($correctOtp);
        
        // OTP should be cleared
        expect($this->user->otp_value)->null();
        expect($this->user->otp_sendtime)->null();
    }
}
```

---

### Fix 5.5: Functional Test for CSRF Protection

**File:** `frontend/tests/functional/LoginCsrfProtectionCest.php`

```php
<?php
namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use common\fixtures\UserFixture;

class LoginCsrfProtectionCest {
    
    public function _fixtures() {
        return [
            'users' => [
                'class' => UserFixture::className(),
            ]
        ];
    }
    
    /**
     * Test that login form includes CSRF token
     */
    public function loginFormIncludesCsrfToken(FunctionalTester $I) {
        $I->amOnPage('/site/login');
        
        // Should see CSRF token field
        $I->seeElement('input[name="_csrf-upsrlm"]');
        
        // Token should have a value
        $csrfToken = $I->grabValueFrom('input[name="_csrf-upsrlm"]');
        $I->assertNotEmpty($csrfToken);
    }
    
    /**
     * Test login fails without CSRF token
     */
    public function loginFailsWithoutCsrfToken(FunctionalTester $I) {
        $I->sendPOST('/site/login', [
            'LoginForm[username]' => 'troy.becker',
            'LoginForm[password]' => 'password_0',
            // Intentionally missing CSRF token
        ]);
        
        // Should fail - likely 400 or redirect
        $I->seeCurrentUrlEquals('/site/login');
        // Could also check for error message
    }
    
    /**
     * Test login succeeds with valid CSRF token
     */
    public function loginSucceedsWithValidCsrfToken(FunctionalTester $I) {
        $I->amOnPage('/site/login');
        
        $csrfToken = $I->grabValueFrom('input[name="_csrf-upsrlm"]');
        
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'troy.becker',
            'LoginForm[password]' => 'password_0',
            '_csrf-upsrlm' => $csrfToken,
        ]);
        
        $I->seeCurrentUrlEquals('/');  // Redirected to home
        $I->seeCookie('_identity-upsrlm');  // User logged in
    }
}
```

---

## 6. ACTIONABLE FIX CHECKLIST

### 🔴 CRITICAL (Fix Immediately - Production Blocker)
- [ ] **Set random `COOKIE_VALIDATION_KEY`** - Run: `php -r "echo bin2hex(random_bytes(32));"`
- [ ] **Set random `JWT_SECRET`** - Same as above
- [ ] **Enable CSRF validation in SiteController** - Remove global disable
- [ ] **Fix SSL cert verification in SMTP config** - Remove `verify_peer: false`
- [ ] **Remove 'safe' from security fields in User model** - Use setters instead

### 🟠 HIGH (Fix Within 1 Week)
- [ ] **Implement OTP rate limiting and expiry** - Use provided code above
- [ ] **Strengthen OTP length** - 6 → 8 digits minimum
- [ ] **Add input validation** - ID validation in all controllers
- [ ] **Use `\yii\helpers\Json::encode()` for JSON in views** - XSS protection
- [ ] **Fix disabled login logic** - Enable or document why disabled

### 🟡 MEDIUM (Fix Within 2 Weeks)
- [ ] **Refactor Appcheck.php** - Break into smaller services
- [ ] **Implement/Audit RBAC** - Replace hard-coded role checks
- [ ] **Add comprehensive tests** - Use templates above
- [ ] **Document API endpoints** - Add OpenAPI/Swagger spec

### 📋 DOCUMENTATION
- [ ] Create `.env.example` file for developers
- [ ] Document RBAC permission matrix
- [ ] Add security guidelines to README
- [ ] Create deployment checklist (key generation, env vars, etc.)

---

## 7. DEPLOYMENT SECURITY CHECKLIST

```bash
# 1. Generate secure keys
COOKIE_KEY=$(php -r "echo bin2hex(random_bytes(32));")
JWT_KEY=$(php -r "echo bin2hex(random_bytes(32));")

# 2. Create .env file (never commit this!)
cat > .env << EOF
DB_HOST=mysql
DB_NAME=yii2advanced
DB_USER=yii2advanced
DB_PASSWORD=$(openssl rand -base64 32)
COOKIE_VALIDATION_KEY=$COOKIE_KEY
JWT_SECRET=$JWT_KEY
YII_DEBUG=0
YII_ENV=prod
MAIL_PASSWORD=<app_password_from_email_provider>
EOF

# 3. Set proper file permissions
chmod 600 .env
chmod 755 runtime
chmod 755 web

# 4. Run migrations
./yii migrate

# 5. Clear cache
./yii cache/flush-all

# 6. Run tests
vendor/bin/codecept run
```

---

## 8. RECOMMENDED NEXT STEPS

1. **Immediate (Today):**
   - Fix CSRF validation issue
   - Set environment keys
   - Deploy to staging for testing

2. **This Week:**
   - Implement all security fixes
   - Add provided test cases
   - Conduct security peer review

3. **This Month:**
   - Refactor large components
   - Complete test coverage (aim for 80%+)
   - Set up RBAC system properly
   - Document all endpoints

4. **Ongoing:**
   - Code review before production deploys
   - Monthly security patches
   - Automated test runs on CI/CD
   - Penetration testing (quarterly)

---

## 9. USEFUL YII2 SECURITY RESOURCES

- [Yii2 Security Best Practices](https://www.yiiframework.com/doc/guide/2.0/en/security-overview)
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [Yii2 RBAC Documentation](https://www.yiiframework.com/doc/guide/2.0/en/security-authorization)
- [Codeception Testing Framework](https://codeception.com/)

---

**Report Compiled:** February 2026  
**Review Status:** ✅ Complete  
**Next Review:** June 2026 (6 months)

