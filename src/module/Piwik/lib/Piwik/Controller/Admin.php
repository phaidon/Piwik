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

class Piwik_Controller_Admin extends Zikula_AbstracController {

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
}