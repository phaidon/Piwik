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

namespace Phaidon\PiwikModule\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Zikula\Core\Controller\AbstractController;

/**
 * Class AdminController
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * main
     *
     * This function is a redirect to modifyconfig
     * 
     * @return string
     */
    public function main()
    {
        @trigger_error('The admin_main function is deprecated. please use phaidonpiwikmodule_config_config route instead.', E_USER_DEPRECATED);

        return $this->redirectToRoute('phaidonpiwikmodule_config_config');
    }

    /**
     * Modify config
     *
     * This function allows to modify the settings of the module
     * 
     * @return Zikula_Form_AbstractHandler
     */
    public function modifyconfig()
    {
        @trigger_error('The admin_modifyconfig function is deprecated. please use phaidonpiwikmodule_config_config route instead.', E_USER_DEPRECATED);

        return $this->redirectToRoute('phaidonpiwikmodule_config_config');
    }

    /**
     * This function shows the Piwik dashboard.
     * 
     * @param Request $request
     * @throws AccessDeniedException Thrown if the user doesn't have admin access to the module
     * @return Response
     */
    public function dashboard(Request $request)
    {
        @trigger_error('The admin_dashboard function is deprecated. please use phaidonpiwikmodule_dashboard_index route instead.', E_USER_DEPRECATED);

        return $this->redirectToRoute('phaidonpiwikmodule_dashboard_index');
    }

    /**
     * This function shows the Piwik dashboard.
     * 
     * @param Request $request
     * @throws AccessDeniedException Thrown if the user doesn't have admin access to the module
     * @return Response
     */
    public function dashboard2(Request $request)
    {
        @trigger_error('The admin_dashboard2 function is deprecated. please use phaidonpiwikmodule_dashboard_lastvisitors route instead.', E_USER_DEPRECATED);

        return $this->redirectToRoute('phaidonpiwikmodule_dashboard_lastvisitors');
    }

    /**
     * This function give hints for the troubleshooting.
     * 
     * @Route("/troubleshooting")
     * @Template("PhaidonPiwikModule:Admin:troubleshooting.html.twig")
     *
     * @param Request $request
     * @throws AccessDeniedException Thrown if the user doesn't have admin access to the module
     * @return Response
     */
    public function troubleshootingAction(Request $request)
    {
        if (!$this->hasPermission('PhaidonPiwikModule::', '::', ACCESS_ADMIN)) {
            throw new AccessDeniedException();
        }

        return [
            'piwikUrl' => $this->get('phaidon_piwik_module.helper.piwik_data_helper')->getBaseUrl(),
            'siteId' => $this->getVar('tracking_siteid', 'SITEID')
        ];
    } 
}
