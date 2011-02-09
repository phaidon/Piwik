{* purpose of this template: statistics overview *}
{* $Id: piwik_user_dashboard.htm 21 2010-04-21 01:56:44Z hilope $ *}

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

<h2>{gt text="Page statistic"}</h2>

{configgetvar name="entrypoint" assign="ourEntry"}
<form action="{$ourEntry|default:'index.php'}" method="get">
    <div>
        <input type="hidden" name="module" value="piwik" />
        <input type="hidden" name="type" value="user" />
        <input type="hidden" name="func" value="main" />

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

<h3>{gt text='Dashboard'}</h3>
{include file="piwik_user_stats_single.tpl" widgetModule="Dashboard" widgetAction="index"}

<p><a href="{modurl modname="piwik" type="user" func="stats"}" title="Die erweiterten Statistiken anzeigen">Die erweiterten Statistiken anzeigen</a></p>

</div>

{include file="piwik_user_footer.tpl"}
