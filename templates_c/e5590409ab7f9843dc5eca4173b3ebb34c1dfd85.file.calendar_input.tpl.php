<?php /* Smarty version Smarty-3.0.8, created on 2012-11-22 20:47:57
         compiled from "/var/www/tarmo.puhti.com-ssl/mobile/templates/calendar_input.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3888019904f003cae4dce87-28868127%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e5590409ab7f9843dc5eca4173b3ebb34c1dfd85' => 
    array (
      0 => '/var/www/tarmo.puhti.com-ssl/mobile/templates/calendar_input.tpl',
      1 => 1353610016,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3888019904f003cae4dce87-28868127',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
    <input name="ClockDate" id="ClockDate" type="date" data-role="datebox" data-options='{"mode": "calbox", "calStartDay": 1, "pickPageOHighButtonTheme": "b", "highDates": [<?php  $_smarty_tpl->tpl_vars['date'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('Events')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['date']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['date']->iteration=0;
if ($_smarty_tpl->tpl_vars['date']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['date']->key => $_smarty_tpl->tpl_vars['date']->value){
 $_smarty_tpl->tpl_vars['date']->iteration++;
 $_smarty_tpl->tpl_vars['date']->last = $_smarty_tpl->tpl_vars['date']->iteration === $_smarty_tpl->tpl_vars['date']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['events']['last'] = $_smarty_tpl->tpl_vars['date']->last;
?>"<?php echo $_smarty_tpl->tpl_vars['date']->value;?>
"<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['events']['last']){?><?php }else{ ?>,<?php }?><?php }} ?>]}'>