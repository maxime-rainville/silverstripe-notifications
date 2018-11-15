<?php

namespace WebTorque\Notifications\Tests;



use WebTorque\Notifications\Models\NotificationType;
use WebTorque\Notifications\ParsedNotification;
use SilverStripe\Security\Member;
use SilverStripe\Dev\SapphireTest;




/**
 * Test registion for Immunoglobin
 */
class ParsedNotificationTest extends SapphireTest
{
    protected static $fixture_file = 'ParsedNotificationTest.yml';
    protected $usesDatabase = true;

    public function testGetters()
    {
        $expected = 'FirstName = TMS AND Foo = Bar';
        $type = $this->objFromFixture(NotificationType::class, 'boom');
        $member = $this->objFromFixture(Member::class, 'tms');

        $notifcation = new ParsedNotification($type, ['Foo' => 'Bar'], $member);

        $this->assertEquals("Short: $expected", $notifcation->getShortMessage());
        $this->assertEquals("Subject: $expected", $notifcation->getSubject());
        $this->assertEquals("<strong>Rich</strong>: $expected", $notifcation->getRichMessage());
        $this->assertEquals("System Subject: $expected", $notifcation->getSystemSubject());
    }
}
