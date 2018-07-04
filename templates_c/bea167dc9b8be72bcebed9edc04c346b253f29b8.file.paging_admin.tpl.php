<?php /* Smarty version Smarty-3.0.5, created on 2018-07-02 16:47:20
         compiled from "/var/www/unseen/qc.unseen.in/templates/paging_admin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2878209935b3a2ce883d2f4-50471976%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bea167dc9b8be72bcebed9edc04c346b253f29b8' => 
    array (
      0 => '/var/www/unseen/qc.unseen.in/templates/paging_admin.tpl',
      1 => 1530537757,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2878209935b3a2ce883d2f4-50471976',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function__')) include '/var/www/unseen/qc.unseen.in/3rdparty/smarty/plugins/function._.php';
?><?php if ($_smarty_tpl->getVariable('paging')->value){?>
<div class="paging">
<b>Страницы:</b>
<?php if ($_smarty_tpl->getVariable('first_page')->value){?><a href="<?php echo smarty_function__(array(),$_smarty_tpl);?>
&pg=<?php echo $_smarty_tpl->getVariable('first_page')->value;?>
<?php echo $_smarty_tpl->getVariable('paging_params')->value;?>
" title="Первая">&lt;&lt;</a><?php }?>
<?php if ($_smarty_tpl->getVariable('prev_page')->value){?><a href="<?php echo smarty_function__(array(),$_smarty_tpl);?>
&pg=<?php echo $_smarty_tpl->getVariable('prev_page')->value;?>
<?php echo $_smarty_tpl->getVariable('paging_params')->value;?>
" title="Предыдущая">&lt;</a><?php }?>
<?php  $_smarty_tpl->tpl_vars['page'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('pages')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['page']->key => $_smarty_tpl->tpl_vars['page']->value){
?><a href="<?php echo smarty_function__(array(),$_smarty_tpl);?>
&pg=<?php echo $_smarty_tpl->tpl_vars['page']->value['page'];?>
<?php echo $_smarty_tpl->getVariable('paging_params')->value;?>
"<?php if ($_smarty_tpl->tpl_vars['page']->value['current']){?> class="act"<?php }?>><?php echo $_smarty_tpl->tpl_vars['page']->value['page'];?>
</a><?php }} ?>
<?php if ($_smarty_tpl->getVariable('next_page')->value){?><a href="<?php echo smarty_function__(array(),$_smarty_tpl);?>
&pg=<?php echo $_smarty_tpl->getVariable('next_page')->value;?>
<?php echo $_smarty_tpl->getVariable('paging_params')->value;?>
" title="Следующая">&gt;</a><?php }?>
<?php if ($_smarty_tpl->getVariable('last_page')->value){?><a href="<?php echo smarty_function__(array(),$_smarty_tpl);?>
&pg=<?php echo $_smarty_tpl->getVariable('last_page')->value;?>
<?php echo $_smarty_tpl->getVariable('paging_params')->value;?>
" title="Последняя">&gt;&gt;</a><?php }?>
</div>

<?php }?>