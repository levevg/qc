{inc file="tags_tabs.tpl"}

{if $mode=='ok'}<div class="ok center mb10">Данные сохранены</div>{/if}

<a href="{_ view_mode=edit_attrs}" class="btn fl icon_add">Добавить сокращение</a>

<form action="{$smarty.const.SCRIPT_NAME}" method="GET" id="srch" class="search hidden">
    <input type="text" name="q" value="{$q|hsc}" style="width:300px">
    <input type="hidden" name="_" value="{_s}">
    <a href="#" class="btn2 icon_search" onclick="$('#srch').submit(); return false;">Искать</a>
    {if $q!=''}<a href="{_}" class="btn2 icon_cancel">Отмена</a>{/if}
</form>

<div class="cl mb10"></div>

{include 'paging_admin.tpl'}

<table class="list mb10">
    <tr>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
    </tr>
    {foreach $tags as $tag}
        <tr>
            <td class="min">{$tag.id}</td>
            <td>{$tag.names}</td>
            <td class="min">
                .
            </td>
        </tr>
    {/foreach}
</table>
{if empty($tags)}
    <div class="err center">Ничего не найдено</div>
{/if}

{include 'paging_admin.tpl'}