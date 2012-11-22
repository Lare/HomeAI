{include file='navbar.tpl' active=$active}

<form id="EventForm" name="EventForm" action="{$baseUrl}" method="post" data-ajax="false">
    <input type="hidden" name="Module" value="Events" />
    <input type="hidden" name="Action" value="SaveEvent" />
    <div data-role="fieldcontain" class="row">
        <label for="Title">Otsikko:</label>
        <input id="Title" name="Title" type="text" />
        <div class="message"><div class="spacer"></div></div>
    </div>
    <div data-role="fieldcontain" class="row">
        <label for="Date">Päivämäärä:</label>
        <input name="Date" id="Date" type="date" data-role="datebox" data-options='{literal}{{/literal}"mode": "calbox", "calStartDay": 1{literal}}{/literal}'>
        <div class="message"><div class="spacer"></div></div>
    </div>
    <div data-role="fieldcontain">
        <label for="Description">Kuvaus:</label>
        <textarea id="Description" name="Description"></textarea>
    </div>
    <div data-role="fieldcontain">
        <input type="submit" value="Lisää tapahtuma" />
    </div>
</form>