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

use Symfony\Component\HttpFoundation\Response;
use Zikula\Bundle\HookBundle\Hook\AbstractHookListener;
use Zikula\Bundle\HookBundle\Hook\DisplayHook;
use Zikula\Bundle\HookBundle\Hook\DisplayHookResponse;

/**
 * Piwik hooks handlers.
 */
class Piwik_HookHandler extends AbstractHookListener
{
    /**
     * Display hook for view.
     *
     * @param DisplayHook $hook The hook.
     *
     * @return void
     */
    public function displayView(DisplayHook $hook)
    {
        $twig = \ServiceUtil::get('twig');
        $dataHelper = \ServiceUtil::get('phaidon_piwik_module.helper.piwik_data_helper');

        $templateParameters = [
            'piwikUrl' => $dataHelper->getBaseUrl(),
            'width' => '100%',
            'height' => '160px'
        ];

        $response = new Response($twig->render('@PhaidonPiwikModule/UserApi/optOut.html.twig', $templateParameters));

        $hookResponse = new DisplayHookResponse('provider_area.ui_hooks.piwik.optOut', $response);
        $hook->setResponse($hookResponse);
    }
}
