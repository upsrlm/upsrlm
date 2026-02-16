<?php
namespace backend\tests\functional;

use backend\tests\FunctionalTester;

class SiteControllerCest
{
    public function ensureLoginFormHasCsrf(FunctionalTester $I)
    {
        $I->amOnPage(['/site/login']);
        $I->seeElement('input[name="_csrf-backend"]');
        $csrf = $I->grabValueFrom('input[name="_csrf-backend"]');
        $I->assertNotEmpty($csrf);
    }

    public function ensureLoginFailsWithoutCsrf(FunctionalTester $I)
    {
        $I->sendPOST('/site/login', [
            'LoginForm[username]' => 'erau',
            'LoginForm[password]' => 'password_0',
            // No CSRF token
        ]);
        $I->seeCurrentUrlEquals('/site/login');
        $I->see('The CSRF token could not be verified');
    }

    public function ensureLoginSucceedsWithCsrf(FunctionalTester $I)
    {
        $I->amOnPage(['/site/login']);
        $csrf = $I->grabValueFrom('input[name="_csrf-backend"]');
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'erau',
            'LoginForm[password]' => 'password_0',
            '_csrf-backend' => $csrf,
        ]);
        $I->see('Logout (erau)', 'form button[type=submit]');
    }

    public function ensureProtectedActionsRequireAuth(FunctionalTester $I)
    {
        $I->amOnPage(['/site/index']);
        $I->seeInCurrentUrl('/site/login');
        $I->amOnPage(['/site/changepassword']);
        $I->seeInCurrentUrl('/site/login');
    }

    public function ensureLogoutRequiresPost(FunctionalTester $I)
    {
        $I->amLoggedInAs(1); // assumes user fixture with id=1
        $I->amOnPage(['/site/logout']);
        $I->seeResponseCodeIs(405); // Method Not Allowed
    }
}
