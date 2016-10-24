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
     * @Template
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
            'form' => $form->createView()
        ]);

        // TODO legacy calls
        if ($context == 'overview') {
            $templateParameters['overviewData'] = \ModUtil::apiFunc('PhaidonPiwikModule', 'dashboard', 'showOverview', [ 'period' => $period, 'date' => $date ]);
            $templateParameters['pagesData'] = \ModUtil::apiFunc('PhaidonPiwikModule', 'dashboard', 'showPages', [ 'period' => $period, 'date' => $date ]);
        } elseif ($context == 'lastVisits') {
            $templateParameters['visitorsData'] = \ModUtil::apiFunc('PhaidonPiwikModule', 'dashboard', 'showVisitors', [ 'period' => $period ]);
        }

        return $templateParameters;
    }
}
