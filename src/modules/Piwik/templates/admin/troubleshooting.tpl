{adminheader}
<div class="z-admin-content-pagetitle">
    {icon type="help" size="small"}
    <h3>{gt text="Troubleshooting"}</h3>
</div>

<p>
    {gt text="If this module does not log the accesses properly please check the following:"}
</p>

<ol>
    <li>{gt text="Check again if your Piwik path, token and side are configured corect."}</li>
    <li>{gt text="Check if the Piwik code (see above) appears in the source code of your page."}</li>
    <li>
        {gt text="Compare the Piwik code (see above) with this one of the Piwik web frontend."}:<br />
        <a href="http://{$modvars.Piwik.tracking_piwikpath}/index.php?module=SitesManager&action=displayJavascriptCode&idSite={$modvars.Piwik.tracking_siteid}">
            http://{$modvars.Piwik.tracking_piwikpath}/index.php?module=SitesManager&action=displayJavascriptCode&idSite={$modvars.Piwik.tracking_siteid|default:'SIDEID'}
        </a>
    </li>
</ol>

<div style="margin:8px;font:smaller">
<textarea rows=16 style="width:100%">
{include file='userapi/tracker.tpl' assign='test'}
{$test|htmlspecialchars}
</textarea>
</div>

<p>
    {gt text="If you still have problems feel free to post in the Zikula forums."}
</p>

{adminfooter}