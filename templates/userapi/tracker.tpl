<!-- Piwik -->
<script type="text/javascript">
    var pkBaseURL = '{{modapifunc modname='Piwik' type='user' func='getBaseUrl'}}';
    document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
    try {
        var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", {{$modvars.Piwik.tracking_siteid}});
        piwikTracker.trackPageView();
        piwikTracker.enableLinkTracking();
    }
    catch( err ) {}
</script>
<noscript><p><img src="{modapifunc modname='Piwik' type='user' func='getBaseUrl'}piwik.php?idsite={$modvars.Piwik.tracking_siteid}" style="border:0" alt="" /></p></noscript>
<!-- End Piwik Tag -->
