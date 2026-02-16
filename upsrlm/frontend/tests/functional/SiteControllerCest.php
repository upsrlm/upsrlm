<?php
namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class SiteControllerCest
{
    public function _before(FunctionalTester $I)
    {
        // Setup before each test
    }

    public function ensureIndexPageWorks(FunctionalTester $I)
    {
        $I->amOnPage(['/site/index']);
        $I->see('Login', 'a'); // Adjust as per your homepage
    }

    public function ensureLoginFormValidation(FunctionalTester $I)
    {
        $I->amOnPage(['/site/login']);
        $I->see('Login', 'h1');
        $I->submitForm('#login-form', [
            'LoginForm[username]' => '',
            'LoginForm[password]' => '',
        ]);
        $I->seeValidationError('Username cannot be blank.');
        $I->seeValidationError('Password cannot be blank.');
    }

    public function ensureLoginWorksWithCorrectCredentials(FunctionalTester $I)
    {
        $I->amOnPage(['/site/login']);
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'demo',
            'LoginForm[password]' => 'demo_password',
        ]);
        $I->see('Logout', 'form button[type=submit],a');
    }

    public function ensureSignupValidation(FunctionalTester $I)
    {
        $I->amOnPage(['/site/signup']);
        $I->see('Sign up', 'h1');
        $I->submitForm('#signup-form', [
            'SignupForm[username]' => '',
            'SignupForm[email]' => '',
            'SignupForm[password]' => '',
        ]);
        $I->seeValidationError('Username cannot be blank.');
        $I->seeValidationError('Email cannot be blank.');
        $I->seeValidationError('Password cannot be blank.');
    }

    public function ensureContactFormWorks(FunctionalTester $I)
    {
        $I->amOnPage(['/site/contact']);
        $I->see('Contact', 'h1');
        $I->submitForm('#contact-form', [
            'ContactForm[name]' => 'tester',
            'ContactForm[email]' => 'tester@example.com',
            'ContactForm[subject]' => 'test subject',
            'ContactForm[body]' => 'test content',
        ]);
        $I->see('Thank you for contacting us. We will respond to you as soon as possible.');
    }
}
