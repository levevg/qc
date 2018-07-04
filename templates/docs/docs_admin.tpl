{if $view_mode=='' || $view_mode=='list_docs'}
    {inc file="list_docs_admin.tpl"}
{/if}

{if $view_mode=='edit_docs'}
    {inc file="edit_docs_admin.tpl"}
{/if}