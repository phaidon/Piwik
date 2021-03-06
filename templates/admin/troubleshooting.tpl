{adminheader}
<div class="z-admin-content-pagetitle">
    {icon type="help" size="small"}
    <h3>{gt text="Troubleshooting"}</h3>
</div>

<p>
    {gt text="If Piwik does not log the page accesses please check the following questions:"}

    <ol>
        <li>{gt text="Are your Piwik settings (path, token and side) corect configured?"}</li>
        <li>{gt text="Does the Piwik code (see above) appears in the source code of your page."}</li>
        <li>
            {gt text="Is the Piwik code (see above) identical with this one of the Piwik web interface?"}<br />
            <a href="http://{$modvars.Piwik.tracking_piwikpath}/index.php?module=SitesManager&action=displayJavascriptCode&idSite={$modvars.Piwik.tracking_siteid}">
                http://{$modvars.Piwik.tracking_piwikpath}/index.php?module=SitesManager&action=displayJavascriptCode&idSite={$modvars.Piwik.tracking_siteid|default:'SIDEID'}
            </a>
        </li>
    </ol>

</p>

<div style="margin:8px;font:smaller">
<textarea rows=16 style="width:100%">
{include file='userapi/tracker.tpl' assign='test'}
{$test|htmlspecialchars}
</textarea>
</div>

<p>
    {gt text="If this does not help feel free to ask in the Zikula forums for help."}
</p>

{adminfooter}