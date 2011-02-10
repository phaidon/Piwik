<?php

/**
 * Copyright Piwik Team 2011
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @package Piwik
 * @link http://code.zikula.org/piwik
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

class Piwik_Handler_ModifyConfig  extends Form_Handler
{

    function initialize(Form_View $view)
    {
        $this->view->caching = false;
        $this->view->assign(ModUtil::getVar('piwik'));

        return true;
    }


    function handleCommand(Form_View $view, &$args)
    {
        // check for valid form
        if (!$view->isValid()) {
            return false;
        }
        
        $data = $view->getValues();


        $this->setVar('tracking_enable',       $data['tracking_enable']);
        $this->setVar('tracking_piwikpath',    $data['tracking_piwikpath']);
        $this->setVar('tracking_siteid',       $data['tracking_siteid']);
        $this->setVar('tracking_token',        $data['tracking_token']);
        $this->setVar('tracking_adminpages',   $data['tracking_adminpages']);
        $this->setVar('tracking_linktracking', $data['tracking_linktracking']);
        return true;

        // check piwikpath for starting with 'http'
        //if (substr($tracking_piwikpath, 0, 4) != 'http') {
        //return LogUtil::registerError ($this->__('Piwik-URL starts not with http or https!'));


    }

}
