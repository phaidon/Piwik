<?php
/**
 * Copyright Piwik Team 2016
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @link https://github.com/phaidon/Piwik
 */

namespace Phaidon\PiwikModule\Helper;

use Phaidon\PiwikModule\Helper\PiwikDataHelper;
use Twig_Environment;

/**
 * Dashboard helper class.
 */
class DashboardHelper
{
    /**
     * @var PiwikDataHelper
     */
    private $piwikDataHelper;

    /**
     * @var Twig_Environment
     */
    protected $view;

    /**
     * Constructor.
     *
     * @param PiwikDataHelper  $piwikDataHelper PiwikDataHelper service instance
     * @param Twig_Environment $twig            Twig_Environment service instance
     */
    public function __construct(PiwikDataHelper $piwikDataHelper, Twig_Environment $twig)
    {
        $this->piwikDataHelper = $piwikDataHelper;
        $this->twig = $twig;
    }

    /**
     * Show overview
     *
     * This function shows an overview.
     *
     * @param string $period The chosen period (day, week, month, year)
     * @param string $date   Optional date filter
     * @param int    $limit  Optional limit for amount of returned data rows
     *
     * @return string
     */
    public function showOverview($period = 'days', $date = 'today', $limit = -1)
    {
        $data = $this->piwikDataHelper->getData('VisitsSummary.get', $period, $date);
        if (!is_array($data)) {
            return false;
        }

        $data['total_time'] = 
            floor( $data['sum_visit_length'] / 3600) . 'h ' .
            floor(($data['sum_visit_length'] % 3600) / 60) . 'm ' .
            floor(($data['sum_visit_length'] % 3600) % 60) . 's';
        $data['average_time'] = 
            floor( $data['avg_time_on_site'] / 3600) . 'h ' .
            floor(($data['avg_time_on_site'] % 3600) / 60) . 'm ' .
            floor(($data['avg_time_on_site'] % 3600) % 60) . 's';

        $templateParameters = [
            'data' => $data,
            'period' => $period,
            'date' => $date,
            'limit' => $limit
        ];

        return $this->twig->render('@PhaidonPiwikModule/Dashboard/overview.html.twig', $templateParameters);
    }

    /**
     * Show pages
     *
     * This function shows the pages.
     *
     * @param string $period The chosen period (day, week, month, year)
     * @param string $date   Optional date filter
     *
     * @return string
     */
    public function showPages($period = 'days', $date = 'today')
    {
        $data = $this->piwikDataHelper->getData('Actions.getPageTitles', $period, $date);
        if (!is_array($data)) {
            return false;
        }

        $templateParameters = [
            'data' => $data,
            'period' => $period,
            'date' => $date,
            'maxAmountOfShownPages' => 9
        ];

        return $this->twig->render('@PhaidonPiwikModule/Dashboard/pages.html.twig', $templateParameters);
    }

    /**
     * Show Visitors
     *
     * This function shows the visitors.
     *
     * @param string $period The chosen period (day, week, month, year)
     * @param string $date   Optional date filter
     * @param int    $limit  Optional limit for amount of returned data rows
     *
     * @return string
     */
    public function showVisitors($period = 'days', $date = 'today', $limit = -1)
    {
        switch ($period) {
            case 'day':
                $date = 'last30';
                break;
            case 'week':
                $date = 'last12';
                break;
            case 'month':
                $date = 'last12';
                break;
            case 'year':
                $date = 'last5';
                break;
        }

        $data = [];

        $data['visitors'] = $this->piwikDataHelper->getData('VisitsSummary.getVisits', $period, $date, $limit);
        if (!is_array($data['visitors'])) {
            return false;
        }

        $data['unique'] = $this->piwikDataHelper->getData('VisitsSummary.getUniqueVisitors', $period, $date, $limit);
        $data['bounced'] = $this->piwikDataHelper->getData('VisitsSummary.getBounceCount', $period, $date, $limit);

        $strValues = $strLabels = $strBounced =  $strValuesU = '';
        $intUSum = $intCount = 0; 

        foreach ($data['visitors'] as $strDate => $intValue) {
            $intCount++;
            $strValues .= $intValue . ',';
            $strValuesU .= $data['unique'][$strDate] . ',';
            $strBounced .= $data['bounced'][$strDate] . ',';
            $label = '';
            switch ($period) {
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

        $intAvg = round($intUSum / 30, 0);
        $strValues = substr($strValues, 0, -1);
        $strValuesU = substr($strValuesU, 0, -1);
        $strLabels = substr($strLabels, 0, -1);
        $strBounced = substr($strBounced, 0, -1);

        $data['visitors'] = array_reverse($data['visitors']);

        $templateParameters = [
            'data' => $data,
            'period' => $period,
            'date' => $date,
            'limit' => $limit,
            'intUSum' => $intUSum,
            'intAvg' => $intAvg,
            'strValues' => $strValues,
            'strValuesU' => $strValuesU,
            'strLabels' => $strLabels,
            'strBounced' => $strBounced
        ];

        return $this->twig->render('@PhaidonPiwikModule/Dashboard/visitors.html.twig', $templateParameters);
    }
}
