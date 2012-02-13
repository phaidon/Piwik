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
 * Admin api class.
 */
class Piwik_Api_Admin extends Zikula_AbstractApi {

    /**
     * Get links
     * 
     * This function returns the links for the admin menu.
     * 
     * @return arry Admin links
     */
    public function getlinks()
    {

        // create array of links
        $links = array(
            array(
                'url' => ModUtil::url('Piwik', 'admin', 'modifyconfig'), 
                'text' => $this->__('Settings'),
                'class' => 'z-icon-es-config'
            ),
            array(
                'url' => ModUtil::url('Piwik', 'admin', 'dashboard'), 
                'text' => $this->__('Piwik dashboard'),
                'class' => 'z-icon-es-view'
            ),
        );
        return $links;
    }

}
