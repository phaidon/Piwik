(function($) {
    function piwikToggleTracking()
    {
        Zikula.checkboxswitchdisplaystate('tracking_enable', 'piwik_settings_container', true);
    }

    $(document).ready(function() {
        $('#tracking_enable').change(piwikToggleTracking);

        if (!$('#tracking_enable').prop('checked')) {
            $('#piwik_settings_container').addClass('hidden');
        }
    });
})(jQuery)
