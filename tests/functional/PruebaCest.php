<?php
namespace Test;
use Test\FunctionalTester;

class PruebaCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $I->cantSeeInRepository('\USaq\Model\Entity\User', ['username'=> 'abcdefg']);
        $I->sendPOST('/api/user/register', ['username' => 'abcdefg', 'password' => 'gato', 'password_repeat' => 'gato']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['result' => 'OK']);
        $I->canSeeInRepository('\USaq\Model\Entity\User', ['username'=> 'abcdefg1']);
    }
}
