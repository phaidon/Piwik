{pageaddvar name="javascript" value="jquery"}
{pageaddvar name="stylesheet" value="modules/Piwik/javascript/jqplot/jquery.jqplot.min.css"}
{pageaddvar name="javascript" value="modules/Piwik/javascript/jqplot/jquery.jqplot.min.js"}
{pageaddvar name="javascript" value="modules/Piwik/javascript/jqplot/plugins/jqplot.trendline.min.js"}

<table class="z-admintable">
    <thead>
        <tr>
            <th colspan=4>
                {if $period == 'day'}
                    {gt text='Visits in the last %s days' tag1=30}
                {elseif $period == 'week'}
                    {gt text='Visits in the last %s weeks' tag1=12}
                {elseif $period == 'month'}
                    {gt text='Visits in the last %s months' tag1=12}
                {elseif $period == 'year'}
                     {gt text='Visits in the last %s years' tag1=5}
                {/if}
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td align=center colspan=4>
                <div id="piwikVistorsGraph" style="height:220px;width:490px"></div>
            </td>
        </tr>
    </tbody>
    <thead>
        <tr>
            <th>{gt text='Date'}</th>
            <th>{gt text='Visits'}</th>
            <th>{gt text='Unique'}</th>
            <th>{gt text='Bounced'}</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$Visitors key='strDate' item='intValue'}
        <tr class="{cycle values='z-odd,z-even'}">
            <td>{$strDate}</td>
            <td>{$intValue}</td>
            <td>{$Unique.$strDate}</td>
            <td>{$Bounced.$strDate}</td>
        </tr>
        {/foreach}
        <tr class="{cycle values='z-odd,z-even'}">
            <td colspan="4">
                <strong>{gt text='Unique TOTAL'}</strong> {gt text='Sum'}: {$intUSum} {gt text='Avg'}: {$intAvg}
            </td>
        </tr>
    </tbody>
</table>



<script type="text/javascript">
   var $j = jQuery.noConflict();
   $j.jqplot('piwikVistorsGraph', [[{{$strValues}}],[{{$strValuesU}}],[{{$strBounced}}]],
        {
            axes:{
                yaxis:{
                    min:0,
                    tickOptions:{
                        formatString:'%.0f'
                    }
                },
                xaxis:{
                    min:1,
                    max:30,
                    ticks:[{{$strLabels}}]
                }
            },
            seriesDefaults:{
                showMarker:false,
                lineWidth:1,
                fill:true,
                fillAndStroke:true,
                fillAlpha:0.9,
                trendline:{
                    show:false,
                    color:'#C00',
                    lineWidth:1.5,
                    type:'exp'
                }
            },
            series:[
                {
                    color:'#90AAD9',
                    fillColor:'#D4E2ED'
                },
                {
                    color:'#A3BCEA',
                    fillColor:'#E4F2FD',
                    trendline:{
                        show:true,
                        label:'Unique visitor trend'
                    }
                },
                {
                    color:'#E9A0BA',
                    fillColor:'#FDE4F2'
                }
            ],
        });
</script>