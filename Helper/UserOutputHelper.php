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
use Zikula\ExtensionsModule\Api\VariableApi;

/**
 * User output helper class.
 */
class UserOutputHelper
{
    /**
     * @var VariableApi
     */
    private $variableApi;

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
     * @param VariableApi      $variableApi     VariableApi service instance
     * @param PiwikDataHelper  $piwikDataHelper PiwikDataHelper service instance
     * @param Twig_Environment $twig            Twig_Environment service instance
     */
    public function __construct(VariableApi $variableApi, PiwikDataHelper $piwikDataHelper, Twig_Environment $twig) {
        $this->variableApi = $variableApi;
        $this->piwikDataHelper = $piwikDataHelper;
        $this->twig = $twig;
    }

    /**
     * Adds the Piwik tracking code to the site's output.
     * 
     * @return boolean
     */
    public function tracker()
    {
        // no security check because code should be loaded in every page!

        // check if we are in admin pages
        // NOTE not sure yet how to determine admin pages in core 2.0
        $isAdminPage = \FormUtil::getPassedValue('type', null, 'GET') == 'admin';
        //$isAdminPage = $this->request->query->get('type', null) == 'admin';

        $modVars = $this->variableApi->getAll('PhaidonPiwikModule');

        // only add piwik code to source if tracking is enabled
        if (!$modVars['tracking_enable']) {
            return true;
        }

        // return if admin pages should not be tracked
        if ($isAdminPage && !$modVars['tracking_adminpages']) {
            return true;
        }

        $siteId = $modVars['tracking_siteid'];
        if (empty($siteId)) {
            return true;
        }

        $templateParameters = [
            'piwikUrl' => $this->piwikDataHelper->getBaseUrl(),
            'siteId' => $siteId,
            'enableLinkTracking' => $modVars['tracking_linktracking']
        ];
        $trackerCode = $this->twig->render('@PhaidonPiwikModule/UserApi/tracker.html.twig', $templateParameters);

        // add the scripts to page footer
        \PageUtil::addVar('footer', $trackerCode);

        return true;
    }

    /**
     * Opt out function
     * 
     * This function activates the opt out function needed for deactivating tracking by piwik.
     * 
     * @param string $width Width with unit (% or px)
     * @param string $height Height with unit (% or px)
     * 
     * @return string
     */
    public function optOut($width = '100%', $height = '200px')
    {
        $templateParameters = [
            'piwikUrl' => $this->piwikDataHelper->getBaseUrl(),
            'width' => $width,
            'height' => $height
        ];

        return $this->twig->render('@PhaidonPiwikModule/UserApi/optOut.html.twig', $templateParameters);
    }
}
