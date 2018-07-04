<form action="{_ mode=save view_mode=$view_mode id=$id}" method="POST" class="center" style="margin: 50px 0">
    <div class="block1">
        <h2 class="mb10">Настройки</h2>
        {if $ok}<div class="ok mb5">Данные сохранены</div>{/if}
        {if $error!=''}<div class="err mb5">{$error}</div>{/if}
        {if $err}<div class="err mb5">Проверьте указанные поля:</div>{/if}
        <table width="500" class="form">
        {foreach $settings as $s}
        <tr>
            <td{if $s.err} class="err"{/if}>{$s.title}:</td>
            <td width="250">
                {if $s.type=='text'}
                <input type="text" name="{$s.name}" value="{$s.value|hsc}"/>
                {/if}
                {if $s.type=='int'}
                <input type="text" name="{$s.name}" value="{$s.value|hsc}" style="width:60px;text-align:right"/>
                {/if}                
            </td>
        </tr>
        {/foreach}
        </table>
        <div class="center mt15 mb5"><input type="submit" value="Сохранить"/></div>
    </div>
</form>