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

namespace Phaidon\PiwikModule\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Zikula\Core\Controller\AbstractController;
use Zikula\ThemeModule\Engine\Annotation\Theme;

/**
 * Class DashboardController
 * @Route("/dashboard")
 */
class DashboardController extends AbstractController
{
    /**
     * This function shows the Piwik dashboard.
     * 
     * @Route("/")
     * @Theme("admin")
     * @Template("PhaidonPiwikModule:Dashboard:index.html.twig")
     *
     * @param Request $request
     * @throws AccessDeniedException Thrown if the user doesn't have admin access to the module
     * @return Response
     */
    public function indexAction(Request $request)
    {
        // Security check
        if (!$this->hasPermission('PhaidonPiwikModule::', '::', ACCESS_ADMIN)) {
            throw new AccessDeniedException();
        }

        $context = $request->query->has('context') ? $request->query->get('context') : 'overview';
        if (!in_array($context, ['overview', 'lastVisits'])) {
            $context = 'overview';
        }

        $formData = [
            'period' => 'day',
            'date' => new \DateTime()/* date ranges are not enabled yet,
            'from' => new \DateTime(),
            'to' => new \DateTime()*/
        ];

        $form = $this->createForm('Phaidon\PiwikModule\Form\Type\DashboardType',
            $formData, [
                'translator' => $this->get('translator.default'),
                'context' => $context
            ]
        );

        if ($form->handleRequest($request)->isValid()) {
            if ($form->get('save')->isClicked()) {
                $formData = $form->getData();
            }
        }

        $templateParameters = array_merge($formData, [
            'form' => $form->createView(),
            'context' => $context
        ]);

        $dashboardHelper = $this->get('phaidon_piwik_module.helper.dashboard_helper');

        if ($context == 'overview') {
            $templateParameters['overviewData'] = $dashboardHelper->showOverview($formData['period'], $formData['date']);
            $templateParameters['pagesData'] = $dashboardHelper->showPages($formData['period'], $formData['date']);
        } elseif ($context == 'lastVisits') {
            $templateParameters['visitorsData'] = $dashboardHelper->showVisitors($formData['period']);
        }

        return $templateParameters;
    }
}
