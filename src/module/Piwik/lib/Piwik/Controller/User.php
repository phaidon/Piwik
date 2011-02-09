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


class piwik_Controller_User extends Zikula_Controller
{

    //  main user view
    public function main($args)
    {

        // Security check
        if (!SecurityUtil::checkPermission('Piwik::', '::', ACCESS_READ)) {
        return;
        }

        $selectionPeriod     = FormUtil::getPassedValue('selectionPeriod', null, 'POST');
        if(empty($selectionPeriod)) $selectionPeriod = 100;
        $startDate     = FormUtil::getPassedValue('startDate', null, 'POST');
        //if(empty($startDate)) $startDate =  date("j.n.Y");


        // get module vars
        $this->view->assign($this->getVar('piwik'));
        $this->view->assign('selectionPeriod', $selectionPeriod);
        $this->view->assign('startDate', $startDate);
        return $this->view->fetch('piwik_user_dashboard.tpl');

    }

    //  extendended view
    public function stats($args)
    {

        // Security check
        if (!SecurityUtil::checkPermission('Piwik::', '::', ACCESS_READ)) {
        return;
        }

        // get module vars
        $this->view->assign($this->getVar('piwik'));

        return $this->view->fetch('piwik_user_stats.tpl');

    }

}

