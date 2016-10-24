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

namespace Phaidon\PiwikModule\Container;

use Phaidon\PiwikModule\Helper\PiwikDataHelper;
use Symfony\Component\Routing\RouterInterface;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Core\LinkContainer\LinkContainerInterface;
use Zikula\PermissionsModule\Api\PermissionApi;

class LinkContainer implements LinkContainerInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var PermissionApi
     */
    private $permissionApi;

    /**
     * @var PiwikDataHelper
     */
    private $piwikDataHelper;

    /**
     * LinkContainer constructor.
     *
     * @param TranslatorInterface $translator      TranslatorInterface service instance
     * @param RouterInterface     $router          RouterInterface service instance
     * @param PermissionApi       $permissionApi   PermissionApi service instance
     * @param PiwikDataHelper     $piwikDataHelper PiwikDataHelper service instance
     */
    public function __construct(TranslatorInterface $translator, RouterInterface $router, PermissionApi $permissionApi, PiwikDataHelper $piwikDataHelper)
    {
        $this->translator = $translator;
        $this->router = $router;
        $this->permissionApi = $permissionApi;
        $this->piwikDataHelper = $piwikDataHelper;
    }

    /**
     * get Links of any type for this extension
     * required by the interface
     *
     * @param string $type
     * @return array
     */
    public function getLinks($type = LinkContainerInterface::TYPE_ADMIN)
    {
        $method = 'get' . ucfirst(strtolower($type));
        if (method_exists($this, $method)) {
            return $this->$method();
        }

        return [];
    }

    /**
     * get the Admin links for this extension
     *
     * @return array
     */
    private function getAdmin()
    {
        $links = [];

        if (!$this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_ADMIN)) {
            return $links;
        }

        $links[] = [
            'url' => $this->router->generate('phaidonpiwikmodule_config_config'),
            'text' => $this->translator->__('Settings'),
            'icon' => 'wrench'
        ];

        $links[] = [
            'url' => $this->router->generate('phaidonpiwikmodule_admin_dashboard'),
            'text' => $this->translator->__('Piwik dashboard'),
            'icon' => 'bar-chart'
        ];

        $links[] = [
            'url' => $this->router->generate('phaidonpiwikmoduletroubleshooting'), 
            'text' => $this->translator->__('Troubleshooting'),
            'icon' => 'life-ring'
        ];

        return $links;
    }

    /**
     * get the Dashboard links for this extension
     *
     * @return array
     */
    private function getDashboard()
    {
        $links = [];

        if ($this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_ADMIN)) {
            $links[] = [
                'url' => $this->router->generate('phaidonpiwikmodule_dashboard_index'),
                'text' => $this->translator->__('Overview'),
                'icon' => 'bar-chart'
            ];

            $links[] = [
                'url' => $this->router->generate('phaidonpiwikmodule_dashboard_index', { context: 'lastVisits' } ),
                'text' => $this->translator->__('Recent visits'),
                'icon' => 'tachometer'
            ];
        }

        if ($this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_READ)) {
            $links[] = [
                'url' => $this->piwikDataHelper->getBaseUrl(),
                'text' => $this->translator->__('Piwik web interface'),
                'icon' => 'external-link'
            ];
        }

        return $links;
    }

    /**
     * set the BundleName as required by the interface
     *
     * @return string
     */
    public function getBundleName()
    {
        return 'PhaidonPiwikModule';
    }
}
