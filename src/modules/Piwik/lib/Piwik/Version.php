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
 * Provides metadata for this module to the Extensions module.
 */
class Piwik_Version extends Zikula_AbstractVersion
{
    /**
     * Meta data
     *
     * This function returns the meta data of the module.
     * 
     * @return array
     */
    public function getMetaData()
    {
        $meta = array();
        $meta['description']    = $this->__('Piwik statistics module');
        $meta['displayname']    = $this->__('Piwik statistics');
        //!url must be different to displayname
        $meta['url']            = $this->__('Piwik');
        $meta['version']        = '1.0.0';
        $meta['author']         = '';
        $meta['contact']        = 'https://github.com/phaidon/Piwik';
        $meta['dependencies']   = array();
        $meta['securityschema'] = array('Piwik::' => '::');
        return $meta;
    }
}
