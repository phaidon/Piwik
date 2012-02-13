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
 * User api class.
 */
class Piwik_Api_User extends Zikula_AbstractApi
{

    /**
     * Tracker
     * 
     * This function activates tracker in site source.
     * 
     * @param array $args Tracker arguments.
     * 
     * @return boolean
     */
    public function tracker($args = array() )
    {
        // no security check because code should be loaded in every page!

        // check if we are in admin pages
        $adminpage = (FormUtil::getPassedValue('type', isset($args['type']) ? $args['type'] : null, 'GET') == 'admin');

        // return if admin pages should not be trackes
        if ($adminpage && $this->getVar('tracking_adminpages') == '0') {
            return true;
        }
        // only add piwik code to source if tracking is enabled
        if ($this->getVar('tracking_enable') == 1) {
            $view = Zikula_View::getInstance('Piwik');
            $trackercode = $view->fetch('userapi/tracker.tpl');

            // add the scripts to page footer
            PageUtil::AddVar('footer', $trackercode);
        }
        return true;
    }
    
}
