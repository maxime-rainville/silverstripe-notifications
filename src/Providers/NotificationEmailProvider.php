<?php

namespace WebTorque\Notifications\Providers;






use Exception;


use WebTorque\Notifications\Interfaces\ParsedNotificationInterface;
use WebTorque\Notifications\Exceptions\NotificationFailureException;
use WebTorque\Notifications\Deliveries\NotificationDelivery;
use WebTorque\Notifications\Interfaces\NotificationProviderInterface;
use SilverStripe\Security\Member;
use SilverStripe\Control\Email\Email;
use SilverStripe\Core\Config\Config;




/**
 * Notification provider used to send an email notification to a member.
 */
class NotificationEmailProvider implements NotificationProviderInterface
{
    /**
     * @inheritDoc
     * @param  ParsedNotificationInterface $notification    Notification to send.
     * @param  Member                      $member          User meant to receive the message.
     * @param  mixed                       $callToActionURL Relative or absolute URL to an action specific to the notice.
     * @return NotificationDelivery
     */
    public function send(ParsedNotificationInterface $notification, Member $member, $callToActionURL = false)
    {
        $email = new Email();

        if(Config::inst()->get(Email::class, 'queuing') == true){
            $email = $email->addCustomHeader('queue', 1);
        }

        try {
            $response = $email
                ->setTo($member->Email)
                ->setSubject($notification->getSubject())
                ->setBody($notification->getRichMessage())
                ->send();
        } catch (Exception $ex) {
            $failure = new NotificationFailureException('Notification Email delivery failed.');
            throw $failure->setMember($member)->setPrevious($ex);
        }

        return new NotificationDelivery('DELIVERED', 'EMAIL');
    }
}
