{if $mode=='ok'}<div class="ok center mb10">Данные сохранены</div>{/if}

<a href="{_ view_mode=edit_idioms}" class="btn fl icon_add">Добавить фразеологизм</a>

<form action="{$smarty.const.SCRIPT_NAME}" method="GET" id="srch" class="search">
    <input type="text" name="q" value="{$q|hsc}" style="width:300px">
    <input type="hidden" name="_" value="{_s}">
    <a href="#" class="btn2 icon_search" onclick="$('#srch').submit(); return false;">Искать</a>
    {if $q!=''}<a href="{_}" class="btn2 icon_cancel">Отмена</a>{/if}
</form>

<div class="cl mb10"></div>

{include 'paging_admin.tpl'}

<table class="list mb10">
    <tr>
        <th><a href="{_}&sortby=language&sortdir={$sortdirinv}">Язык{if $sortby=='language'}&nbsp;{if $sortdir=='ASC'}&uarr;{else}&darr;{/if}{/if}</a></th>
        <th><a href="{_}&sortby=generator&sortdir={$sortdirinv}">Фразеологизм{if $sortby=='generator'}&nbsp;{if $sortdir=='ASC'}&uarr;{else}&darr;{/if}{/if}</a></th>
        <th><a href="{_}&sortby=definition&sortdir={$sortdirinv}">Определение{if $sortby=='definition'}&nbsp;{if $sortdir=='ASC'}&uarr;{else}&darr;{/if}{/if}</a></th>
        <th>&nbsp;</th>
    </tr>
    {foreach $idioms as $idiom}
        <tr>
            <td class="min center">{$idiom.language}</td>
            <td class="min"><a href="{_ view_mode=edit_idioms id=$idiom.id}">{$idiom.generator}</a></td>
            <td>{$idiom.definition}</td>
            <td class="min">
                <a href="{_ view_mode=edit_idioms id=$idiom.id}" class="icon_edit">Редактировать</a>
                <a href="{_ view_mode=delete_idioms id=$idiom.id}" class="icon_delete">Удалить</a>
            </td>
        </tr>
    {/foreach}
</table>
{if empty($idioms)}
    <div class="err center">Ничего не найдено</div>
{/if}

{include 'paging_admin.tpl'}