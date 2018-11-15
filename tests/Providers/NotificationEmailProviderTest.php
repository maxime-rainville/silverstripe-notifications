<?php

namespace WebTorque\Notifications\Tests\Providers;






use WebTorque\Notifications\Providers\NotificationEmailProvider;
use WebTorque\Notifications\Tests\Mocks\MockParsedNotification;
use WebTorque\Notifications\Exceptions\NotificationFailureException;
use WebTorque\Notifications\Tests\Mocks\MockBadParsedNotification;
use SilverStripe\Security\Member;
use SilverStripe\Dev\SapphireTest;




/**
 * Test registion for Immunoglobin
 */
class NotificationEmailProviderTest extends SapphireTest
{
    protected $usesDatabase = true;
    protected static $fixture_file = 'NotificationParserTest.yml';

    public function testSend()
    {
        $provider = new NotificationEmailProvider();
        $provider->send(new MockParsedNotification(), $this->objFromFixture(Member::class, 'tms'));

        $this->assertEmailSent(
            'tms@nzblood.co.nz',
            null,
            'Mock subject response',
            '/Mock rich message response/'
        );
    }

    public function testFailedParse()
    {
        $this->setExpectedException(NotificationFailureException::class);

        $provider = new NotificationEmailProvider();
        $provider->send(new MockBadParsedNotification(), $this->objFromFixture(Member::class, 'tms'));
    }
}
