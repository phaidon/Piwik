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

namespace Phaidon\PiwikModule\Block;

use Zikula\BlocksModule\AbstractBlockHandler;
use Zikula\SearchModule\AbstractSearchable;

/**
 * OptOut block class.
 */
class OptOutBlock extends AbstractBlockHandler
{
    /**
     * display block
     *
     * @param array $properties
     * @return string the rendered bock
     */
    public function display(array $properties)
    {
        if (!$this->hasPermission('OptOut::', $properties['bid'] . '::', ACCESS_READ)) {
            return '';
        }

        // set some defaults
        if (!isset($properties['optOutWidth'])) {
            $properties['optOutWidth'] = '100%';
        }
        if (!isset($properties['optOutHeight'])) {
            $properties['optOutHeight'] = '200px';
        }

        $userOutputHelper = $this->get('phaidon_piwik_module.helper.user_output_helper');

        return $userOutputHelper->optOut($properties['optOutWidth'], $properties['optOutHeight']);
    }

    /**
     * Returns the fully qualified class name of the block's form class.
     *
     * @return string Template path
     */
    public function getFormClassName()
    {
        return 'Phaidon\PiwikModule\Block\Form\Type\OptOutBlockType';
    }

    /**
     * Returns the template used for rendering the editing form.
     *
     * @return string Template path
     */
    public function getFormTemplate()
    {
        return '@PhaidonPiwikModule/Block/optout_modify.html.twig';
    }
}
