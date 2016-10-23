(function($) {
    function piwikRangeCheck()
    {
        if ($('#period').val() == 'range') {
            $('#date').addClass('hidden');
            $('#fromto').removeClass('hidden');
        } else {
            $('#date').removeClass('hidden');
            $('#fromto').addClass('hidden');
        }
    }

    $(document).ready(function() {
        piwikRangeCheck();
        $('#period').change(piwikRangeCheck);
    }
})(jQuery)
