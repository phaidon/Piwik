<?php
/**
 * Copyright Piwik Team 2016
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @link https://github.com/phaidon/Piwik
 */

namespace Phaidon\PiwikModule\Container;

use Zikula\Bundle\HookBundle\AbstractHookContainer;
use Zikula\Bundle\HookBundle\Bundle\ProviderBundle;

/**
 * Container class for hook container methods.
 */
class HookContainer extends AbstractHookContainer
{
    /**
     * Define the hook bundles supported by this module.
     *
     * @return void
     */
    protected function setupHookBundles()
    {
        $bundle = new ProviderBundle('PhaidonPiwikModule', 'provider.ui_hooks.piwik.optOut', 'ui_hooks', $this->__('Piwik opt-out hook'));
        $bundle->addServiceHandler('display_view', 'Piwik_HookHandler', 'displayView', 'piwik.optOut');

        $this->registerHookProviderBundle($bundle);
    }
}
