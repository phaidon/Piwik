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

class Piwik_Api_Piwik extends Zikula_Api {

    public function request($args)
    {
        // Security check
        if (!SecurityUtil::checkPermission( 'Piwik::', '::', ACCESS_READ)) {
        return LogUtil::registerPermissionError();
        }

        // get vars from input
        $method = $args['method'];
        $format = ($args['format']) ? $args['format'] : 'PHP';
        $params = ($args['params']) ? $args['params'] : array();

        // set defaults for piwik view if not set in $params
        $params['period'] = ($params['period']) ? $params['period'] : 'day';
        $params['date']   = ($params['date'])   ? $params['date']   : 'yesterday';

        // result type formatting
        if (!in_array($format, array('PHP', 'xml'))) {
        $format = 'PHP';
        }

        // get Piwik vars
        $pvars = $this->getVar('piwik');
        $token = $pvars['tracking_token'];

        if (!$token || empty($token)) {
        return LogUtil::registerStatus (__('No token for Piwik found.', $dom));
        }

        $currentType = FormUtil::getPassedValue('type', 'user', 'GETPOST');

    //    $exID = ($currentType == 'admin') ? JuFeBo_getActiveAdminExchange() : JuFeBo_getExchangeId();
    //    $exchange = DBUtil::selectObjectById('jfb_exchange', $exID, 'exchangeid');
    //    $piwikUrl = $exchange['domain'] . '/st_piw/';

        // request construction
        $requestUrl = $pvars['tracking_piwikpath'] . '/index.php?module=API&method=' . $method . '&idSite=' . $pvars['tracking_siteid'] . '&format=' . $format . '&token_auth=' . $token;
        if (count($params)) {
        foreach ($params as $param => $val) {
            if (($method == 'SitesManager.addSite' || $method == 'SitesManager.updateSite') && $param == 'urls') {
            $requestUrl .= '&' . $param . '[0]=' . $val;
            }
            else {
            $requestUrl .= '&' . $param . '=' . $val;
            }
        }
        }

        // getting result via curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_URL, $requestUrl);
        $result = curl_exec($ch);
        curl_close($ch);

        if ($format == 'PHP') {
        $result = unserialize($result);
        return $result[0];
        }

        return $result;
    }

}

