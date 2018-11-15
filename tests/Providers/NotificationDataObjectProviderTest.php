<?php

namespace WebTorque\Notifications\Tests\Providers;







use WebTorque\Notifications\Providers\NotificationDataObjectProvider;
use WebTorque\Notifications\Tests\Mocks\MockParsedNotification;
use WebTorque\Notifications\Tests\Mocks\MockParsedNotificationWithoutSystemSubject;
use WebTorque\Notifications\Exceptions\NotificationFailureException;
use WebTorque\Notifications\Tests\Mocks\MockBadParsedNotification;
use SilverStripe\Security\Member;
use SilverStripe\Dev\SapphireTest;




class NotificationDataObjectProviderTest extends SapphireTest
{
    protected $usesDatabase = true;
    protected static $fixture_file = 'NotificationParserTest.yml';

    public function testSend()
    {
        $provider = new NotificationDataObjectProvider();
        $member = $this->objFromFixture(Member::class, 'tms');
        $parsedNotification = new MockParsedNotification();
        $delivery = $provider->send($parsedNotification, $member);

        $do = $delivery->getDataObject();

        $this->assertGreaterThan(0, $do->ID);
        $this->assertEquals($member->ID, $do->MemberID);
        $this->assertEquals($parsedNotification->getSystemSubject(), $do->Subject);
        $this->assertEquals($parsedNotification->getShortMessage(), $do->ShortMessage);
        $this->assertEquals($parsedNotification->getRichMessage(), $do->RichMessage);
        $this->assertEquals('', $do->CallToActionURL);
    }

    public function testSendWithoutSystemSubject()
    {
        $provider = new NotificationDataObjectProvider();
        $member = $this->objFromFixture(Member::class, 'tms');
        $parsedNotification = new MockParsedNotificationWithoutSystemSubject();
        $delivery = $provider->send($parsedNotification, $member);

        $do = $delivery->getDataObject();

        $this->assertGreaterThan(0, $do->ID);
        $this->assertEquals($member->ID, $do->MemberID);

        // We should default to using the system standard subject if system subject is blank.
        $this->assertEquals($parsedNotification->getSubject(), $do->Subject);

        $this->assertEquals($parsedNotification->getShortMessage(), $do->ShortMessage);
        $this->assertEquals($parsedNotification->getRichMessage(), $do->RichMessage);
        $this->assertEquals('', $do->CallToActionURL);
    }

    public function testFailedParse()
    {
        $this->setExpectedException(NotificationFailureException::class);

        $provider = new NotificationDataObjectProvider();
        $provider->send(new MockBadParsedNotification(), $this->objFromFixture(Member::class, 'tms'));
    }

    public function testSendWithCallToAction()
    {
        $provider = new NotificationDataObjectProvider();
        $member = $this->objFromFixture(Member::class, 'tms');
        $parsedNotification = new MockParsedNotification();
        $delivery = $provider->send($parsedNotification, $member, 'http://example.com');

        $do = $delivery->getDataObject();

        $this->assertEquals('http://example.com', $do->CallToActionURL);
    }
}
