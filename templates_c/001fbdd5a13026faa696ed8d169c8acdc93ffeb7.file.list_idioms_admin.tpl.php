<?php /* Smarty version Smarty-3.0.5, created on 2018-07-02 16:47:20
         compiled from "/var/www/unseen/qc.unseen.in/templates/idioms/list_idioms_admin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16775507945b3a2ce881a688-76603624%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '001fbdd5a13026faa696ed8d169c8acdc93ffeb7' => 
    array (
      0 => '/var/www/unseen/qc.unseen.in/templates/idioms/list_idioms_admin.tpl',
      1 => 1530537757,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16775507945b3a2ce881a688-76603624',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function__')) include '/var/www/unseen/qc.unseen.in/3rdparty/smarty/plugins/function._.php';
if (!is_callable('smarty_function__s')) include '/var/www/unseen/qc.unseen.in/3rdparty/smarty/plugins/function._s.php';
?><?php if ($_smarty_tpl->getVariable('mode')->value=='ok'){?><div class="ok center mb10">Данные сохранены</div><?php }?>

<a href="<?php echo smarty_function__(array('view_mode'=>'edit_idioms'),$_smarty_tpl);?>
" class="btn fl icon_add">Добавить фразеологизм</a>

<form action="<?php echo @SCRIPT_NAME;?>
" method="GET" id="srch" class="search">
    <input type="text" name="q" value="<?php echo hsc($_smarty_tpl->getVariable('q')->value);?>
" style="width:300px">
    <input type="hidden" name="_" value="<?php echo smarty_function__s(array(),$_smarty_tpl);?>
">
    <a href="#" class="btn2 icon_search" onclick="$('#srch').submit(); return false;">Искать</a>
    <?php if ($_smarty_tpl->getVariable('q')->value!=''){?><a href="<?php echo smarty_function__(array(),$_smarty_tpl);?>
" class="btn2 icon_cancel">Отмена</a><?php }?>
</form>

<div class="cl mb10"></div>

<?php $_template = new Smarty_Internal_Template('paging_admin.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

<table class="list mb10">
    <tr>
        <th><a href="<?php echo smarty_function__(array(),$_smarty_tpl);?>
&sortby=language&sortdir=<?php echo $_smarty_tpl->getVariable('sortdirinv')->value;?>
">Язык<?php if ($_smarty_tpl->getVariable('sortby')->value=='language'){?>&nbsp;<?php if ($_smarty_tpl->getVariable('sortdir')->value=='ASC'){?>&uarr;<?php }else{ ?>&darr;<?php }?><?php }?></a></th>
        <th><a href="<?php echo smarty_function__(array(),$_smarty_tpl);?>
&sortby=generator&sortdir=<?php echo $_smarty_tpl->getVariable('sortdirinv')->value;?>
">Фразеологизм<?php if ($_smarty_tpl->getVariable('sortby')->value=='generator'){?>&nbsp;<?php if ($_smarty_tpl->getVariable('sortdir')->value=='ASC'){?>&uarr;<?php }else{ ?>&darr;<?php }?><?php }?></a></th>
        <th><a href="<?php echo smarty_function__(array(),$_smarty_tpl);?>
&sortby=definition&sortdir=<?php echo $_smarty_tpl->getVariable('sortdirinv')->value;?>
">Определение<?php if ($_smarty_tpl->getVariable('sortby')->value=='definition'){?>&nbsp;<?php if ($_smarty_tpl->getVariable('sortdir')->value=='ASC'){?>&uarr;<?php }else{ ?>&darr;<?php }?><?php }?></a></th>
        <th>&nbsp;</th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['idiom'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('idioms')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['idiom']->key => $_smarty_tpl->tpl_vars['idiom']->value){
?>
        <tr>
            <td class="min center"><?php echo $_smarty_tpl->tpl_vars['idiom']->value['language'];?>
</td>
            <td class="min"><a href="<?php echo smarty_function__(array('view_mode'=>'edit_idioms','id'=>$_smarty_tpl->tpl_vars['idiom']->value['id']),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['idiom']->value['generator'];?>
</a></td>
            <td><?php echo $_smarty_tpl->tpl_vars['idiom']->value['definition'];?>
</td>
            <td class="min">
                <a href="<?php echo smarty_function__(array('view_mode'=>'edit_idioms','id'=>$_smarty_tpl->tpl_vars['idiom']->value['id']),$_smarty_tpl);?>
" class="icon_edit">Редактировать</a>
                <a href="<?php echo smarty_function__(array('view_mode'=>'delete_idioms','id'=>$_smarty_tpl->tpl_vars['idiom']->value['id']),$_smarty_tpl);?>
" class="icon_delete">Удалить</a>
            </td>
        </tr>
    <?php }} ?>
</table>
<?php if (empty($_smarty_tpl->getVariable('idioms')->value)){?>
    <div class="err center">Ничего не найдено</div>
<?php }?>

<?php $_template = new Smarty_Internal_Template('paging_admin.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>