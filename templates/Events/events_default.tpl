{include file='navbar.tpl' active=$active}
<div id="Events">
    <ul id="Events" data-role="listview" data-inset="true">
        {if $events|count eq 0}
            <li>Ei vielä yhtään tapahtumaa...</li>
        {else}
            {foreach key=date item=dayEvents from=$events}
                <li data-role="list-divider">{$date}</li>
                {foreach key=k item=event from=$dayEvents}
                <li>
                    <h1>{$event.Title}</h1>
                    {if !empty($event.Description)}
                    <p class="ui-li-desc" style="white-space:normal;">{$event.Description|nl2br}</p>
                    {/if}
                </li>
                {/foreach}
            {/foreach}
        {/if}
    </ul>
</div>