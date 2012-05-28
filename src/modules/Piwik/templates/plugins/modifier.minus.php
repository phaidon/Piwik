<?php
/**
 * Copyright Wikula Team 2011
 *
 * @license GNU/GPLv3 (or at your option, any later version).
 * @package Wikula
 * @link https://github.com/phaidon/Wikula
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

/**
 * This function modifies hypens to spaces.
 *
 * @param string $text Text.
 * 
 * @return string
 */
function smarty_modifier_minus($text, $minus)
{
    return (int)$text-(int)$minus;
}
