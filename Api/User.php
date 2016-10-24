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
        $isAdminPage = (FormUtil::getPassedValue('type', isset($args['type']) ? $args['type'] : null, 'GET') == 'admin');
        //$isAdminPage = ($this->request->query->get('type', isset($args['type']) ? $args['type'] : null) == 'admin');

        // return if admin pages should not be trackes
        if ($isAdminPage && $this->getVar('tracking_adminpages') == '0') {
            return true;
        }

        // only add piwik code to source if tracking is enabled
        if ($this->getVar('tracking_enable') != 1) {
            return true;
        }

        $siteId = $this->getVar('tracking_siteid', 'SITEID');
        if ($siteId == 'SITEID') {
            return true;
        }

        $view = Zikula_View::getInstance('Piwik');
        $view->assign('piwikUrl', ModUtil::apiFunc($this->name, 'user', 'getBaseUrl'))
             ->assign('siteId', $siteId)
             ->assign('enableLinkTricking', $this->getVar('tracking_linktracking');
        $trackercode = $view->fetch('userapi/tracker.tpl');

        // add the scripts to page footer
        PageUtil::addVar('footer', $trackercode);

        return true;
    }

    /**
     * Opt out function
     * 
     * This function activates the opt out function needed for deactivating tracking by piwik.
     * 
     * @param array $args optOut arguments.
     * 
     * @return string
     */
    public function optOut($args)
    {
        $width = isset($args['width']) ? $args['width'] : '100%';
        $height = isset($args['height']) ? $args['height'] : '200px';

        $view = Zikula_View::getInstance('Piwik');

        return $view
            ->assign('piwikUrl', ModUtil::apiFunc($this->name, 'user', 'getBaseUrl'))
            ->assign('width', $width)
            ->assign('height', $height)
            ->fetch('userapi/optOut.tpl');
    }

    /**
     * Get Piwik base url
     * 
     * This function provides the piwik base url
     * 
     * @param array $args getBaseUrl arguments.
     * 
     * @return string
     */
    public function getBaseUrl($args)
    {
        $protocol = isset($args['protocol']) ? $args['protocol'] : $this->getVar('tracking_protocol', 3);
        $piwikPath = $this->getVar('tracking_piwikpath');

        switch ($protocol) {
            case 1: //only http
                return 'http://' . $piwikPath . '/';
                break;
            case 2: //only https
                return 'https://' . $piwikPath . '/';
                break;
            case 3: //http/https
                if (null !== $_SERVER['HTTPS']) {
                    return 'https://' . $piwikPath . '/';
                } else {
                    return 'http://' . $piwikPath . '/';
                }
                break;
        }
    }
}
