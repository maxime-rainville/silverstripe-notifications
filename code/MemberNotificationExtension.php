<?php

/**
 * Adds a reference back to the Notification object on Member.
 */
class MemberNotificationExtension extends DataExtension
{
    private static $has_many = [
        'Notifications' => 'Notification',
        'MobileNumber' => 'Varchar',
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
