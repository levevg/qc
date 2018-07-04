{if $action=='admin'}
    {inc file="docs_admin.tpl"}
{else}
    {inc file="docs_front.tpl"}
{/if}