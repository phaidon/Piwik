<?php
/**
 * Copyright Piwik Team 2011
 *
 * @license GNU/GPLv3 (or at your option, any later version).
 * @link https://github.com/phaidon/Piwik
 */

/**
 * This function modifies hypens to spaces.
 *
 * @param string $text  Text.
 * @param string $minus Minus.
 * 
 * @return string
 */
function smarty_modifier_minus($text, $minus)
{
    return (int)$text - (int)$minus;
}
