<?php

/**
 * Copyright Piwik Team 2011
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @package Piwik
 * @link http://code.zikula.org/piwik
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

class Piwik_Api_User extends Zikula_Api {

    // activate tracker in site source
    public function tracker($args)
    {

        // no security check because code should be loaded in every page!

        // check if we are in admin pages
        $adminpage = FormUtil::getPassedValue('type', isset($args['type']) ? $args['type'] : null, 'GET');

        // return if admin pages should not be trackes
        if ($adminpage && $this->getVar('piwik', 'tracking_adminpages') == '0') return;

        // only add piwik code to source if tracking is enabled
        if ($this->getVar('piwik', 'tracking_enable') == '1') {
            $renderer = Zikula_View::getInstance('piwik');
            $renderer->assign($this->getVar('piwik'));
            $trackercode = $renderer->fetch('piwik_userapi_tracker.tpl');

            // add the scripts to page footer
            PageUtil::AddVar('footer', $trackercode);
        }
        return true;
    }
}
