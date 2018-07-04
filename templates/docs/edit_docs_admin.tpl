<link type="text/css" href="/3rdparty/dateselector/ds.css" rel="stylesheet"/>
<script type="text/javascript" src="/3rdparty/dateselector/jquery-ui-1.8.custom.min.js"></script>
<script type="text/javascript" src="/3rdparty/dateselector/jquery.ui.datepicker-ru.js"></script>

<form action="{_ view_mode=$view_mode mode=save id=$id}" method="POST" id="form" enctype="multipart/form-data" style="margin-top:10px">
<a href="{_}{if $id}&unblock_id={$id}{/if}" class="btn icon_back fl">Назад к списку</a>
<h2 class="ttl">{if $id==''}Добавление материала{else}Редактирование материала{/if}</h2>
<div class="cl mb20"></div>

{if $ok}<div class="ok">Данные сохранены</div>{/if}
{if $err}<div class="err">Необходимо заполнить все обязательные поля</div>{/if}

<table class="form">
<tr>
    <td width="130"{if $err_title} class="err"{/if}>Название: *</td>
    <td width="570"><input type="text" name="title" value="{$title|hsc}"/></td>
</tr>
<tr>
    <td width="130"></td>
    <td width="570">
        <label><input type="checkbox" value="1" name="active"{if $active} checked="checked"{/if}> активен (показывается на сайте)</label>
    </td>
</tr>
</table>

<a href="#" onclick="$('#meta').toggleClass('hd'); return false;">Дополнительно &raquo;</a>
<table class="form hd" id="meta">
<tr>
    <td width="130"{if $err_title} class="err"{/if}>Meta title:</td>
    <td width="570"><input type="text" name="meta_title" value="{$meta_title|hsc}"/></td>
</tr>
<tr>
    <td width="130"{if $err_title} class="err"{/if}>Meta keywords:</td>
    <td width="570"><input type="text" name="meta_keywords" value="{$meta_keywords|hsc}"/></td>
</tr>
<tr>
    <td width="130"{if $err_title} class="err"{/if}>Meta desciption:</td>
    <td width="570"><textarea name="meta_description" rows=2 style="width:100%">{$meta_description|hsc}</textarea></td>
</tr>
</table>

<table class="form">
<tr>
    <td width="130"{if $err_text} class="err"{/if}>Полный текст:</td>
    <td width="570"></td>
</tr>
<tr>
    <td colspan="2">
        <textarea name="text" style="width:100%; height:400px">{$text|hsc}</textarea>
        <script>CKEDITOR.replace('text');</script>
        <input type="hidden" name="__uploaded_files" id="__uploaded_files" value=""/>
    </td>
</tr>
<tr>
    <td colspan="2" class="center" style="padding-top:15px">
        <input type="hidden" name="close" id="close" value="0"/>
        <a href="#" onclick="$('#close').val(1); $('#form').submit(); return false;" class="btn icon_save">Сохранить и закрыть</a>
        <a href="#" onclick="$('#close').val(0); $('#form').submit(); return false;" class="btn icon_save">Сохранить</a>
        <a href="{_}{if $id}&unblock_id={$id}{/if}" class="btn icon_cancel">Отмена</a>
    </td>
</tr>
</table>
</form>

{literal}
<script>
$(document).ready(function(){
    $.datepicker.setDefaults($.datepicker.regional['ru']);
    $('.dateselector').datepicker({constrainInput:true, showAnim:''});
});
</script>
{/literal}