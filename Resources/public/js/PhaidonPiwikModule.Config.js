(function($) {
    function piwikToggleTracking()
    {
        $('#piwikSettingsContainer').toggleClass('hidden', !$('#phaidonpiwikmodule_config_tracking_enable').prop('checked'));
    }

    $(document).ready(function() {
        $('#phaidonpiwikmodule_config_tracking_enable').change(piwikToggleTracking);

        if (!$('#phaidonpiwikmodule_config_tracking_enable').prop('checked')) {
            $('#piwikSettingsContainer').addClass('hidden');
        }
    });
})(jQuery)
