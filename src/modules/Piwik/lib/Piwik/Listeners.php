<?php
/**
 * Copyright Piwik Team 2011
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @package Piwik
 * @link https://github.com/phaidon/Piwik
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

/**
 * Provides module listeners for the Piwik module.
 */
class Piwik_Listeners
{

    /**
     * Event listener for 'core.postinit' event.
     * 
     * @param Zikula_Event $event Event.
     * 
     * @return void
     */
    public static function coreinit(Zikula_Event $event)
    {
        ModUtil::apiFunc('Piwik', 'user', 'tracker');
    }

}
