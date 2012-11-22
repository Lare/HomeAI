<div id="EventsAjax">
    <ul data-role="listview">
        {if $events|count eq 0}
            <li>Päivällä ei vielä tapahtumia...</li>
        {else}
            {foreach key=k item=event from=$events}
                <li>
                    <h1>{$event.Title}</h1>
                    {if !empty($event.Description)}
                    <p class="ui-li-desc" style="white-space:normal;">{$event.Description|nl2br}</p>
                    {/if}
                </li>
            {/foreach}
        {/if}
        <li data-role="list-divider">Lisää uusi tapahtuma päivälle</li>
        <li>
            <form id="EventForm" name="EventForm" action="" method="post">
                <div data-role="fieldcontain">
                    <label for="EventFormTitle">Otsikko:</label>
                    <input id="EventFormTitle" name="EventFormTitle" type="text" />
                </div>
                <div data-role="fieldcontain">
                    <label for="EventFormDescription">Kuvaus:</label>
                    <textarea id="EventFormDescription" name="EventFormDescription"></textarea>
                </div>
                <div data-role="fieldcontain">
                    <input type="button" id="EventFormSubmit" data-date="{$date}" value="Lisää tapahtuma" />
                </div>
            </form>
        </li>
    </ul>
</div>

