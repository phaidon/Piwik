document.observe('dom:loaded', piwik_dashboard_init);

function piwik_dashboard_init()
{
    piwik_range_check();
    $('period').observe('change', piwik_range_check);
}

function piwik_range_check()
{
    if ($('period').value == 'range') {
        $('date').hide();
        $('fromto').show();
    } else {
        $('date').show();
        $('fromto').hide();
    }
}

