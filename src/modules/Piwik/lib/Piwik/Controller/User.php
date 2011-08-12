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


class Piwik_Controller_User extends Zikula_AbstractController
{


    //  extendended view
    public function stats($args)
    {

        // Security check
        if (!SecurityUtil::checkPermission('Piwik::', '::', ACCESS_READ)) {
        return;
        }

        // get module vars
        $this->view->assign($this->getVar('piwik'));

        return $this->view->fetch('user/stats.tpl');

    }

}

