<!DOCTYPE html>
<html>
<head>
    <title>{$pageTitle}</title>
     
    <base href="{$BaseHref}" />

    <!-- Meta information -->
    <meta name="author" content="Lare" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="robots" content="no-index, no-follow" />
    <meta name="rating" content="General" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="refresh" content="86400">

    <!-- CSS definitions -->
{$pageCSS}

    <!-- JS definitions -->
{$pageJS}

    <script type="text/javascript">
        var jq = jQuery.noConflict();
        var systemUrl = '{$BaseHref}';
        var module = '{$Module}';
        {if is_array($pageVar)}
            {foreach from=$pageVar key=key item=js}
                {$js}
            {/foreach}
        {/if}

        {if is_array($pageScript)}
        {literal}
        jq(function(){
        {/literal}
            {foreach from=$pageScript key=key item=script}
        {$script}
            {/foreach}
        {literal}
        });
        {/literal}
        {/if}

    </script>

    <!-- Custom head definitions -->
{$pageHead}

</head>

<body>
    <div id="wrapper" >
        <div id="wrapperInside" data-role="page" data-theme="a">

            <div id="header" data-role="header" data-theme="a">
                <h1 id="Clock">{$date}</h1>
                {$Header}
                {include file='calendar_input.tpl' events='{$Events}'}
            </div>

            <div id="content" data-role="content">
                {if is_array($Content)}
                    {foreach from=$Content key=key item=content}
                        {$content}
                    {/foreach}
                {else}
                    {$Content}
                {/if}
            </div>

            <div class="push"></div>

            <div id="footer" data-role="footer" data-theme="a" data-position="fixed">
                <a href="{$BaseHref}" id="HomeIcon" data-icon="home" data-iconpos="notext" data-ajax="false">Etusivulle</a>
                <div id="SystemInfo">
                    <span>{$SystemName} {$Version}</span>
                </div>
                {$Footer}
            </div>
        </div>
    </div>


    <div style="display: none;">
        <a id="linkEvents" href="" data-rel="dialog">t</a>

    </div>

</body>

</html>
