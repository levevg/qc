<?php /* Smarty version Smarty-3.0.5, created on 2018-07-02 16:47:20
         compiled from "/var/www/unseen/qc.unseen.in/templates/idioms/idioms.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10826515365b3a2ce87ebfc1-99602846%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0f060c71ceb0f4a81f847ae15fcb4720635cd889' => 
    array (
      0 => '/var/www/unseen/qc.unseen.in/templates/idioms/idioms.tpl',
      1 => 1530537757,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10826515365b3a2ce87ebfc1-99602846',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_smarty_tpl->getVariable('action')->value=='admin'){?>
    <?php $_template = new Smarty_Internal_Template(('/var/www/unseen/qc.unseen.in/templates/idioms')."/idioms_admin.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<?php }else{ ?>
    <?php $_template = new Smarty_Internal_Template(('/var/www/unseen/qc.unseen.in/templates/idioms')."/idioms_front.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<?php }?>