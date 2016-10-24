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
     * Constructor.
     *
     * @param TranslatorInterface $translator  TranslatorInterface service instance
     * @param VariableApi         $variableApi VariableApi service instance
     * @param SessionInterface    $session     SessionInterface service instance
     */
    public function __construct(TranslatorInterface $translator, VariableApi $variableApi, SessionInterface $session) {
        $this->translator = $translator;
        $this->variableApi = $variableApi;
        $this->session = $session;
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
                return null !== $_SERVER['HTTPS'] ? $httpsPath : $httpPath;
                break;
        }

        return $httpPath;
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

        $siteId = $this->variableApi->get('PhaidonPiwikModule', 'tracking_siteid');
        $token = $this->variableApi->get('PhaidonPiwikModule', 'tracking_token');

        $url = $this->getBaseUrl();
        $url .= 'index.php?module=API&method=' . $method;
        $url .= '&idSite=' . $siteId . '&period=' . $period . '&date=' . $date;
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
