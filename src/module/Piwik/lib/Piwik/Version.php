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

class Piwik_Version extends Zikula_Version
{
    public function getMetaData()
    {
        $meta = array();
        $meta['description']    = __('Piwik statistics module');
        $meta['displayname']    = __('Piwik statistics');
        //!url must be different to displayname
        $meta['url']            = __('Piwik');
        $meta['version']        = '0.5.0';
        $meta['author']         = '';
        $meta['contact']        = 'http://code.zikula.org/piwik/';
        // recommended and required modules
        $meta['dependencies']   = array();
        $meta['securityschema'] = array('Piwik::' => '::');
        return $meta;
    }
}
