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
 * Dashboard api class.
 */
class Piwik_Api_Dashboard extends Zikula_AbstractApi
{

    /**
     * Instance of Zikula_View.
     *
     * @var Zikula_View
     */
    protected $view;

    /**
     * Initialize.
     *
     * @return void
     */
    protected function initialize()
    {
        $this->setView();
    }

    /**
     * Set view property.
     *
     * @param Zikula_View $view Default null means new Render instance for this module name.
     *
     * @return Zikula_AbstractController
     */
    protected function setView(Zikula_View $view = null)
    {
        if (is_null($view)) {
            $view = Zikula_View::getInstance($this->getName());
        }

        $this->view = $view;
        return $this;
    }
    
    /**
     * Tracker
     * 
     * This function activates tracker in site source.
     * 
     * @param array $args Tracker arguments.
     * 
     * @return boolean
     */
    public function data($params)
    {
        if (!isset($params['method'])) {
            return LogUtil::registerArgsError();
        }
        if (!isset($params['period'])) {
            $params['period'] = '';
        }
        if (!isset($params['date'])) {
            $params['date'] = '';
        }
        
        $intLimit  = -1;
        $strURL    = 'http://'.$this->getVar('tracking_piwikpath');
        $intSite   = $this->getVar('tracking_siteid');		
        $strURL   .= '/index.php?module=API&method='.$params['method'];
        $strURL   .= '&idSite='.$intSite.'&period='.$params['period'].'&date='.$params['date'];
        $strURL   .= '&format=PHP&filter_limit='.$intLimit;
        $strURL   .= '&token_auth='.$this->getVar('tracking_token');
        $strResult = $this->get_remote_file($strURL);			
        return unserialize($strResult);
    }
    
    
    function call_API($strMethod, $strPeriod='', $strDate='', $intLimit='',$bolExpanded=false) {
		$strKey = $strMethod.'_'.$strPeriod.'_'.$strDate.'_'.$intLimit;
		if (empty($this->aryCache[$strKey])) {
			$strToken = self::$aryGlobalSettings['piwik_token'];
			$strURL = self::$aryGlobalSettings['piwik_url'];
			$intSite = self::$arySettings['site_id'];
			if (self::$bolWPMU && empty($intSite)) {
				$aryReturn = $this->create_wpmu_site();
				$intSite = $aryReturn['id'];
			}
			if (self::$bolOverall) $intSite = 'all';
			if (empty($strToken) || empty($strURL)) {
				$this->aryCache[$key] = array(
					'result' => 'error',
					'message' => 'Piwik base URL or auth token not set.'
				);
				return $this->aryCache[$strKey];
			}			
			$strURL .= '?module=API&method='.$strMethod;
			$strURL .= '&idSite='.$intSite.'&period='.$strPeriod.'&date='.$strDate;
			$strURL .= '&format=PHP&filter_limit='.$intLimit;
			$strURL .= '&token_auth='.$strToken;
			$strURL .= '&expanded='.$bolExpanded;
			$strResult = $this->get_remote_file($strURL);			
			$this->aryCache[$strKey] = unserialize($strResult);
		}
		return $this->aryCache[$strKey];	
	}
    
    
    public function get_remote_file($strURL) {
        
		// Use cURL if available	
		if (function_exists('curl_init')) {
			// Init cURL
			$c = curl_init($strURL);
			// Configure cURL CURLOPT_RETURNTRANSFER = 1
			curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
			// Configure cURL CURLOPT_HEADER = 0 
			curl_setopt($c, CURLOPT_HEADER, 0);
			// Get result
			$strResult = curl_exec($c);
			// Close connection			
			curl_close($c);
		// cURL not available but url fopen allowed
		} elseif (ini_get('allow_url_fopen')) {
			// Get file using file_get_contents
			$strResult = file_get_contents($strURL);
		// Error: Not possible to get remote file
        } else {
            $strResult = serialize(array(
				'result' => 'error',
				'message' => 'Remote access to Piwik not possible. Enable allow_url_fopen or CURL.'
			));
        }
		// Return result
		return $strResult;
	}
    
    
    public function showOverview($args = array()) {
        
        if (!isset($args['period'])) {
            $args['period'] = 'week';
        }
        if (!isset($args['date'])) {
            $args['date'] = 'today';
        }
        

        $params = array(
            'method' => 'VisitsSummary.get',
            'period' => $args['period'],
            'date'   => $args['date']
        );
        $data = ModUtil::apiFunc($this->name, 'dashboard', 'data', $params);
        $data['total_time'] = 
            floor( $data['sum_visit_length'] / 3600).'h '.
            floor(($data['sum_visit_length'] % 3600)/60).'m '.
            floor(($data['sum_visit_length'] % 3600) % 60).'s';
        $data['average_time'] = 
            floor( $data['avg_time_on_site'] / 3600).'h '.
            floor(($data['avg_time_on_site'] % 3600)/60).'m '.
            floor(($data['avg_time_on_site'] % 3600) % 60).'s';
        return $this->view->assign('data', $data)
                          ->fetch('dashboard/overview.tpl');
    }
    
    
    public function showPages($args = array()) {
        
        if (!isset($args['period'])) {
            $args['period'] = 'week';
        }
        if (!isset($args['date'])) {
            $args['date'] = 'today';
        }
        
        $params = array(
            'method' => 'Actions.getPageTitles',
            'period' => $args['period'],
            'date'   => $args['date']
        );
        $data = $this->data($params);
        
        
        return $this->view->assign('data', $data)
                          ->assign('intMax', 9)
                          ->fetch('dashboard/pages.tpl');
    }
    
}
