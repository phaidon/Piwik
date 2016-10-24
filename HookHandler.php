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

/**
 * Piwik Hooks Handlers.
 */
class Piwik_HookHandler extends Zikula_Hook_AbstractHandler
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
        $view = Zikula_View::getInstance('Piwik', false, null, true);

        $view->assign('piwikUrl', ModUtil::apiFunc('PhaidonPiwikModule', 'user', 'getBaseUrl'))
             ->assign('width', '100%')
             ->assign('height', '160px');

        $response = new Zikula_Response_DisplayHook('provider_area.ui_hooks.piwik.optOut', $view, 'userapi/optOut.tpl');
        $hook->setResponse($response);
    }
}
