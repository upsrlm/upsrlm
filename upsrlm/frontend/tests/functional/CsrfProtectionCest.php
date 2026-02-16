<?php
namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class CsrfProtectionCest
{
    public function ensureLoginFormHasCsrf(FunctionalTester $I)
    {
        $I->amOnPage(['/site/login']);
        $I->seeElement('input[name="_csrf-upsrlm"]');
        $csrf = $I->grabValueFrom('input[name="_csrf-upsrlm"]');
        $I->assertNotEmpty($csrf);
    }

    public function ensureLoginFailsWithoutCsrf(FunctionalTester $I)
    {
        $I->sendPOST('/site/login', [
            'LoginForm[username]' => 'demo',
            'LoginForm[password]' => 'demo_password',
            // No CSRF token
        ]);
        $I->seeCurrentUrlEquals('/site/login');
        $I->see('The CSRF token could not be verified');
    }

    public function ensureLoginSucceedsWithCsrf(FunctionalTester $I)
    {
        $I->amOnPage(['/site/login']);
        $csrf = $I->grabValueFrom('input[name="_csrf-upsrlm"]');
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'demo',
            'LoginForm[password]' => 'demo_password',
            '_csrf-upsrlm' => $csrf,
        ]);
        $I->see('Logout', 'form button[type=submit],a');
    }
}
