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

class Piwik_Handler_ModifyConfig  extends Zikula_Form_AbstractHandler
{

    function initialize(Zikula_Form_View $view)
    {
         if (!SecurityUtil::checkPermission('Piwik::', '::', ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden(LogUtil::getErrorMsgPermission());
        }
        
        $this->view->caching = false;
        $this->view->assign($this->getVars());

        return true;
    }


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


        $this->setVars($data);
        return true;

        // check piwikpath for starting with 'http'
        //if (substr($tracking_piwikpath, 0, 4) != 'http') {
        //return LogUtil::registerError ($this->__('Piwik-URL starts not with http or https!'));


    }

}
