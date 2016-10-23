<?php
/**
 * Copyright Piwik Team 2011
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @link https://github.com/phaidon/Piwik
 */

/**
 * Access to (administrative) user-initiated actions for the Wikula module.
 */
class Piwik_Controller_Admin extends Zikula_AbstractController {

    /**
     * main
     *
     * This function is a redirect to modifyconfig
     * 
     * @return string
     */
    public function main()
    {
        return $this->modifyconfig();
    }

    /**
     * Modify config
     *
     * This function allows to modify the settings of the module
     * 
     * @return Zikula_Form_AbstractHandler
     */
    public function modifyconfig()
    {
        $form = FormUtil::newForm('Piwik', $this);

        return $form->execute('admin/modifyconfig.tpl', new Piwik_Handler_ModifyConfig());
    }

    /**
     * Piwik dashboad
     *
     * This function shows the Piwik dashboard
     * 
     * @return Zikula_Form_AbstractHandler
     */
    public function dashboard()
    {
        $form = FormUtil::newForm('Piwik', $this);

        return $form->execute('admin/dashboard.tpl', new Piwik_Handler_Dashboard());
    }

    /**
     * Piwik dashboad
     *
     * This function shows the Piwik dashboard
     * 
     * @return Zikula_Form_AbstractHandler
     */
    public function dashboard2()
    {
        $form = FormUtil::newForm('Piwik', $this);

        return $form->execute('admin/dashboard2.tpl', new Piwik_Handler_Dashboard());
    }

    /**
     * troubleshooting
     *
     * This function give hints for the troubleshooting
     * 
     * @return Zikula_Form_AbstractHandler
     *
     * @throws Zikula_Exception_Forbidden If the current user does not have adequate permissions to perform this function.
     */
    public function troubleshooting()
    {
        if (!SecurityUtil::checkPermission('Piwik::', '::', ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden(LogUtil::getErrorMsgPermission());
        }

        return $this->view->fetch('admin/troubleshooting.tpl');
    } 
}
