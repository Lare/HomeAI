{foreach from=$data key=stylesheet item=media}
    <link rel="stylesheet" href="{$baseUrl}css/{$stylesheet}" type="text/css" media="{$media}" />
{/foreach}