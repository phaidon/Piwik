<!--



function piChangeStatSelectionPeriod(doRedirect) {
    if ($F('pibselectionperiod') == 14) {
        $('picustomperiodfields').show();
        $('piselectionperiodsubmit').show();
        $('slider-container').show();
    }
    else {
        $('picustomperiodfields').hide();
        $('piselectionperiodsubmit').hide();
        $('slider-container').hide();
        if (doRedirect) {
            var paramList = '&selectionperiod=' + $F('piselectionperiod');
            document.location = document.location.pnbaseURL + document.location.entrypoint + '?module=piwik&type=user&func=main' + paramList;
        }
    }
}


function piInitStatisticView(startDate, endDate, currentYear) {
    l_oOptions = {
        dragHandles: true,
        dayWidth: 1,
        dateFormat : 'yyyy-MM-dd',

/*        dateFormat : 'MM-d-yyyy',
        dateFormat : 'MMMM d, yyyy'*/
        zoom : true
    }

    dateSlider = new DateSlider('sliderbar', startDate, endDate, 2009, currentYear, l_oOptions);
    dateSlider.attachFields($('picustomperiodStart'), $('picustomperiodEnd'));

    $('piselectionperiod').observe('change', function() { piChangeStatSelectionPeriod(true); });

    piChangeStatSelectionPeriod();

    $('picustomselectionperiod').show();
    //$('piselectionperiodsubmit').hide();
}



-->