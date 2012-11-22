<!DOCTYPE html>
<html lang="en">
<head>
    <title>{$pageTitle}</title>

    <base href="{$BaseHref}" />

    <!-- Meta information -->
    <meta charset="UTF-8">
    <meta name="author" content="Lare" />
    <meta name="robots" content="no-index, no-follow" />
    <meta name="rating" content="General" />

    <!-- CSS definitions -->
{$pageCSS}

    <!-- JS definitions -->
{$pageJS}

    <script type="text/javascript">
        var jq = jQuery.noConflict();
        var systemUrl = '{$BaseHref}';
        var module = '{$Module}';
    </script>

    <!-- Custom head definitions -->
{$pageHead}

</head>

<body>
    <div id="wrapperAjax">
        <div id="contentAjax">
            {if is_array($Messages)}
                {foreach from=$Messages key=key item=message}
                    {$message}
                {/foreach}
            {/if}

            {if is_array($Content)}
                {foreach from=$Content key=key item=content}
                    {$content}
                {/foreach}
            {else}
                {$Content}
            {/if}
            <div style="clear: both;"></div>
        </div>
    </div>

</body>

</html>
