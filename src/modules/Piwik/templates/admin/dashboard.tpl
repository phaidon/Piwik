{ajaxheader modname=Piwik filename=dashboard.js noscriptaculous=true effects=true}
{adminheader}
<div class="z-admin-content-pagetitle">
    {icon type="config" size="small"}
    <h3>{gt text="Piwik dashboard"}</h3>
</div>


{form cssClass="z-form"}
{formvalidationsummary}

<fieldset>
    <legend>{gt text='General settings'}</legend>

    <div class="z-formrow">
        {formlabel for="period" __text='Period'}
        {formdropdownlist id="period" items=$periods}  
    </div>
    <div class="z-formrow" id='date'>
        {formlabel for="date" __text='Date'}
        {formdateinput useSelectionMode=1 id="date" ifFormat='%e. %B %Y' dateformat='%e. %B %Y'}
    </div>
    <div id="fromto">
        <div class="z-formrow">
            {formlabel for="from" __text='From'}
            {formdateinput useSelectionMode=1 id="from" ifFormat='%e. %B %Y' dateformat='%e. %B %Y'}
        </div>
        <div class="z-formrow">
            {formlabel for="to" __text='To'}
            {formdateinput useSelectionMode=1 id="to" ifFormat='%e. %B %Y' dateformat='%e. %B %Y'}
        </div>
    </div>

    <div class="z-formbuttons z-buttons">
        {formbutton class="z-bt-ok" commandName="save" __text="Show"}
    </div>
</fieldset>


{/form}

<div id="slider-container" style="display: none">
    <div id="sliderbar"></div>
</div>

<br />

<h3>{gt text='Dashboard'}</h3>
{include file="admin/stats_single.tpl" widgetModule="Dashboard" widgetAction="index"}

<p><a href="{modurl modname="Piwik" type="user" func="stats"}" title="Die erweiterten Statistiken anzeigen">Die erweiterten Statistiken anzeigen</a></p>

</div>

{adminfooter}
