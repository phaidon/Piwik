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

        $dataHelper = \ServiceUtil::get('phaidon_piwik_module.helper.piwik_data_helper');
        $data = $dataHelper->getData('VisitsSummary.get', $args['period'], $args['date']);

        if (!is_array($data)) {
            return false;
            // Dont produce the messages
            // return LogUtil::registerError($this->__('Could not connect to Piwik. Please check your settings.'));
        }

        $data['total_time'] = 
            floor( $data['sum_visit_length'] / 3600).'h ' .
            floor(($data['sum_visit_length'] % 3600) / 60).'m ' .
            floor(($data['sum_visit_length'] % 3600) % 60).'s';
        $data['average_time'] = 
            floor( $data['avg_time_on_site'] / 3600).'h ' .
            floor(($data['avg_time_on_site'] % 3600) / 60).'m ' .
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

        $dataHelper = \ServiceUtil::get('phaidon_piwik_module.helper.piwik_data_helper');
        $data = $dataHelper->getData('Actions.getPageTitles', $args['period'], $args['date']);

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

        $dataHelper = \ServiceUtil::get('phaidon_piwik_module.helper.piwik_data_helper');

        $data = [];

        $data['visitors'] = $dataHelper->getData('VisitsSummary.getVisits', $args['period'], $args['date'], $args['limit']);

        if (!is_array($data['visitors'])) {
            return LogUtil::registerError($this->__('Could not connect to Piwik. Please check your settings.'));
        }

        $data['unique'] = $dataHelper->getData('VisitsSummary.getUniqueVisitors', $args['period'], $args['date'], $args['limit']);
        $data['bounced'] = $dataHelper->getData('VisitsSummary.getBounceCount', $args['period'], $args['date'], $args['limit']);

        $strValues = $strLabels = $strBounced =  $strValuesU = '';
        $intUSum = $intCount = 0; 
        if (is_array($data['visitors'])) {
            foreach ($data['visitors'] as $strDate => $intValue) {
                $intCount++;
                $strValues .= $intValue . ',';
                $strValuesU .= $data['unique'][$strDate] . ',';
                $strBounced .= $data['bounced'][$strDate] . ',';
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
                $intUSum += $data['unique'][$strDate];
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

        $data['visitors'] = array_reverse($data['visitors']);

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
