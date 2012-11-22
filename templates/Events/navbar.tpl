<div data-role="navbar">
    <ul>
        <li><a href="{$baseUrl}?Module=Events&Action=Default&NoAjax=1" {if $active == 'future'}class="ui-btn-active"{/if}>Tulevat tapahtumat</a></li>
        <li><a href="{$baseUrl}?Module=Events&Action=ShowPast" {if $active == 'past'}class="ui-btn-active"{/if}>Menneet tapahtumat</a></li>
        <li><a href="{$baseUrl}?Module=Events&Action=AddNew" {if $active == 'new'}class="ui-btn-active"{/if}>Lisää uusi</a></li>
    </ul>
</div>