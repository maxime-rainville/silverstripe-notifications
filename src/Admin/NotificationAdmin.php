<?php

namespace WebTorque\Notifications\Admin;


use WebTorque\Notifications\Models\NotificationType;
use SilverStripe\Admin\ModelAdmin;




/**
 * [NotificationTypesAdmin description]
 */
class NotificationAdmin extends ModelAdmin
{
    private static $menu_title = 'Notifications';
    private static $url_segment = 'notifications';
    private static $managed_models = [NotificationType::class];
}
