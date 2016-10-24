<!-- Piwik -->
<script type="text/javascript">
/*Piwik track-code from http://piwik.org/docs/javascript-tracking/ at 2013-09-14*/
var _paq = _paq || [];
(function(){ var u = '{{modapifunc modname='Piwik' type='user' func='getBaseUrl'}}';
    _paq.push(['setSiteId', {{$modvars.Piwik.tracking_siteid}}]);
_paq.push(['setTrackerUrl', u+'piwik.php']);
_paq.push(['trackPageView']);
_paq.push(['enableLinkTracking']);
var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript'; g.defer=true; g.async=true; g.src=u+'piwik.js';
s.parentNode.insertBefore(g,s); })()
</script>
<noscript><p><img src="{modapifunc modname='Piwik' type='user' func='getBaseUrl'}piwik.php?idsite={$modvars.Piwik.tracking_siteid}" style="border:0" alt="" /></p></noscript>
<!-- End Piwik Tag -->
