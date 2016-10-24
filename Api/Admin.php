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
 * Admin api class.
 */
class Piwik_Api_Admin extends Zikula_AbstractApi
{
    /**
     * Get Piwik sites
     * 
     * This function returns the sites of the Piwik instance.
     * 
     * @return array Piwik sites
     */
    public function getSites()
    {
        $tracking_piwikpath = $this->getVar('tracking_piwikpath', '');
        $tracking_enable = $this->getVar('tracking_enable', false);

        if (!$tracking_enable) {
            return false;
        }

        if (empty($tracking_piwikpath)) {
            return false;
        }

        $dataHelper = \ServiceUtil::get('phaidon_piwik_module.helper.piwik_data_helper');
        $siteList = $dataHelper->getData('SitesManager.getSitesWithAtLeastViewAccess');
        if (!$siteList) {
            return LogUtil::registerError($this->__('An error occured. Please check URL and auth token. You need at least view access to one site.'));
        }

        $sites = [];
        foreach ($siteList as $site) {
            $sites[$site['name']] = $site['idsite'];
        }

        ksort($sites);

        return $sites;
    }
}
