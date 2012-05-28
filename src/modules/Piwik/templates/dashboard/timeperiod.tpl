{if $period == 'day'}
    ({$date|dateformat})
{elseif $period == 'week'}
    ({gt text='Week'} {$date|dateformat:'%V, %Y'})
{elseif $period == 'month'}
    ({$date|dateformat:'%B %Y'})
{elseif $period == 'year'}
    ({$date|dateformat:'%Y'})
{/if}