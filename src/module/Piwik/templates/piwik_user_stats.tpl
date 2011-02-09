{* purpose of this template: statistics overview *}
{* $Id: piwik_user_stats.htm 21 2010-04-21 01:56:44Z hilope $ *}

{pageaddvar name="javascript" value="javascript/ajax/prototype.js"}
{pageaddvar name="javascript" value="javascript/ajax/scriptaculous.js"}
{pageaddvar name="javascript" value="modules/Piwik/javascript/stats.js"}
{pageaddvar name="stylesheet" value="modules/Piwik/style/stats.css"}
{pageaddvar name='stylesheet' value="modules/Piwik/javascript/dateslider/dateslider.css'}
{pageaddvar name='javascript' value="modules/Piwik/javascript/dateslider/date-en-US.js'}
{pageaddvar name='javascript' value="modules/Piwik/javascript/dateslider/dateslider.js'}

{if $selectionPeriod eq 1}{gt text='Usage statistics from today' assign="pageTitle"}
{elseif $selectionPeriod eq 2}{gt text='Usage statistics from yesterday' assign="pageTitle"}
{elseif $selectionPeriod eq 3}{gt text='Usage statistics from the day before yesterday' assign="pageTitle"}
{elseif $selectionPeriod eq 4}{gt text='Usage statistics from current week' assign="pageTitle"}
{elseif $selectionPeriod eq 5}{gt text='Usage statistics from last week' assign="pageTitle"}
{elseif $selectionPeriod eq 6}{gt text='Usage statistics from the week before last week' assign="pageTitle"}
{elseif $selectionPeriod eq 7}{gt text='Usage statistics from current month' assign="pageTitle"}
{elseif $selectionPeriod eq 8}{gt text='Usage statistics from last month' assign="pageTitle"}
{elseif $selectionPeriod eq 9}{gt text='Usage statistics from the month before last month' assign="pageTitle"}
{elseif $selectionPeriod eq 10}{gt text='Usage statistics from current year' assign="pageTitle"}
{elseif $selectionPeriod eq 11}{gt text='Usage statistics from last year' assign="pageTitle"}
{elseif $selectionPeriod eq 12}{gt text='Usage statistics from the year before last year' assign="pageTitle"}
{elseif $selectionPeriod eq 13}{gt text='Usage statistics overall' assign="pageTitle"}
{elseif $selectionPeriod eq 14}{gt text='Usage statistics from %1$s to %2$s' tag1=$startDate|date_format tag2=$endDate|date_format assign="pageTitle"}
{/if}

<div class="z-admincontainer" id="usagestats">
<div class="z-adminpageicon">{img modname="core" src="demo.gif" set="icons/large" __alt='Details'}</div>

{pagesetvar name="title" value=$pageTitle}
<h2>{$pageTitle}</h2>

{configgetvar name="entrypoint" assign="ourEntry"}
<form action="{$ourEntry|default:'index.php'}" method="get">
    <div>
        <input type="hidden" name="module" value="piwik" />
        <input type="hidden" name="type" value="user" />
        <input type="hidden" name="func" value="stats" />

        <div id="picustomperiodfields" style="display: none">
            <label for="pidatestart">{gt text='From:'}</label>  <input type="text" id="picustomperiodStart" name="eps" value="{$startDate}" size="10" />
            <label for="pidateend">{gt text='To:'}</label>  <input type="text" id="picustomperiodEnd" name="epe" value="{$endDate}" size="10" />
        </div>

        <label for="piselectionperiod">{gt text='Period:'}</label>
        <select id="piselectionperiod" name="selectionperiod">
            <option value="1">{gt text='Today'}</option>
            <option value="2"{if $selectionPeriod eq 2} selected="selected"{/if}>{gt text='Yesterday'}</option>
            <option value="3"{if $selectionPeriod eq 3} selected="selected"{/if}>{gt text='Day before yesterday'}</option>
            <option value="4"{if $selectionPeriod eq 4} selected="selected"{/if}>{gt text='Current week'}</option>
            <option value="5"{if $selectionPeriod eq 5} selected="selected"{/if}>{gt text='Last week'}</option>
            <option value="6"{if $selectionPeriod eq 6} selected="selected"{/if}>{gt text='Week before last week'}</option>
            <option value="7"{if $selectionPeriod eq 7} selected="selected"{/if}>{gt text='Current month'}</option>
            <option value="8"{if $selectionPeriod eq 8} selected="selected"{/if}>{gt text='Last month'}</option>
            <option value="9"{if $selectionPeriod eq 9} selected="selected"{/if}>{gt text='Month before last month'}</option>
            <option value="10"{if $selectionPeriod eq 10} selected="selected"{/if}>{gt text='Current year'}</option>
            <option value="11"{if $selectionPeriod eq 11} selected="selected"{/if}>{gt text='Last year'}</option>
            <option value="12"{if $selectionPeriod eq 12} selected="selected"{/if}>{gt text='Year before last year'}</option>
            <option value="14"{if $selectionPeriod eq 14} selected="selected"{/if} id="picustomselectionperiod" style="display: none">{gt text='Custom time period'}</option>
        </select>
        <input type="submit" id="piselectionperiodsubmit" value="{gt text='Submit'}" />
    </div>
</form>

<div id="slider-container" style="display: none">
    <div id="sliderbar"></div>
</div>

<br />

{assign var="period" value="day"}
{assign var="periodDate" value=$startDate}

{if $selectionPeriod eq 1}{* today *}
    {assign var="periodDate" value="today"}
{elseif $selectionPeriod eq 2}{* yesterday *}
    {assign var="periodDate" value="yesterday"}
{elseif $selectionPeriod eq 3}{* day before yesterday *}
{elseif $selectionPeriod gt 3 && $selectionPeriod lt 7}
    {assign var="period" value="week"}
    {if $selectionPeriod eq 4}{* thisweek *}
    {elseif $selectionPeriod eq 5}{* lastweek *}
    {elseif $selectionPeriod eq 6}{* week before last week *}
    {/if}
{elseif $selectionPeriod gt 6 && $selectionPeriod lt 10}
    {assign var="period" value="month"}
    {if $selectionPeriod eq 7}{* this month *}
    {elseif $selectionPeriod eq 8}{* last month *}
    {elseif $selectionPeriod eq 9}{* month before last month *}
    {/if}
{elseif $selectionPeriod gt 9}
    {assign var="period" value="year"}
    {if $selectionPeriod eq 10}{* this year *}
    {elseif $selectionPeriod eq 11}{* last year *}
    {elseif $selectionPeriod eq 12}{* year before last year *}
    {/if}
{elseif $selectionPeriod eq 14}{* custom *}
{/if}

<h3>{gt text='Referers'}</h3>
<div class="accordcontainer">
    <div style="width: 48%; float: left">
        <h4>{gt text='Overview'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="Referers" widgetAction="getRefererType"}
    </div>
    <div style="width: 48%; float: right">
        <h4>{gt text='List of external websites'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="Referers" widgetAction="getWebsites"}
    </div>
    <br style="clear: both" />
    <div style="width: 48%; float: left">
        <h4>{gt text='List of search terms'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="Referers" widgetAction="getKeywords"}
    </div>
    <div style="width: 48%; float: right">
        <h4>{gt text='Best search engines'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="Referers" widgetAction="getSearchEngines"}
    </div>
    <br style="clear: both" />
</div>

<h3>{gt text='Visits Summary'}</h3>
<div class="accordcontainer">
    <div style="width: 48%; float: left">
        <h4>{gt text='Visits Overview'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="VisitsSummary" widgetAction="getSparklines"}
    </div>
    <div style="width: 48%; float: right">
        <h4>{gt text='Graph of last visitors'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="VisitsSummary" widgetAction="getEvolutionGraph"}
    </div>
    <br style="clear: both" />
</div>

<h3>{gt text='Visitors'}</h3>
<div class="accordcontainer">
    <div style="width: 28%; float: left">
        <h4>{gt text='Visitor countries'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="UserCountry" widgetAction="getCountry"}
    </div>
    <div style="width: 20%; float: left">
        <h4>{gt text='Visitor continents'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="UserCountry" widgetAction="getContinent"}
    </div>
    <div style="width: 48%; float: right">
        <h4>{gt text='Providers'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="Provider" widgetAction="getProvider"}
    </div>
    <br style="clear: both" />
    <div style="width: 48%; float: left">
        <h4>{gt text='Frequency overview'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="VisitFrequency" widgetAction="getSparklines"}
    </div>
    <div style="width: 48%; float: right">
        <h4>{gt text='Graphic of returning visitors'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="VisitFrequency" widgetAction="getEvolutionGraph"}
    </div>
    <br style="clear: both" />
    <div style="width: 48%; float: left">
        <h4>{gt text='Visit duration'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="VisitorInterest" widgetAction="getNumberOfVisitsPerVisitDuration"}
    </div>
    <div style="width: 48%; float: right">
        <h4>{gt text='Visits per page'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="VisitorInterest" widgetAction="getNumberOfVisitsPerPage"}
    </div>
    <br style="clear: both" />
</div>

<h3>{gt text='Visitor settings'}</h3>
<div class="accordcontainer">
    <div style="width: 48%; float: left">
        <h4>{gt text='Visitor browsers'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="UserSettings" widgetAction="getBrowser"}
    </div>
    <div style="width: 48%; float: right">
        <h4>{gt text='Browsers per family'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="UserSettings" widgetAction="getBrowserType"}
    </div>
    <br style="clear: both" />
    <div style="width: 48%; float: left">
        <h4>{gt text='Screen resolutions'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="UserSettings" widgetAction="getResolution"}
    </div>
    <div style="width: 48%; float: right">
        <h4>{gt text='Normal / Widescreen'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="UserSettings" widgetAction="getWideScreen"}
    </div>
    <br style="clear: both" />
    <div style="width: 48%; float: left">
        <h4>{gt text='Operating systems'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="UserSettings" widgetAction="getOS"}
    </div>
    <div style="width: 48%; float: right">
        <h4>{gt text='List of plugins'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="UserSettings" widgetAction="getPlugin"}
    </div>
    <br style="clear: both" />
    <div style="width: 48%; float: left">
        &nbsp;
    </div>
    <div style="width: 48%; float: right">
        <h4>{gt text='Global visitor configuration'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="UserSettings" widgetAction="getConfiguration"}
    </div>
    <br style="clear: both" />
</div>

<h3>{gt text='Actions'}</h3>
<div class="accordcontainer">
    <div style="width: 48%; float: left">
        <h4>{gt text='Pages'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="Actions" widgetAction="getActions"}
    </div>
    <div style="width: 48%; float: right">
        <h4>{gt text='Outgoing links'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="Actions" widgetAction="getOutlinks"}
        <h4>{gt text='Downloads'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="Actions" widgetAction="getDownloads"}
    </div>
    <br style="clear: both" />
</div>

<h3>Zeiten</h3>
<div class="accordcontainer">
    <div style="width: 48%; float: left">
        <h4>{gt text='Visits per local time of user'}</h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="VisitTime" widgetAction="getVisitInformationPerLocalTime"}
    </div>
    <div style="width: 48%; float: right">
        <h4><h4>{gt text='Visits per local time of server'}</h4></h4>
        {include file="piwik_user_stats_single.tpl" widgetModule="VisitTime" widgetAction="getVisitInformationPerServerTime"}
    </div>
    <br style="clear: both" />
</div>

<p><a href="{modurl modname="piwik" type="user" func="stats"}" title="Die normalen Statistiken anzeigen">Zur&uuml;ck zu den normalen Statistiken</a></p>

<p><a href="{modurl modname="piwik" type="user" func="main"}" title="Dashboard anzeigen">Dashboard anzeigen</a></p>

</div>

{include file="piwik_user_footer.tpl"}

{pageaddvar name='javascript' value='modules/Piwik/javascript/Accordion.js'}
<script type="text/javascript">
// <![CDATA[
    document.observe('dom:loaded', function() {
        var indexOfOpenSlide = 0; // show 1st slide
        new Accordion('div#usagestats h3', 'div#usagestats div.accordcontainer', {duration: 0.3, default_open: indexOfOpenSlide});
/*
duration        The duration of the slide and fade effect.
default_open    The index of the body which is open by default.
OnStart         An event which will be called before opening a new content element.
OnFinish        An event which will be called after the open effect.
*/
    });
// ]]>
</script>
