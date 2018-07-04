<?php /* Smarty version Smarty-3.0.5, created on 2018-07-02 16:44:27
         compiled from "/var/www/unseen/qc.unseen.in/templates/admin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6653068385b3a2c3b3733a5-64083796%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5036fe354462b252613de8a1009e8bd0b23f8760' => 
    array (
      0 => '/var/www/unseen/qc.unseen.in/templates/admin.tpl',
      1 => 1530537757,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6653068385b3a2c3b3733a5-64083796',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_global')) include '/var/www/unseen/qc.unseen.in/3rdparty/smarty/plugins/function.global.php';
if (!is_callable('smarty_function_module')) include '/var/www/unseen/qc.unseen.in/3rdparty/smarty/plugins/function.module.php';
if (!is_callable('smarty_function__')) include '/var/www/unseen/qc.unseen.in/3rdparty/smarty/plugins/function._.php';
?><!DOCTYPE html>
<html>
<head>
    <title><?php echo smarty_function_global(array('var'=>'page_title'),$_smarty_tpl);?>
</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="/favicon.ico" />
    <link href="/combine.php?files=admin.css,js%2Ffancybox%2Ffancybox.css,css%2Fjquery-ui.min.css,css%2Fjquery-ui.structure.min.css,css%2Fjquery-ui.theme.min.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="/favicon.ico" type="image/vnd.microsoft.icon" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/vnd.microsoft.icon" />
    <script type="text/javascript" src="/combine.php?files=js%2Fjquery.js,js%2Fjquery-ui.min.js,js%2Fscripts_admin.js,js%2Ffancybox%2Ffancybox.js,js%2Ffancybox%2Fmw.js,js%2Fjquery.dragsort.js"></script>
    <script type="text/javascript" src="/3rdparty/ckeditor/ckeditor.js"></script>
</head>
<body><?php if (@ADMIN_ID==0){?><?php echo smarty_function_module(array('name'=>'admin_users','view_mode'=>'login'),$_smarty_tpl);?>
<?php }else{ ?>
<script>var ckeUploadPath = '<?php echo smarty_function_global(array('var'=>'upload_path'),$_smarty_tpl);?>
';</script>
<table style="width:100%; height:100%;">
<tr style="height:29px">
    <td colspan="2" class="topbar">
        <span class="fr">Привет, <b><?php echo $_smarty_tpl->getVariable('me')->value['login'];?>
</b></span>
        <h2><?php echo @SETTINGS_SITE_TITLE;?>
</h2>
    </td>
</tr>
<tr>
    <td class="leftpane">
        <?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('modules')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value){
?>
        <a href="<?php echo smarty_function__(array('action'=>$_smarty_tpl->tpl_vars['module']->value['name'],'tab'=>$_smarty_tpl->tpl_vars['module']->value['name']),$_smarty_tpl);?>
"<?php if ($_smarty_tpl->getVariable('tab')->value==$_smarty_tpl->tpl_vars['module']->value['name']){?> class="act"<?php }?>><?php echo $_smarty_tpl->tpl_vars['module']->value['title'];?>
</a>
        <?php }} ?>
        <span></span>
        <a href="/" target="_blank"><b>Открыть сайт</b></a>
        <a href="<?php echo smarty_function__(array('action'=>'admin_users','admin_users__dot__view_mode'=>'edit_profile','tab'=>'profile'),$_smarty_tpl);?>
" <?php if ($_smarty_tpl->getVariable('tab')->value=='profile'){?>class="act"<?php }?>>Профиль</a>
        <a href="<?php echo smarty_function__(array('action'=>'admin_users','admin_users__dot__mode'=>'logout'),$_smarty_tpl);?>
">Выход</a>
        
        <div class="mt20 hd" style="padding:0 10px">
            <div class="mb5">Пользователи за последние 5 минут:</div>
            <b>
            <?php  $_smarty_tpl->tpl_vars['u'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('here')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['u']->key => $_smarty_tpl->tpl_vars['u']->value){
?>
            <?php echo $_smarty_tpl->tpl_vars['u']->value['login'];?>
<br/>
            <?php }} ?>
            </b>
        </div>
    </td>
    <td class="rightpane<?php if ($_smarty_tpl->getVariable('action')->value!='admin_users'&&$_smarty_tpl->getVariable('action')->value!='settings'){?> valign_top<?php }?>">
        <?php if ($_smarty_tpl->getVariable('action')->value!=''){?>
            <?php echo smarty_function_module(array('name'=>$_smarty_tpl->getVariable('action')->value,'action'=>'admin'),$_smarty_tpl);?>

        <?php }else{ ?><div style="width:400px"></div><?php }?>
    </td>
</tr>
</table>

<?php }?>
</body>
</html>