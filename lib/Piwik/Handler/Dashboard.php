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
 * This class provides a handler to see the piwik dashboard.
 */
class Piwik_Handler_Dashboard extends Zikula_Form_AbstractHandler
{

    /**
     * Initialise the form handler
     * 
     * @param Zikula_Form_View $view Reference to Form render object.
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
        
        
        $view->caching = false;
        $view->assign('from',   'today');
        $view->assign('to',     'today');
        $view->assign('period', 'day');
        $view->assign('date',   date('Y-m-d'));
 
        $periods = array(
            array('value' =>  'day',   'text' => $this->__('Day')),
            array('value' =>  'week',  'text' => $this->__('Week')),
            array('value' =>  'month', 'text' => $this->__('Month')),
            array('value' =>  'year',  'text' => $this->__('Year')),
            //array('value' =>  'range', 'text' => $this->__('Date range')),
        );
        $view->assign('periods', $periods);

        // formadateinput workaround for Zikula < 1.3.4 and lang != en
        $useFormDateInput = true;
        if (ZLanguage::getLocale() != 'en') {
            $coreVersion = preg_replace('#(\d+\.\d+\.\d+).*#', '$1', Zikula_Core::VERSION_NUM);
            $minok = version_compare($coreVersion, '1.3.4');
            if ($minok < 0) {
                $useFormDateInput = false;
            }
        }
        $view->assign('useFormDateInput', $useFormDateInput);

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
        unset($args);
        
        // check for valid form
        if (!$view->isValid()) {
            return false;
        }
        
        $data = $view->getValues();       
        $this->view->assign($data);
        return true;
    }

}
