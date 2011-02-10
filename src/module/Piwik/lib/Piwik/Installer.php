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

class Piwik_Installer extends Zikula_Installer
{
    /**
    * initialise the template module
    * This function is only ever called once during the lifetime of a particular
    * module instance
    */


    public function install()
    {
        // Set module defaults
        $this->setVar('tracking_enable'       , 0);
        $this->setVar('tracking_piwikpath'    , 'domain.com/piwik');
        $this->setVar('tracking_siteid'       , '0');
        $this->setVar('tracking_token'        , 'abcdef123456');
        $this->setVar('tracking_adminpages'   , 0);
        $this->setVar('tracking_linktracking' , 1);

        // create systeminit hook
        if (!ModUtil::registerHook('zikula', 'systeminit', 'API', 'piwik', 'user', 'tracker')) {
            return LogUtil::registerError(__('Error creating Hook!'));
        }
        ModUtil::apiFunc('Modules', 'admin', 'enablehooks', array('callermodname' => 'zikula', 'hookmodname' => 'piwik'));

        // Initialisation successful
        return true;
    }

    /**
    * Upgrade the errors module from an old version
    *
    * This function must consider all the released versions of the module!
    * If the upgrade fails at some point, it returns the last upgraded version.
    *
    * @param        string   $oldVersion   version number string to upgrade from
    * @return       mixed    true on success, last valid version string or false if fails
    */
    public function upgrade($oldversion)
    {
        // Update successful
        return true;
    }

    /**
    * delete the errors module
    * This function is only ever called once during the lifetime of a particular
    * module instance
    */
    public function uninstall()
    {
        // Delete any module variables
        $this->delVars();
        // Deletion successful

        // delete the system init hook
        if (!ModUtil::unregisterHook('zikula', 'systeminit', 'API', 'piwik', 'user', 'tracker')) {
              return LogUtil::registerError($this->__('Error deleting Hook!'));
        }

        return true;

    }
}
