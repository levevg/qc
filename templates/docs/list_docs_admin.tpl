<a href="{_ view_mode=edit_docs}" class="btn fl icon_add">Новый материал</a>
<h2 class="ttl">Материалы</h2>
<div class="cl mb20"></div>

{if $mode=='ok'}<div class="ok mb10">Данные сохранены</div>{/if}

<form action="{$smarty.const.SCRIPT_NAME}" method="GET" id="srch" class="search">
<input type="text" name="q" value="{$q|hsc}" style="width:300px">
<input type="hidden" name="_" value="{_s}">
<a href="#" class="btn2 icon_search" onclick="$('#srch').submit(); return false;">Искать</a>
{if $q!=''}<a href="{_}" class="btn2 icon_cancel">Отмена</a>{/if}
</form>

{include 'paging_admin.tpl'}

<table class="list mb10">
<tr>
    <th title="Активно?">&nbsp;</th>
    <th>id</th>
    <th>Заголовок</th>
    <th>&nbsp;</th>
</tr>
{foreach $result as $rec}
<tr>
    <td class="min icon_{if !$rec.active}in{/if}active"><div title="{if $rec.active}Активен{else}НЕактивен{/if}"></div></td>
    <td class="min">{$rec.id}</td>
    <td{if $rec.blocked} class="lock" title="Материал открыт пользователем {$rec.redactor} {$rec.opened_time}"{/if}><div class="ico"></div>
        <a {if $rec.blocked && $rec.redactor_id!=$smarty.const.ADMIN_ID} onclick="if(confirm('Материал был открыт пользователем {$rec.redactor} {$rec.opened_time} и не закрыт. Возможно, материал в данный момент редактируется. Совместное редактирование может привести к потере информации и проклятию. Действительно открыть редактирование?')){ this.href='{_ view_mode=edit_docs id=$rec.id}'; return true; } else return false;"{else}href="{_ view_mode=edit_docs id=$rec.id}"{/if}>{$rec.title}</a>
    </td>
    <td class="min">
        <a {if $rec.blocked && $rec.redactor_id!=$smarty.const.ADMIN_ID} onclick="if(confirm('Материал был открыт пользователем {$rec.redactor} {$rec.opened_time} и не закрыт. Возможно, материал в данный момент редактируется. Совместное редактирование может привести к потере информации и проклятию. Действительно открыть редактирование?')){ this.href='{_ view_mode=edit_docs id=$rec.id}'; return true; } else return false;"{else}href="{_ view_mode=edit_docs id=$rec.id}"{/if} class="btn icon_edit">Редактировать</a>
        <a href="{_ view_mode=delete_docs id=$rec.id}" class="btn icon_delete" onclick="return confirm('Вы действительно хотите удалить материал?');">Удалить</a>
    </td>
</tr>
{/foreach}
</table>
{if empty($result)}
<div class="err center">Материалы не найдены</div>
{/if}

{include 'paging_admin.tpl'}