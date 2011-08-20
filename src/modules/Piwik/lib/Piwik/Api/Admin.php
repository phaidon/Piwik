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

class Piwik_Api_Admin extends Zikula_AbstractApi {

    /**
     * get links
     * 
     * return the links for the admin menu
     * 
     * @param array $args
     * @return arry admin links
     */
    public function getlinks($args)
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
