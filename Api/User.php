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

        $dataHelper = \ServiceUtil::get('phaidon_piwik_module.helper.piwik_data_helper');

        $view = Zikula_View::getInstance('Piwik');
        $view->assign('piwikUrl', $dataHelper->getBaseUrl())
             ->assign('siteId', $siteId)
             ->assign('enableLinkTricking', $this->getVar('tracking_linktracking');
        $trackerCode = $view->fetch('userapi/tracker.tpl');

        // add the scripts to page footer
        PageUtil::addVar('footer', $trackerCode);

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

        $dataHelper = \ServiceUtil::get('phaidon_piwik_module.helper.piwik_data_helper');

        $view = Zikula_View::getInstance('Piwik');

        return $view
            ->assign('piwikUrl', $dataHelper->getBaseUrl())
            ->assign('width', $width)
            ->assign('height', $height)
            ->fetch('userapi/optOut.tpl');
    }
}
