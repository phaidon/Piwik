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

use Phaidon\PiwikModule\Form\Type\ConfigType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Zikula\Core\Controller\AbstractController;
use Zikula\ThemeModule\Engine\Annotation\Theme;

/**
 * Class ConfigController
 * @Route("/config")
 */
class ConfigController extends AbstractController
{
    /**
     * @Route("/config")
     * @Template("@PhaidonPiwikModule/Config/config.html.twig")
     * @Theme("admin")
     *
     * @param Request $request
     * @throws AccessDeniedException Thrown if the user doesn't have admin access to the module
     * @return Response
     */
    public function configAction(Request $request)
    {
        // Security check
        if (!$this->hasPermission('PhaidonPiwikModule::', '::', ACCESS_ADMIN)) {
            throw new AccessDeniedException();
        }

        $variableApi = $this->get('zikula_extensions_module.api.variable');
        $modVars = $variableApi->getAll('PhaidonPiwikModule');

        $sites = $this->get('phaidon_piwik_module.helper.piwik_data_helper')->getSites();

        $form = $this->createForm(ConfigType::class,
            $modVars, [
                'translator' => $this->get('translator.default'),
                'sites' => $sites
            ]
        );

        if ($form->handleRequest($request)->isValid()) {
            if ($form->get('save')->isClicked()) {
                $formData = $form->getData();

                //$formData['tracking_piwikpath'] = filter_var($formData['tracking_piwikpath'], FILTER_SANITIZE_URL);
                $formData['tracking_piwikpath'] = str_replace('https://', '', $formData['tracking_piwikpath']);
                $formData['tracking_piwikpath'] = str_replace('http://', '',  $formData['tracking_piwikpath']); 

                // Update module variables.
                $this->setVars($formData);

                $this->addFlash('status', $this->__('Done! Module configuration updated.'));

                // refetch sites
                $sites = $this->get('phaidon_piwik_module.helper.piwik_data_helper')->getSites();
            }
            if ($form->get('cancel')->isClicked()) {
                $this->addFlash('status', $this->__('Operation cancelled.'));
            }
        }

        return [
            'form' => $form->createView(),
            'sites' => $sites
        ];
    }
}
