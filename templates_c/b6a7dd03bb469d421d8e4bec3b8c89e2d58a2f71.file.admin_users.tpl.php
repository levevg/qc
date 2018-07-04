<?php /* Smarty version Smarty-3.0.5, created on 2018-07-02 16:44:27
         compiled from "/var/www/unseen/qc.unseen.in/templates/admin_users/admin_users.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1456489375b3a2c3b3c5b17-19183142%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b6a7dd03bb469d421d8e4bec3b8c89e2d58a2f71' => 
    array (
      0 => '/var/www/unseen/qc.unseen.in/templates/admin_users/admin_users.tpl',
      1 => 1530537757,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1456489375b3a2c3b3c5b17-19183142',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function__')) include '/var/www/unseen/qc.unseen.in/3rdparty/smarty/plugins/function._.php';
?><?php if ($_smarty_tpl->getVariable('view_mode')->value=='login'){?>
<table style="width:100%; height:100%">
<tr>
    <td style="text-align:center; vertical-align:middle">
        <form action="<?php echo smarty_function__(array('mode'=>'login','view_mode'=>$_smarty_tpl->getVariable('view_mode')->value),$_smarty_tpl);?>
" method="POST">
	        <div class="login">
	            <h2 class="center"><?php echo @SETTINGS_SITE_TITLE;?>
</h2>
	            <?php if ($_smarty_tpl->getVariable('error')->value!=''){?><div class="err center"><?php echo $_smarty_tpl->getVariable('error')->value;?>
</div><?php }?>
	            Логин:<br/>
	            <input type="text" name="login" value="<?php echo hsc($_smarty_tpl->getVariable('login')->value);?>
"/><br/>
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
<?php }?>

<?php if ($_smarty_tpl->getVariable('view_mode')->value=='edit_profile'){?>
<form action="<?php echo smarty_function__(array('mode'=>'save','view_mode'=>$_smarty_tpl->getVariable('view_mode')->value),$_smarty_tpl);?>
" method="POST" class="center">
    <div class="block1">
        <h2 class="mb15">Профиль</h2>
        <?php if ($_smarty_tpl->getVariable('error')->value!=''){?><div class="err mb5"><?php echo $_smarty_tpl->getVariable('error')->value;?>
</div><?php }?>
        <?php if ($_smarty_tpl->getVariable('ok')->value){?><div class="ok">Данные сохранены</div><?php }?>
        <table width="400" class="form">
        <tr>
            <td>Логин:</td>
            <td width="250"><input type="text" name="login" value="<?php echo hsc($_smarty_tpl->getVariable('login')->value);?>
"/></td>
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
<?php }?>