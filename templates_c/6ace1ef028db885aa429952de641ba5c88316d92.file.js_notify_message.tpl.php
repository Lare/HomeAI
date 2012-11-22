<?php /* Smarty version Smarty-3.0.8, created on 2011-11-22 19:01:35
         compiled from "/var/www/tarmo.puhti.com-ssl/mobile/templates/js_notify_message.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21187504534ecbd56fa87432-13755016%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6ace1ef028db885aa429952de641ba5c88316d92' => 
    array (
      0 => '/var/www/tarmo.puhti.com-ssl/mobile/templates/js_notify_message.tpl',
      1 => 1321980772,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21187504534ecbd56fa87432-13755016',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/var/www/tarmo.puhti.com-ssl/mobile/libs/smarty/plugins/modifier.escape.php';
?><?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['i']->key;
?>
    makeMessage<?php echo $_smarty_tpl->getVariable('type')->value;?>
('<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['i']->value['Message'],'javascript');?>
');
<?php }} ?>