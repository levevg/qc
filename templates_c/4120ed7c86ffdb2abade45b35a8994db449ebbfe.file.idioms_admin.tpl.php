<?php /* Smarty version Smarty-3.0.5, created on 2018-07-02 16:47:20
         compiled from "/var/www/unseen/qc.unseen.in/templates/idioms/idioms_admin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13079002425b3a2ce8813ef8-29866921%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4120ed7c86ffdb2abade45b35a8994db449ebbfe' => 
    array (
      0 => '/var/www/unseen/qc.unseen.in/templates/idioms/idioms_admin.tpl',
      1 => 1530537757,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13079002425b3a2ce8813ef8-29866921',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_smarty_tpl->getVariable('view_mode')->value=='list_idioms'){?>
    <?php $_template = new Smarty_Internal_Template(('/var/www/unseen/qc.unseen.in/templates/idioms')."/list_idioms_admin.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<?php }?>
<?php if ($_smarty_tpl->getVariable('view_mode')->value=='edit_idioms'){?>
    <?php $_template = new Smarty_Internal_Template(('/var/www/unseen/qc.unseen.in/templates/idioms')."/edit_idioms_admin.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<?php }?>