<?php

namespace WebTorque\Notifications\Tests;





use WebTorque\Notifications\NotificationParser;
use WebTorque\Notifications\Interfaces\ParsedNotificationInterface;
use WebTorque\Notifications\Exceptions\NotificationFailureException;
use SilverStripe\Security\Member;
use SilverStripe\Dev\SapphireTest;




/**
 * Test registion for Immunoglobin
 */
class NotificationParserTest extends SapphireTest
{
    protected static $fixture_file = 'NotificationParserTest.yml';
    protected $usesDatabase = true;

    public function testSucessParse()
    {
        $parser = new NotificationParser();
        $response = $parser->parse('boom', ['hello' => 'world'], $this->objFromFixture(Member::class, 'tms'));
        $this->assertInstanceOf(ParsedNotificationInterface::class, $response);
    }

    public function testFailedParse()
    {
        $this->setExpectedException(NotificationFailureException::class);
        $parser = new NotificationParser();
        $response = $parser->parse('noBoom', ['hello' => 'world'], $this->objFromFixture(Member::class, 'tms'));
    }
}
