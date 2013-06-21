document.observe('dom:loaded', piwik_modifyconfig_init);

function piwik_modifyconfig_init()
{
    $('tracking_enable').observe('change', piwik_tracking_onchange);

    if (!$('tracking_enable').checked) {
        $('piwik_settings_container').hide();
    }
}

function piwik_tracking_onchange()
{
    Zikula.checkboxswitchdisplaystate('tracking_enable', 'piwik_settings_container', true);
}

