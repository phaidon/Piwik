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
     * Get Piwik sites
     * 
     * This function returns the sites of the Piwik instance.
     * 
     * @return arry Piwik sites
     */
    public function getSites()
    {
        $tracking_piwikpath = $this->getVar('tracking_piwikpath', '');
        $tracking_enable = $this->getVar('tracking_enable', false);
        
        if (!$tracking_enable) {
            return true;
        }
        
        if (empty($tracking_piwikpath)) {
            return false;
        }

        $params = array(
            'method' => 'SitesManager.getSitesWithAtLeastViewAccess'
        );
        $sites0 = ModUtil::apiFunc($this->name, 'dashboard', 'data', $params);
        
        if (!$sites0) {
            return LogUtil::registerError('An error occured. Please check URL and auth token. You need at least view access to one site.');
        }
        
        $sites = array();
        foreach($sites0 as $site) {
            $sites[] = array(
                'value' => $site['idsite'],
                'text'  => $site['name']
            );
        }
        
        return $sites;
    }
    
    
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
            array(
                'url' => ModUtil::url('Piwik', 'admin', 'troubleshooting'), 
                'text' => $this->__('Troubleshooting'),
                'class' => 'z-icon-es-help'
            ),
        );
        return $links;
    }

}
