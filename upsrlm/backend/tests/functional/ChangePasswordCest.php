<?php
namespace backend\tests\functional;

use backend\tests\FunctionalTester;

class ChangePasswordCest
{
    public function ensureChangePasswordRequiresAuth(FunctionalTester $I)
    {
        $I->amOnPage(['/site/changepassword']);
        $I->seeInCurrentUrl('/site/login');
    }

    public function ensureChangePasswordFormHasCsrf(FunctionalTester $I)
    {
        $I->amLoggedInAs(1); // assumes user fixture with id=1
        $I->amOnPage(['/site/changepassword']);
        $I->seeElement('input[name="_csrf-backend"]');
        $csrf = $I->grabValueFrom('input[name="_csrf-backend"]');
        $I->assertNotEmpty($csrf);
    }

    public function ensureChangePasswordFailsWithoutCsrf(FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->sendPOST('/site/changepassword', [
            'ChangePasswordForm[oldPassword]' => 'password_0',
            'ChangePasswordForm[newPassword]' => 'newpass',
            'ChangePasswordForm[confirmPassword]' => 'newpass',
            // No CSRF token
        ]);
        $I->seeCurrentUrlEquals('/site/changepassword');
        $I->see('The CSRF token could not be verified');
    }
}
