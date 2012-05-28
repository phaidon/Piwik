<table class="z-admintable">
    <thead>
        <tr>
            <th colspan=3>
                {gt text='Visited pages'}
                {include file='dashboard/timeperiod.tpl'}
            </th>
        </tr>
        <tr>
            <th>
                {gt text='Title'}
            </th>
            <th>
                {gt text='Unique'}
            </th>
            <th>
                {gt text='Visits'}
            </th>
        </tr>
    </thead>
    <tbody>
        {* Display 9 most popular pages*}
        {assign var='u' value=0}
        {assign var='v' value=0}
        {foreach from=$data item='d'}
           {counter assign='i'}
           {if $i <= 9}
                <tr class="{cycle values='z-odd,z-even'}">
                    <td>
                        {$d.label}
                    </td>
                    <td>
                        {$d.sum_daily_nb_uniq_visitors}
                    </td>
                    <td>
                        {$d.nb_visits}
                    </td>
                </tr>
            {else}
                {assign var='u' value=$u+$d.sum_daily_nb_uniq_visitors}
				{assign var='v' value=$v+$d.nb_visits}
            {/if}

        {foreachelse}
            <tr class="{cycle values='z-odd,z-even'}">
                <td colspan='3'>
                    {gt text='No data available.'}
                </td>
            </tr>   
        {/foreach}
        
        {* Display other pages*}
        {if $v > 0}
            <tr class="{cycle values='z-odd,z-even'}">
                <td>
                    {gt text='Others'}
                </td>
                <td>
                    {$u}
                </td>
                <td>
                    {$v}
                </td>
            </tr>   
        {/if}
    
        
    </tbody>
</table>