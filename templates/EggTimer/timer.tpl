<div id="Timer">

    <div data-role="fieldcontain">
        <label for="TimerDuration">Valitse aika:</label>
        <input name="TimerDuration" id="TimerDuration" type="date" data-role="datebox" data-options='{literal}{{/literal}"mode": "durationbox", "durationNoDays": 1{literal}}{/literal}'>
    </div>

    <div data-role="fieldcontain">
        <input type="button" id="StartTimer" value="Käynnistä kello" />
    </div>

    <div id="EggTimer"></div>

    <div style="display: block;">
        <audio id="AlarmSound" preload="auto" controls="controls" loop="loop">
            <source src="{$baseUrl}sounds/alarm.mp3" type="audio/mpeg" />
            <source src="{$baseUrl}sounds/alarm.ogg" type="audio/ogg" />
        </audio>
    </div>
</div>
