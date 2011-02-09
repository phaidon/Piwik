/**
 * Zikula Application Framework
 *
 * @copyright (c) 2001, Zikula Development Team
 * @link http://www.zikula.org
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 *
 * @package piwik
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @author sven schomacker / Axel Guckelsberger
 * @version $Id: piwik.js 21 2010-04-21 01:56:44Z hilope $
 */

function pwChangeStatSelectionPeriod(doRedirect) {
    if ($F('pwselectionperiod') == 14) {
        $('pwcustomperiodfields').show();
        $('pwselectionperiodsubmit').show();
        $('slider-container').show();
    }
    else {
        $('pwcustomperiodfields').hide();
        $('pwselectionperiodsubmit').hide();
        $('slider-container').hide();
        if (doRedirect) {
            var paramList = '&selectionperiod=' + $F('pwselectionperiod');
            document.location = document.location.pnbaseURL + document.location.entrypoint + '?module=piwik&type=user&func=view' + paramList;
        }
    }
}

function pwInitStatisticView(startDate, endDate, currentYear) {
    l_oOptions = {
        dragHandles: true,
        dayWidth: 1,
        dateFormat : 'yyyy-MM-dd',

/*        dateFormat : 'MM-d-yyyy',
        dateFormat : 'MMMM d, yyyy'*/
        zoom : true
    }

    dateSlider = new DateSlider('sliderbar', startDate, endDate, 2009, currentYear, l_oOptions);
    dateSlider.attachFields($('pwcustomperiodStart'), $('pwcustomperiodEnd'));

    $('pwselectionperiod').observe('change', function() { pwChangeStatSelectionPeriod(true); });

    pwChangeStatSelectionPeriod();

    $('pwcustomselectionperiod').show();
    //$('pwselectionperiodsubmit').hide();
}
