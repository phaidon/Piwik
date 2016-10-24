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

namespace Phaidon\PiwikModule;

use Zikula\Core\AbstractExtensionInstaller;

/**
 * Provides module installation and upgrade services for the Piwik module.
 */
class PiwikInstaller extends AbstractExtensionInstaller
{
    /**
     * Initialise the Piwik module
     * 
     * @return boolean
     */
    public function install()
    {
        // Set default values for module
        $this->setDefaultData();

        // install provider hook
        $this->hookApi->installProviderHooks($this->bundle->getMetaData());

        // initialisation successful
        $this->addFlash('status', $this->__f('You successfully installed the Piwik module. To activate the tracking please setup the module <a href="%s" title="Piwik configuration">here</a>.', ['%s' => $this->container->get('router')->generate('phaidonpiwikmodule_config_config')]));

        return true;
    }

    /**
     * Create the default data for the Piwik module.
     *
     * @return void
     */
    public function setDefaultData()
    {
        $this->setVars([
            'tracking_enable' => false,
            'tracking_piwikpath' => 'yourdomain.com/piwikpath',
            'tracking_siteid' => 0,
            'tracking_token' => 'abcdef123456',
            'tracking_protocol' => 3,
            'tracking_adminpages' => false,
            'tracking_linktracking' => true
        ]);
    }

    /**
     * Upgrade the errors module from an old version
     *
     * This function must consider all the released versions of the module!
     * If the upgrade fails at some point, it returns the last upgraded version.
     *
     * @param string $oldVersion Version number string to upgrade from.
     * 
     * @return mixed True on success, last valid version string or false if fails.
     */
    public function upgrade($oldVersion)
    {
        if (version_compare($oldVersion, '1.1.2', '<')) {
            // install provider hook
            $this->hookApi->installProviderHooks($this->bundle->getMetaData());
        }

        if (version_compare($oldVersion, '1.2.0', '<')) {
            // migration to Zikula 1.4.x
            $this->updateModVarsTo140();
            $this->updateExtensionInfoFor140();
            $this->renamePermissionsFor140();
            \EventUtil::unregisterPersistentModuleHandlers('Piwik');
            $this->updateHookNamesFor140();
        }

        // update successful
        return true;
    }

    /**
     * uninstall the Piwik module
     * 
     * @return boolean
     */
    public function uninstall()
    {
        // uninstall provider hook
        $this->hookApi->uninstallProviderHooks($this->bundle->getMetaData());

        // delete any module variables
        $this->delVars();

        // uninstallation successful
        return true;
    }

    /**
     * Renames the module name for variables in the module_vars table.
     */
    private function updateModVarsTo140()
    {
        $dbName = $this->getDbName();
        $conn = $this->getConnection();

        $conn->executeQuery("UPDATE $dbName.module_vars
                             SET modname = 'PhaidonPiwikModule'
                             WHERE modname = 'Piwik';
        ");
    }

    /**
     * Renames this application in the core's extensions table.
     */
    private function updateExtensionInfoFor140()
    {
        $conn = $this->getConnection();
        $dbName = $this->getDbName();

        $conn->executeQuery("UPDATE $dbName.modules
                                SET name = 'PhaidonPiwikModule',
                                    directory = 'Phaidon/PiwikModule'
                                WHERE name = 'Piwik';
        ");
    }

    /**
     * Renames all permission rules stored for this app.
     */
    private function renamePermissionsFor140()
    {
        $conn = $this->getConnection();
        $dbName = $this->getDbName();

        $componentLength = strlen('Piwik') + 1;

        $conn->executeQuery("UPDATE $dbName.group_perms
                                SET component = CONCAT('PhaidonPiwikModule', SUBSTRING(component, $componentLength))
                                WHERE component LIKE 'Piwik%';
        ");
    }

    /**
     * Updates the module name in the hook tables.
     */
    private function updateHookNamesFor140()
    {
        $conn = $this->getConnection();
        $dbName = $this->getDbName();

        $conn->executeQuery("UPDATE $dbName.hook_area
                             SET owner = 'PhaidonPiwikModule'
                             WHERE owner = 'Piwik';
        ");

        $componentLength = strlen('subscriber.«name.formatForDB»') + 1;
        $conn->executeQuery("UPDATE $dbName.hook_area
                             SET areaname = CONCAT('subscriber.«appName.formatForDB»', SUBSTRING(areaname, $componentLength))
                             WHERE areaname LIKE 'subscriber.«name.formatForDB»%';
        ");

        $conn->executeQuery("UPDATE $dbName.hook_binding
                             SET sowner = 'PhaidonPiwikModule'
                             WHERE sowner = 'Piwik';
        ");

        $conn->executeQuery("UPDATE $dbName.hook_runtime
                             SET sowner = 'PhaidonPiwikModule'
                             WHERE sowner = 'Piwik';
        ");

        $componentLength = strlen('«name.formatForDB»') + 1;
        $conn->executeQuery("UPDATE $dbName.hook_runtime
                             SET eventname = CONCAT('«appName.formatForDB»', SUBSTRING(eventname, $componentLength))
                             WHERE eventname LIKE '«name.formatForDB»%';
        ");

        $conn->executeQuery("UPDATE $dbName.hook_subscriber
                             SET owner = 'PhaidonPiwikModule'
                             WHERE owner = 'Piwik';
        ");

        $componentLength = strlen('«name.formatForDB»') + 1;
        $conn->executeQuery("UPDATE $dbName.hook_subscriber
                             SET eventname = CONCAT('«appName.formatForDB»', SUBSTRING(eventname, $componentLength))
                             WHERE eventname LIKE '«name.formatForDB»%';
        ");
    }

    /**
     * Returns connection to the database.
     *
     * @return Connection the current connection
     */
    private function getConnection()
    {
        $entityManager = $this->container->get('doctrine.entitymanager');
        $connection = $entityManager->getConnection();

        return $connection;
    }

    /**
     * Returns the name of the default system database.
     *
     * @return string the database name
     */
    private function getDbName()
    {
        return $this->container->getParameter('database_name');
    }
}
