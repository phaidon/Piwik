<?php
/**
 * Copyright Piwik Team 2013
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @package Piwik
 * @link https://github.com/phaidon/Piwik
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
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

        $blockinfo['content'] = ModUtil::apiFunc($this->name, 'user', 'optOut');

        return BlockUtil::themeBlock($blockinfo);
    }
}