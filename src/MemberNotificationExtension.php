<?php

namespace WebTorque\Notifications;



use WebTorque\Notifications\Models\Notification;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;




/**
 * Adds a reference back to the Notification object on Member.
 */
class MemberNotificationExtension extends DataExtension
{
    private static $db = [
        'MobileNumber' => 'Varchar(50)',
    ];

    private static $has_many = [
        'Notifications' => Notification::class,
    ];

    /**
     * @inheritDoc
     * @param  FieldList $fieldList List of fields.
     * @return void
     */
    public function updateCMSFields(FieldList $fieldList)
    {
        // Don't show outstanding notification for a Member in the backend.
        $fieldList->removeByName('Notifications');
    }
}
