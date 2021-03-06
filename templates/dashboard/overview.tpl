<table class="z-admintable">
    <thead>
        <tr>
            <th colspan='2'>
                {gt text='Overview'}
                {include file='dashboard/timeperiod.tpl'}
            </th>
        </tr>
    </thead>
    <tbody>
        <tr class="{cycle values='z-odd,z-even'}">
            <td>
                {gt text='Visitors'}:
            </td>
            <td>
                {$data.nb_visits}
            </td>
        </tr>
        <tr class="{cycle values='z-odd,z-even'}">
            <td>
                {gt text='Unique visitors'}:
            </td>
            <td>
                {$data.nb_uniq_visitors}
            </td>
        </tr>
        <tr class="{cycle values='z-odd,z-even'}">
            <td>
                {gt text='Page Views'}:
            </td>
            <td>
                {$data.nb_actions} (&#8960; {$data.nb_actions_per_visit})
            </td>
        </tr>
        <tr class="{cycle values='z-odd,z-even'}">
            <td>
                {gt text='Max. page views in one visit'}:
            </td>
            <td>
                {$data.max_actions}
            </td>
        </tr>
        <tr class="{cycle values='z-odd,z-even'}">
            <td>
                {gt text='Total time spent'}:
            </td>
            <td>
                {$data.total_time}
            </td>
        </tr>
        <tr class="{cycle values='z-odd,z-even'}">
            <td>
                {gt text='Time/visit'}:
            </td>
            <td>
                {$data.average_time}
            </td>
        </tr>
        <tr class="{cycle values='z-odd,z-even'}">
            <td>
                {gt text='Bounce count'}:
            </td>
            <td>
                {$data.bounce_rate}
            </td>
        </tr>
        
    </tbody>
</table>