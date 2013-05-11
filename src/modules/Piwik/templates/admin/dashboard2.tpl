{adminheader}
<div class="z-admin-content-pagetitle">
    {icon type="config" size="small"}
    <h3>{gt text="Piwik dashboard"}</h3>
</div>

{modulelinks modname='Piwik' type='dashboard'}<br />

{form cssClass="z-form"}
{formvalidationsummary}

    <fieldset>

        <div class="z-formrow">
            {formlabel for="period" __text='Period'}
            {formdropdownlist id="period" items=$periods}
        </div>

        <div class="z-formbuttons z-buttons">
            {formbutton class="z-bt-ok" commandName="save" __text="Show"}
        </div>
    </fieldset>


{modapifunc modname='Piwik' type='dashboard' func='showVisitors' period=$period}

{/form}

{adminfooter}