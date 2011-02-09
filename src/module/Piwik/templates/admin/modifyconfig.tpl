{include file="admin/menu.tpl"}
<h2>{gt text="Modify configuration"}</h2>

{form cssClass="z-form"}
{formvalidationsummary}

<input type="hidden" name="authid" value="{secgenauthkey module='piwik'}" />

<fieldset>
    <legend>{gt text='General settings'}</legend>

    <div class="z-formrow">
        {formlabel for="tracking_enable" __text='Enable Tracking'}
        {formcheckbox id="tracking_enable" checked=$tracking_enable}
     </div>
      <div class="z-formrow">
        {formlabel for="tracking_piwikpath" __text='URL to your piwik installation' html='1'}
        {formtextinput size="40" maxLength="100" id="tracking_piwikpath" text=$tracking_piwikpath}
      </div>
      <div class="z-formrow">
        {formlabel for="tracking_siteid" __text='Site-ID' html='1'}
        {formtextinput size="2" maxLength="3" id="tracking_siteid" text=$tracking_siteid}
      </div>
      <div class="z-formrow">
        {formlabel for="tracking_token" __text='Piwik Token' html='1'}
        {formtextinput size="40" maxLength="40" id="tracking_token" text=$tracking_token}
      </div>
      <div class="z-formrow">
        {formlabel for="tracking_adminpages" __text='Track admin pages'}
        {formcheckbox id="tracking_adminpages" checked=$tracking_adminpages}
      </div>
      <div class="z-formrow">
        {formlabel for="tracking_linktracking" __text='Track Links'}
        {formcheckbox id="tracking_linktracking" checked=$tracking_linktracking}
      </div>

        <div class="z-formbuttons">
            {formimagebutton id="create" commandName="create" __text="Save" imageUrl="images/icons/small/button_ok.gif"}
        </div>

</fieldset>

{/form}