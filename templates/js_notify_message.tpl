{foreach from=$data key=k item=i}
    makeMessage{$type}('{$i.Message|escape:javascript}');
{/foreach}