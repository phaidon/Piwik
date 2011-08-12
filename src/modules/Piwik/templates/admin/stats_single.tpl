{if $widgetModule eq "Dashboard"}
    {assign var="frameheight" value="1000px"}
{else}
    {assign var="frameheight" value="200px"}
{/if}

<div id="widgetIframe{$widgetModule}{$widgetAction}">
    <iframe src="http://{$modvars.Piwik.tracking_piwikpath}/index.php?module=Widgetize&amp;action=iframe{if $widgetAction ne "getSparklines"}&amp;columns[]=nb_visits{/if}&amp;moduleToWidgetize={$widgetModule}&amp;actionToWidgetize={$widgetAction}&amp;idSite={$modvars.Piwik.tracking_siteid}&amp;period={$period}&amp;date={$date}&amp;disableLink=1&amp;token_auth={$modvars.Piwik.tracking_token}" scrolling="auto" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="{$frameheight}"></iframe>
</div>
