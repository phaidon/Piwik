<?php
/**
 * Copyright Piwik Team 2013
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @link https://github.com/phaidon/Piwik
 */

/**
 * OptOut block class.
 */
class Piwik_Block_OptOut extends Zikula_Controller_AbstractBlock
{
    /**
     * initialise block
     */
    public function init()
    {
        SecurityUtil::registerPermissionSchema('OptOut::', 'Block ID::');
    }

    /**
     * get information on block
     *
     * @return array The block information
     */
    public function info()
    {
        return array(
            'module'         => 'Piwik',
            'text_type'      => $this->__('Opt-Out functionality'),
            'text_type_long' => $this->__("Includes Piwik's opt-out feature"),
            'allow_multiple' => true,
            'form_content'   => false,
            'form_refresh'   => false,
            'show_preview'   => true
        );
    }

    /**
     * modify block
     *
     * @author The Zikula Development Team
     *
     * @param array $blockinfo a blockinfo structure
     *
     * @return output the modify form
     */
    public function modify($blockinfo)
    {
        $vars = BlockUtil::varsFromContent($blockinfo['content']);
        
        // defaults
        if (!isset($vars['width'])) {
            $vars['width'] = '100%';
        }
        if (!isset($vars['height'])) {
            $vars['height'] = '200px';
        }

        // builds and return the output
        return $this->view
            ->assign('vars', $vars)
            ->fetch('block/optout_modify.tpl');
    }

    /**
     * update block
     *
     * @author The Zikula Development Team
     *
     * @param array $blockinfo a blockinfo structure
     *
     * @return array $blockinfo a blockinfo structure
     */
    public function update($blockinfo)
    {
        $vars = [
            'width'  => FormUtil::getPassedValue('piwik_width', null),
            'height' => FormUtil::getPassedValue('piwik_height', null)
        ];

        $blockinfo['content'] = BlockUtil::varsToContent($vars);

        return $blockinfo;
    }

    /**
     * display block
     *
     * @author The Zikula Development Team
     *
     * @param  array $blockinfo a blockinfo structure
     *
     * @return output the rendered bock
     */
    public function display($blockinfo)
    {
        // security check
        if (!SecurityUtil::checkPermission('OptOut::', "$blockinfo[bid]::", ACCESS_READ)) {
            return;
        }

        $vars = BlockUtil::varsFromContent($blockinfo['content']);

        $blockinfo['content'] = ModUtil::apiFunc($this->name, 'user', 'optOut', [
            'width' => $vars['width'],
            'height' => $vars['height']
        ]);

        return BlockUtil::themeBlock($blockinfo);
    }
}
