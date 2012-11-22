
<ul id="Controls" data-role="listview" data-inset="true">
    <li data-role="list-divider"><div id="ControlsImage"></div>Ohjaukset</li>
    {foreach from=$controls key="k" item="control"}
        <li>
            <input type="checkbox" class="iPhoneSwitch" id="Control_{$control.ID}" value="1" data-id="{$control.ID}" data-bit="{$control.Key}" {if $control.Status == 1} checked="checked"{/if}" />
            {$control.Name}
            <div syle="clear: both;"></div>
        </li>
    {/foreach}
</ul>