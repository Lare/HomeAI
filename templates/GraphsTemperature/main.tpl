<meta http-equiv="refresh" content="300">
<div id="Graphs">
    <fieldset id="RangeButtons" data-role="controlgroup" data-type="horizontal">
    {foreach from=$ranges key="k" item="range"}
        <input type="radio" name="Range" id="Range_{$range.ID}" value="{$range.ID}" {if $checkedRange == $range.ID}checked="checked" {/if}/>
        <label for="Range_{$range.ID}">{$range.Label}</label>
    {/foreach}
    </fieldset>

    <div id="GraphImages">
    {$imageData}
    </div>
</div>
