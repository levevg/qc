{if $view_mode=='' || $view_mode=='list_structure'}
    {inc file="list_structure_admin.tpl"}
{/if}

{if $view_mode=='edit_structure'}
    {inc file="edit_structure.tpl"}
{/if}