<div id="Left">
    <div id="ControlBox">
        {$controls}
    </div>
</div>

<div id="Right">
    <div id="TemperatureBox">
        <ul data-role="listview" data-inset="true">
            <li data-role="list-divider"><div id="TemperatureImage"></div>Lämpötilat</li>
            <li><div id="Temperature">{$temperature}</div></li>
        </ul>
    </div>

    <div id="ActionBox">
        <ul id="Actions" data-role="listview" data-inset="true">
            <li data-role="list-divider"><div id="ActionImage"></div>Toiminnot</li>
            {foreach from=$controls key="k" item="control"}
                {foreach from=$actions key="k" item="action"}
                    <li><a href="{$action.URL}" data-ajax="false">{$action.Title}</a></li>
                {/foreach}
            {/foreach}
        </ul>
    </div>
</div>
