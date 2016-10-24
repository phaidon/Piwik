<?php
/**
 * Copyright Piwik Team 2013
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @link    https://github.com/phaidon/Piwik
 */

namespace Phaidon\PiwikModule;

use Zikula\Bundle\HookBundle\Hook\AbstractHookListener;

// TODO refactor this class

/**
 * Piwik Hooks Handlers.
 */
class Piwik_HookHandler extends AbstractHookListener
{
    /**
     * Display hook for view.
     *
     * Subject is the object being viewed that we're attaching to.
     * args[id] Is the id of the object.
     * args[caller] the module who notified of this event.
     *
     * @param Zikula_DisplayHook $hook The hook.
     *
     * @return void
     */
    public function displayView(Zikula_DisplayHook $hook)
    {
        $twig = \ServiceUtil::get('twig');
        $dataHelper = \ServiceUtil::get('phaidon_piwik_module.helper.piwik_data_helper');

        $templateParameters = [
            'piwikUrl' => $dataHelper->getBaseUrl(),
            'width' => '100%',
            'height' => '160px'
        ];

        $response = new Zikula_Response_DisplayHook('provider_area.ui_hooks.piwik.optOut', $view, 'UserApi/optOut.html.twig');
        $hook->setResponse($response);
    }
}
