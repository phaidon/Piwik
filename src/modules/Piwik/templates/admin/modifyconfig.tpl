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
</fieldset>

<div id="piwik_settings_container">    
    
    <fieldset>
        <legend>{gt text='Account settings'}</legend>
        <div class="z-formrow">
            {formlabel for="tracking_piwikpath" __text='URL to your Piwik installation'}
            {formurlinput id="tracking_piwikpath" text=$tracking_piwikpath cssClass=$error}
            <em class="z-formnote z-sub">{gt text="Example: http://www.yourdomain.com/piwik"}</em>
        </div>
        <div class="z-formrow">
            {formlabel for="tracking_token" __text='Piwik token'}
            {formtextinput size="40" maxLength="40" id="tracking_token" text=$tracking_token cssClass=$error}
            <em class="z-formnote z-sub">{gt text='Your personal authentification token can be found in the Piwik web interface on the API page. It looks like 1234a5cd6789e0a12345b678cd9012ef.'}<br /></em>
        </div>
        
        {if $sites}
        <div class="z-formrow">
            {formlabel for="tracking_siteid" __text='Site'}
            {formdropdownlist id="tracking_siteid" items=$sites}            
        </div>
        {/if}
        
    </fieldset>    
 
    <fieldset>
        <legend>{gt text='Tracking settings'}</legend>
        <div class="z-formrow">
            {formlabel for="tracking_adminpages" __text='Track admin pages'}
            {formcheckbox id="tracking_adminpages" checked=$tracking_adminpages}
        </div>
        <div class="z-formrow">
            {formlabel for="tracking_linktracking" __text='Track Links'}
            {formcheckbox id="tracking_linktracking" checked=$tracking_linktracking}
       </div>
    </fieldset>    
        
</div>
        
<div class="z-formbuttons z-buttons">
    {formbutton class="z-bt-ok" commandName="save" __text="Save"}
    {formbutton class="z-bt-cancel" commandName="cancel" __text="Cancel"}
</div>
        
{/form}

{adminfooter}