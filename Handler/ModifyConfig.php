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
 * This class provides a handler to modify the module settings.
 */
class Piwik_Handler_ModifyConfig  extends Zikula_Form_AbstractHandler
{
    /**
     * This function initialise the form handler.
     * 
     * @param Zikula_Form_View $view Reference to Form render object..
     * 
     * @return boolean
     * 
     * @throws Zikula_Exception_Forbidden If the current user does not have adequate permissions to perform this function.
     */
    function initialize(Zikula_Form_View $view)
    {
        if (!SecurityUtil::checkPermission('Piwik::', '::', ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden(LogUtil::getErrorMsgPermission());
        }

        $sites = ModUtil::apiFunc($this->name, 'admin', 'getSites');
        $view->assign('sites', $sites);

        $view->caching = false;
        $vars = $this->getVars();
        $vars['tracking_piwikpath'] = $vars['tracking_piwikpath'];
        $view->assign($vars);
        
        $protocolOptions = [
            [
                'text' => $this->__('Only http (can produce problems if you are viewing your site via https)'),
                'value' => 1
            ],
            [
                'text' => $this->__('Only https (if you are able to connect via https)'),
                'value' => 2
            ],
            [
                'text' => $this->__('http/https (depending on the protocol which is used to request the site)'),
                'value' => 3
            ]
        );
        $this->view->assign('protocolOptions', $protocolOptions);

        return true;
    }

    /**
     * Handle form submission.
     *
     * @param Zikula_Form_View $view  Reference to Form render object.
     * @param array            &$args Arguments of the command.
     *
     * @return boolean|void
     */
    function handleCommand(Zikula_Form_View $view, &$args)
    {
        if ($args['commandName'] == 'cancel') {
            $url = ModUtil::url($this->name, 'admin', 'modifyconfig' );

            return $view->redirect($url);
        }

        // check for valid form
        if (!$view->isValid()) {
            return false;
        }

        $data = $view->getValues();

        $data['tracking_piwikpath'] = filter_var($data['tracking_piwikpath'], FILTER_SANITIZE_URL);
        $data['tracking_piwikpath'] = str_replace('https://', '', $data['tracking_piwikpath']);
        $data['tracking_piwikpath'] = str_replace('http://', '',  $data['tracking_piwikpath']); 

        $this->setVars($data);

        $url = ModUtil::url($this->name, 'admin', 'modifyconfig');

        return $this->view->redirect($url);
    }
}
