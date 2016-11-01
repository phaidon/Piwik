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

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\ExtensionsModule\Api\VariableApi;

/**
 * Helper class for fetching data from a Piwik instance.
 */
class PiwikDataHelper
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var VariableApi
     */
    private $variableApi;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * Constructor.
     *
     * @param TranslatorInterface $translator   TranslatorInterface service instance
     * @param VariableApi         $variableApi  VariableApi service instance
     * @param SessionInterface    $session      SessionInterface service instance
     * @param RequestStack        $requestStack RequestStack service instance
     */
    public function __construct(TranslatorInterface $translator, VariableApi $variableApi, SessionInterface $session, RequestStack $requestStack) {
        $this->translator = $translator;
        $this->variableApi = $variableApi;
        $this->session = $session;
        $this->requestStack = $requestStack;
    }

    /**
     * Gets base url of the Piwik system.
     * 
     * @return string
     */
    public function getBaseUrl()
    {
        $protocol = $this->variableApi->get('PhaidonPiwikModule', 'tracking_protocol', 3);
        $piwikPath = $this->variableApi->get('PhaidonPiwikModule', 'tracking_piwikpath');

        $httpPath = 'http://' . $piwikPath . '/';
        $httpsPath = 'https://' . $piwikPath . '/';

        switch ($protocol) {
            case 1: //only http
                return $httpPath;
                break;
            case 2: //only https
                return $httpsPath;
                break;
            case 3: //http/https
                $request = $this->requestStack->getCurrentRequest();
                return null !== $request && $request->getScheme() == 'https' ? $httpsPath : $httpPath;
                break;
        }

        return $httpPath;
    }

    /**
     * Get list of sites from a Piwik instance.
     * 
     * @return array Piwik sites
     */
    public function getSites()
    {
        $piwikPath = $this->variableApi->get('PhaidonPiwikModule', 'tracking_piwikpath', '');
        $enableTracking = $this->variableApi->get('PhaidonPiwikModule', 'tracking_enable', false);

        if (!$enableTracking || empty($piwikPath)) {
            return false;
        }

        $siteList = $this->getData('SitesManager.getSitesWithAtLeastViewAccess');
        if (!$siteList) {
            $this->session->getFlashBag()->addFlash('error', $this->translator->__('An error occured. Please check URL and auth token. You need at least view access to one site.'));

            return false;
        }

        $sites = [];
        foreach ($siteList as $site) {
            $sites[$site['name']] = $site['idsite'];
        }

        ksort($sites);

        return $sites;
    }

    /**
     * Retrieves desired data from a Piwik instance.
     *
     * @param string $method The api method name
     * @param string $period The chosen period (day, week, month, year)
     * @param string $date   Optional date filter
     * @param int    $limit  Optional limit for amount of returned data rows
     *
     * @throws Exception if no method is given
     *
     * @return boolean|string
     */
    public function getData($method = '', $period = '', $date = '', $limit = -1)
    {
        if (empty($method)) {
            throw new Exception();
        }

        $dateValue = $date instanceof \DateTime ? $date->format('Y-m-d') : $date;

        $siteId = $this->variableApi->get('PhaidonPiwikModule', 'tracking_siteid');
        $token = $this->variableApi->get('PhaidonPiwikModule', 'tracking_token');

        $url = $this->getBaseUrl();
        $url .= 'index.php?module=API&method=' . $method;
        $url .= '&idSite=' . $siteId . '&period=' . $period . '&date=' . $dateValue;
        $url .= '&format=json&filter_limit=' . $limit;
        $url .= '&token_auth=' . $token;

        $result = $this->callUrl($url);

        return json_decode($result, true);
    }

    /**
     * Calls a given URL and returns the response.
     *
     * @param string $url The url.
     *
     * @return string
     */
    private function callUrl($url)
    {
        $result = false;

        // Use cURL if available
        if (function_exists('curl_init')) {
            // Init cURL
            $c = curl_init($url);

            // Set cURL options
            curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($c, CURLOPT_HEADER, 0);

            // Get result
            $result = curl_exec($c);

            // Close connection
            curl_close($c);
        } elseif (ini_get('allow_url_fopen')) {
            // Get file using file_get_contents
            $result = @file_get_contents($url);
        } else {
            $result = json_encode([
                'result' => 'error',
                'message' => 'Remote access to Piwik not possible. Enable allow_url_fopen or CURL.'
            ]);
        }

        if (false === $result) {
            $this->session->getFlashBag()->addFlash('error', $this->translator->__('Could connect to Piwik. Probably the url is wrong?'));
        }

        // Return result
        return $result;
    }
}
