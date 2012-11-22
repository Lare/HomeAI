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
            <div data-role="header" data-theme="b">
                <h1>{$pageTitle}</h1>
            </div>

            <div data-role="content">
                {if is_array($Content)}
                    {foreach from=$Content key=key item=content}
                        {$content}
                    {/foreach}
                {else}
                    {$Content}
                {/if}
            </div>

        </div>
    </div>
</body>

</html>
