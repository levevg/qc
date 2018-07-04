<form action="{_ view_mode=$view_mode mode=save id=$id}" method="POST" id="form" enctype="multipart/form-data" style="margin-top:10px">
<a href="{_}" class="btn icon_back fl">Назад</a>
<h2 class="ttl">{if $id==''}Добавление страницы{else}Редактирование страницы{/if}</h2>
<div class="cl mb20"></div>

{if $ok}<div class="ok">Данные сохранены</div>{/if}
{if $err}<div class="err">Необходимо заполнить все обязательные поля</div>{/if}

<table class="form">
<tr>
    <td{if $err_link} class="err"{/if}>Ссылка (regexp):</td>
    <td><input type="text" name="link" value="{$link|hsc}" style="width:500px"/></td>
</tr>
<tr>
    <td{if $err_params} class="err"{/if}>Параметры:</td>
    <td><input type="text" name="params" value="{$params|hsc}" style="width:500px"/></td>
</tr>
<tr>
    <td{if $err_parent_id} class="err"{/if}>Родительская страница:</td>
    <td><select style="width:250px;" name="parent_id">
            <option value="0">нет</option>
            {foreach $pages as $page}
            <option value="{$page.id}"{if $page.id==$parent_id} selected="selected"{/if}>{$page.link}</option>
            {/foreach}
        </select>
    </td>
</tr>
<tr>
    <td></td>
    <td></td>
</tr>
<tr>
    <td colspan="2" class="center" style="padding-top:15px">
        <a href="#" onclick="$('#form').submit(); return false;" class="btn icon_save">Сохранить</a>
        <a href="{_}" class="btn icon_cancel">Отмена</a>
    </td>
</tr>
</table>

</form>