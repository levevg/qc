<?php /* Smarty version Smarty-3.0.5, created on 2018-07-02 16:48:51
         compiled from "/var/www/unseen/qc.unseen.in/templates/settings/settings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18558047565b3a2d4347dae0-10596331%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0c69cb3360c8d3c2ec13a498bead26de41496a15' => 
    array (
      0 => '/var/www/unseen/qc.unseen.in/templates/settings/settings.tpl',
      1 => 1530537757,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18558047565b3a2d4347dae0-10596331',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function__')) include '/var/www/unseen/qc.unseen.in/3rdparty/smarty/plugins/function._.php';
?><form action="<?php echo smarty_function__(array('mode'=>'save','view_mode'=>$_smarty_tpl->getVariable('view_mode')->value,'id'=>$_smarty_tpl->getVariable('id')->value),$_smarty_tpl);?>
" method="POST" class="center" style="margin: 50px 0">
    <div class="block1">
        <h2 class="mb10">Настройки</h2>
        <?php if ($_smarty_tpl->getVariable('ok')->value){?><div class="ok mb5">Данные сохранены</div><?php }?>
        <?php if ($_smarty_tpl->getVariable('error')->value!=''){?><div class="err mb5"><?php echo $_smarty_tpl->getVariable('error')->value;?>
</div><?php }?>
        <?php if ($_smarty_tpl->getVariable('err')->value){?><div class="err mb5">Проверьте указанные поля:</div><?php }?>
        <table width="500" class="form">
        <?php  $_smarty_tpl->tpl_vars['s'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('settings')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['s']->key => $_smarty_tpl->tpl_vars['s']->value){
?>
        <tr>
            <td<?php if ($_smarty_tpl->tpl_vars['s']->value['err']){?> class="err"<?php }?>><?php echo $_smarty_tpl->tpl_vars['s']->value['title'];?>
:</td>
            <td width="250">
                <?php if ($_smarty_tpl->tpl_vars['s']->value['type']=='text'){?>
                <input type="text" name="<?php echo $_smarty_tpl->tpl_vars['s']->value['name'];?>
" value="<?php echo hsc($_smarty_tpl->tpl_vars['s']->value['value']);?>
"/>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['s']->value['type']=='int'){?>
                <input type="text" name="<?php echo $_smarty_tpl->tpl_vars['s']->value['name'];?>
" value="<?php echo hsc($_smarty_tpl->tpl_vars['s']->value['value']);?>
" style="width:60px;text-align:right"/>
                <?php }?>                
            </td>
        </tr>
        <?php }} ?>
        </table>
        <div class="center mt15 mb5"><input type="submit" value="Сохранить"/></div>
    </div>
</form>