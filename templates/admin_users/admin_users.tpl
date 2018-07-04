{if $view_mode=='login'}
<table style="width:100%; height:100%">
<tr>
    <td style="text-align:center; vertical-align:middle">
        <form action="{_ mode=login view_mode=$view_mode}" method="POST">
	        <div class="login">
	            <h2 class="center">{$smarty.const.SETTINGS_SITE_TITLE}</h2>
	            {if $error!=''}<div class="err center">{$error}</div>{/if}
	            Логин:<br/>
	            <input type="text" name="login" value="{$login|hsc}"/><br/>
	            Пароль:<br/>
	            <input type="password" name="password" value=""/><br/>
	            <div class="center mt15 mb5"><input type="submit" value="Войти"/></div>
	        </div>
        </form>
    </td>
</tr>
</table>
<script>
$(function(){
	if($('input[name=login]').val()=='') $('input[name=login]').focus();
	else $('input[name=password]').focus(); 
});
</script>
{/if}

{if $view_mode=='edit_profile'}
<form action="{_ mode=save view_mode=$view_mode}" method="POST" class="center">
    <div class="block1">
        <h2 class="mb15">Профиль</h2>
        {if $error!=''}<div class="err mb5">{$error}</div>{/if}
        {if $ok}<div class="ok">Данные сохранены</div>{/if}
        <table width="400" class="form">
        <tr>
            <td>Логин:</td>
            <td width="250"><input type="text" name="login" value="{$login|hsc}"/></td>
        </tr>
        <tr>
            <td>Текущий пароль:</td>
            <td><input type="password" name="old_password" value=""/></td>
        </tr>
        <tr>
            <td>Новый пароль:</td>
            <td><input type="password" name="password" value=""/></td>
        </tr>
        <tr>
            <td>Подтвердите пароль:</td>
            <td><input type="password" name="password2" value=""/></td>
        </tr>        
        </table>
        <div class="center mt15 mb5"><input type="submit" value="Сохранить"/></div>
    </div>
</form>
{/if}