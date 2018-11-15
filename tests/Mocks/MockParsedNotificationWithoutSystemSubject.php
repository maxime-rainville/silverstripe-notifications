<?php

namespace WebTorque\Notifications\Tests\Mocks;




class MockParsedNotificationWithoutSystemSubject extends MockParsedNotification
{
    public function getSystemSubject() {
        return '';
    }
}
