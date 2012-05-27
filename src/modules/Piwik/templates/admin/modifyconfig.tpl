{ajaxheader modname=Piwik filename=modifyconfig.js noscriptaculous=true effects=true}
{adminheader}
{if !$sites}
    {assign var="error" value="z-form-error"}
{else}
    {assign var="error" value=""}
{/if}
<div class="z-admin-content-pagetitle">
    {icon type="config" size="small"}
    <h3>{gt text="Modify configuration"}</h3>
</div>

{form cssClass="z-form"}
{formvalidationsummary}

<fieldset>
    <legend>{gt text='General settings'}</legend>

    <div class="z-formrow">
        {formlabel for="tracking_enable" __text='Enable Tracking'}
        {formcheckbox id="tracking_enable" checked=$tracking_enable}
    </div>

    <div id="piwik_settings_container">
        <div class="z-formrow">
            {formlabel for="tracking_piwikpath" __text='URL to your Piwik installation'}
            {formurlinput id="tracking_piwikpath" text=$tracking_piwikpath cssClass=$error}
            <em class="z-formnote z-sub">{gt text="Example: http://www.yourdomain.com/piwikpath"}</em>
        </div>
        <div class="z-formrow">
            {formlabel for="tracking_token" __text='Piwik Token' html='1'}
            {formtextinput size="40" maxLength="40" id="tracking_token" text=$tracking_token cssClass=$error}
            <em class="z-formnote z-sub">{gt text="The token can be found here:"}<br /><a href="{$tracking_piwikpath }/index.php?module=API&action=listAllAPI">{$tracking_piwikpath}/index.php?module=API&action=listAllAPI</a></em>
        </div>
        {if $sites}
        <div class="z-formrow">
            {formlabel for="tracking_siteid" __text='Site'}
            {formdropdownlist id="tracking_siteid" items=$sites}            
        </div>
        {/if}
        <div class="z-formrow">
            {formlabel for="tracking_adminpages" __text='Track admin pages'}
            {formcheckbox id="tracking_adminpages" checked=$tracking_adminpages}
        </div>
        <div class="z-formrow">
            {formlabel for="tracking_linktracking" __text='Track Links'}
            {formcheckbox id="tracking_linktracking" checked=$tracking_linktracking}
       </div>
    </div>

    <div class="z-formbuttons z-buttons">
        {formbutton class="z-bt-ok" commandName="save" __text="Save"}
        {formbutton class="z-bt-cancel" commandName="cancel" __text="Cancel"}
    </div>

</fieldset>

{/form}

{adminfooter}