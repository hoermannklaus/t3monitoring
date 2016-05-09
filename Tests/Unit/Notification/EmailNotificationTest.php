<?php

namespace T3Monitor\T3monitoring\Tests\Unit\Notification;

use T3Monitor\T3monitoring\Notification\EmailNotification;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use UnexpectedValueException;

class EmailNotificationTest extends UnitTestCase
{

    /**
     * @test
     * @expectedException UnexpectedValueException
     */
    public function sendAdminEmailThrowsExceptionForInvalidEmailAddress()
    {
        $notification = new EmailNotification();
        $notification->sendAdminEmail('invalid', ['client']);
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     */
    public function sendAdminEmailThrowsExceptionForNoClients()
    {
        $notification = new EmailNotification();
        $notification->sendAdminEmail('john@doe.com', []);
    }

    /**
     * @test
     */
    public function senderEmailNameIsCorrectlyReturned()
    {
        $notification = $this->getAccessibleMock(EmailNotification::class, ['dummy']);

        unset($GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromName']);
        $this->assertEquals(EmailNotification::DEFAULT_EMAIL_NAME, $notification->_call('getSenderEmailName'));

        $example = $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromName'] = 'John';
        $this->assertEquals($example, $notification->_call('getSenderEmailName'));
    }

    /**
     * @test
     */
    public function senderEmailAddressIsCorrectlyReturned()
    {
        $notification = $this->getAccessibleMock(EmailNotification::class, ['dummy']);

        unset($GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromAddress']);
        $this->assertEquals(EmailNotification::DEFAULT_EMAIL_ADDRESS, $notification->_call('getSenderEmailAddress'));

        $example = $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromAddress'] = 'someone@domain.tld';
        $this->assertEquals($example, $notification->_call('getSenderEmailAddress'));
    }
}