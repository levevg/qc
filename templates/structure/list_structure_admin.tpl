<a href="{_ view_mode=edit_structure}" class="btn fl icon_add">Добавить страницу</a>
<h2 class="ttl">Структура</h2>
<div class="cl mb20"></div>

{if $mode=='ok'}<div class="ok mb10">Данные сохранены</div>{/if}

<table class="list mb10 list_compact">
<tr>
    <th>&nbsp;</th>
    <th>URL (regexp)</th>
    <th>Параметры</th>
    <th>&nbsp;</th>
</tr>
{foreach $result as $rec}
<tr>
    <td class="min">&nbsp;</td>
    <td style="padding-left:{$rec.level*30+5}px">{$rec.link}</td>
    <td>{$rec.params}</td>
    <td class="min">
        <a href="{_ view_mode=edit_structure id=$rec.id}" class="btn icon_edit">Редактировать</a>
    </td>
</tr>
{/foreach}
</table>
