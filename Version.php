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
 * Provides metadata for this module to the Extensions module.
 */
class Piwik_Version extends Zikula_AbstractVersion
{
    /**
     * Meta data
     *
     * This function returns the meta data of the module.
     * 
     * @return array
     */
    public function getMetaData()
    {
        $meta = [];
        $meta['description']    = $this->__('Piwik statistics module');
        $meta['displayname']    = $this->__('Piwik statistics');
        //!url must be different to displayname
        $meta['url']            = $this->__('Piwik');
        $meta['version']        = '1.2.0';
        $meta['author']         = '';
        $meta['contact']        = 'https://github.com/phaidon/Piwik';
        $meta['dependencies']   = [];
        $meta['securityschema'] = ['Piwik::' => '::'];

        $meta['capabilities'] = [];
        $meta['capabilities'][HookUtil::PROVIDER_CAPABLE] = ['enabled' => true];

        return $meta;
    }

    protected function setupHookBundles()
    {
        $bundle = new Zikula_HookManager_ProviderBundle($this->name, 'provider.ui_hooks.piwik.optOut', 'ui_hooks', $this->__('Piwik opt-out hook'));
        $bundle->addServiceHandler('display_view', 'Piwik_HookHandler', 'displayView', 'piwik.optOut');
        $this->registerHookProviderBundle($bundle);
    }
}
