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
     * @param array $params Tracker arguments.
     *
     * @return boolean|string
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
        if (!isset($params['limit'])) {
            $params['limit'] = -1;
        }

        $siteId = $this->getVar('tracking_siteid');

        $strURL = ModUtil::apiFunc($this->name, 'user', 'getBaseUrl');
        $strURL .= 'index.php?module=API&method='.$params['method'];
        $strURL .= '&idSite=' . $siteId . '&period='.$params['period'].'&date='.$params['date'];
        $strURL .= '&format=json&filter_limit='.$params['limit'];
        $strURL .= '&token_auth='.$this->getVar('tracking_token');
        $strResult = $this->get_remote_file($strURL);

        return json_decode($strResult, true);
    }

    /**
     * Get remote file
     *
     * This function get remote file.
     *
     * @param string $strURL Url.
     *
     * @return string
     */
    public function get_remote_file($strURL)
    {
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
            if (false === $strResult) {
                return LogUtil::registerError($this->__('Could connect to piwik. Probably the url is wrong?'));
            }
            // cURL not available but url fopen allowed
        } elseif (ini_get('allow_url_fopen')) {
            // Get file using file_get_contents
            $strResult = @file_get_contents($strURL);
            // Error: Not possible to get remote file
        } else {
            $strResult = json_encode([
                'result' => 'error',
                'message' => 'Remote access to Piwik not possible. Enable allow_url_fopen or CURL.'
            ]);
        }

        // Return result
        return $strResult;
    }

    /**
     * Show overview
     *
     * This function shows an overview.
     *
     * @param array $args Arguments.
     *
     * @return string
     */
    public function showOverview($args = [])
    {
        $args = $this->setDefaults($args);

        $params = [
            'method' => 'VisitsSummary.get',
            'period' => $args['period'],
            'date'   => $args['date']
        ];
        $data = ModUtil::apiFunc($this->name, 'dashboard', 'data', $params);

        if (!is_array($data)) {
            return false;
            // Dont produce the messages
            // return LogUtil::registerError($this->__('Could not connect to Piwik. Please check your settings.'));
        }

        $data['total_time'] = 
            floor( $data['sum_visit_length'] / 3600).'h '.
            floor(($data['sum_visit_length'] % 3600)/60).'m '.
            floor(($data['sum_visit_length'] % 3600) % 60).'s';
        $data['average_time'] = 
            floor( $data['avg_time_on_site'] / 3600).'h '.
            floor(($data['avg_time_on_site'] % 3600)/60).'m '.
            floor(($data['avg_time_on_site'] % 3600) % 60).'s';

        return $this->view
            ->assign('data', $data)
            ->assign($args)
            ->fetch('dashboard/overview.tpl');
    }

    /**
     * Show pages
     *
     * This function shows the pages.
     *
     * @param array $args Arguments.
     *
     * @return string
     */
    public function showPages($args = [])
    {
        if (!isset($args['period'])) {
            $args['period'] = 'days';
        }
        if (!isset($args['date'])) {
            $args['date'] = 'today';
        }

        $params = [
            'method' => 'Actions.getPageTitles',
            'period' => $args['period'],
            'date'   => $args['date']
        ];
        $data = $this->data($params);

        if (!is_array($data)) {
            return LogUtil::registerError($this->__('Could not connect to Piwik. Please check your settings.'));
        }

        return $this->view
            ->assign('data', $data)
            ->assign('intMax', 9)
            ->assign($args)
            ->fetch('dashboard/pages.tpl');
    }

    /**
     * Show Visitors
     *
     * This function shows the visitors.
     *
     * @param array $args Arguments.
     *
     * @return string
     */
    public function showVisitors($args = [])
    {
        $args = $this->setDefaults($args);

        switch ($args['period']) {
            case 'day':
                $args['date'] = 'last30';
                break;
            case 'week':
                $args['date'] = 'last12';
                break;
            case 'month':
                $args['date'] = 'last12';
                break;
            case 'year':
                $args['date'] = 'last5';
                break;
        }

        $data = [];

        $data['Visitors'] = $this->data([
            'method' => 'VisitsSummary.getVisits', 
            'period' => $args['period'], 
            'date'   => $args['date'],
            'limit'  => $args['limit']
        ]);

        if (!is_array($data['Visitors'])) {
            return LogUtil::registerError($this->__('Could not connect to Piwik. Please check your settings.'));
        }

        $data['Unique'] = $this->data([
            'method' => 'VisitsSummary.getUniqueVisitors',
            'period' => $args['period'],
            'date'   => $args['date'],
            'limit'  => $args['limit']
        ]);
        $data['Bounced'] = $this->data([
            'method' => 'VisitsSummary.getBounceCount',
            'period' => $args['period'],
            'date'   => $args['date'],
            'limit'  => $args['limit']
        ]);

        $strValues = $strLabels = $strBounced =  $strValuesU = '';
        $intUSum = $intCount = 0; 
        if (is_array($data['Visitors'])) {
            foreach ($data['Visitors'] as $strDate => $intValue) {
                $intCount++;
                $strValues .= $intValue . ',';
                $strValuesU .= $data['Unique'][$strDate] . ',';
                $strBounced .= $data['Bounced'][$strDate] . ',';
                $label = '';
                switch ($args['period']) {
                    case 'day':
                        $label = substr($strDate, -2);
                        break;
                    case 'week':
                        $date = new DateTime(substr($strDate, 5, 10));
                        $label = $date->format('W/y');
                        break;
                    case 'month':
                        $label = substr($strDate, -2) . '/' . substr($strDate, 2, 2);
                        break;
                    case 'year':
                        $label = $strDate;
                        break;
                }
                $strLabels .= '[' . $intCount . ',"' . $label . '"],';
                $intUSum += $data['Unique'][$strDate];
            }
        } else {
            $strValues = '0,';
            $strLabels = '[0,"-"],';
            $strValuesU = '0,';
            $strBounced = '0,';    
        }
        $intAvg = round($intUSum / 30, 0);
        $strValues = substr($strValues, 0, -1);
        $strValuesU = substr($strValuesU, 0, -1);
        $strLabels = substr($strLabels, 0, -1);
        $strBounced = substr($strBounced, 0, -1);

        $data['Visitors'] = array_reverse($data['Visitors']);

        return $this->view
            ->assign('intUSum', $intUSum)
            ->assign('intAvg', $intAvg)
            ->assign('strValues', $strValues)
            ->assign('strValuesU', $strValuesU)
            ->assign('strLabels', $strLabels)
            ->assign('strBounced', $strBounced)
            ->assign($data)
            ->assign($args)
            ->fetch('dashboard/visitors.tpl');
    }

    /**
     * Set defaults
     *
     * This function set the defaults.
     *
     * @param array $args Arguments.
     *
     * @return array
     */
    private function setDefaults($args = [])
    {
        if (empty($args['period'])) {
            $args['period'] = 'days';
        }
        if (empty($args['date'])) {
            $args['date'] = 'today';
        }
        if (empty($args['limit'])) {
            $args['limit'] = -1;
        }

        return $args;
    }
}
