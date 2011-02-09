{* $Id: piwik_user_stats_single.tpl 21 2010-04-21 01:56:44Z hilope $ *}
{modgetvar module="piwik" name="tracking_token" assign="token"}
{modgetvar module="piwik" name="tracking_siteid" assign="siteid"}
{modgetvar module="piwik" name="tracking_piwikpath" assign="path"}
{if $widgetModule eq "Dashboard"}
    {assign var="frameheight" value="1000px"}
{else}
    {assign var="frameheight" value="200px"}
{/if}
<div id="widgetIframe{$widgetModule}{$widgetAction}">
    <iframe src="{$tracking_piwikpath}/index.php?module=Widgetize&amp;action=iframe{if $widgetAction ne "getSparklines"}&amp;columns[]=nb_visits{/if}&amp;moduleToWidgetize={$widgetModule}&amp;actionToWidgetize={$widgetAction}&amp;idSite={$tracking_siteid}&amp;period={$period}&amp;date={$periodDate}&amp;disableLink=1&amp;token_auth={$tracking_token}" scrolling="auto" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="{$frameheight}"></iframe>
</div>
