<?php
/**
 * Copyright Piwik Team 2011
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @link https://github.com/phaidon/Piwik
 */

/**
 * Provides module listeners for the Piwik module.
 */
class Piwik_Listeners
{
    // TODO change to event subscriber

    /**
     * Event listener for 'core.postinit' event.
     * 
     * @param Zikula_Event $event Event.
     * 
     * @return void
     */
    public static function coreinit(Zikula_Event $event)
    {
        if (FormUtil::getPassedValue('type', 'user', 'GETPOST') == 'ajax') {
            return;
        }

        unset($event);
        ModUtil::apiFunc('Piwik', 'user', 'tracker');
    }
}
