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

class Piwik_Controller_Admin extends Zikula_AbstractController {

    // main function
    public function main()
    {
        return $this->modifyconfig();
    }

    // main function
    public function modifyconfig()
    {
        $form = FormUtil::newForm('Piwik', $this);
        return $form->execute('admin/modifyconfig.tpl', new Piwik_Handler_ModifyConfig());
    }
    
    
    // dashboard function
    public function dashboard()
    {
        $form = FormUtil::newForm('Piwik', $this);
        return $form->execute('admin/dashboard.tpl', new Piwik_Handler_Dashboard());
    }    
    
    

}