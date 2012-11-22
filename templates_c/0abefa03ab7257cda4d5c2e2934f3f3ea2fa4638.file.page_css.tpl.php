<?php /* Smarty version Smarty-3.0.8, created on 2012-11-22 20:47:57
         compiled from "/var/www/tarmo.puhti.com-ssl/mobile/templates/page_css.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1162601416509e4d822feba2-89014184%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0abefa03ab7257cda4d5c2e2934f3f3ea2fa4638' => 
    array (
      0 => '/var/www/tarmo.puhti.com-ssl/mobile/templates/page_css.tpl',
      1 => 1353610016,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1162601416509e4d822feba2-89014184',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php  $_smarty_tpl->tpl_vars['media'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['stylesheet'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['media']->key => $_smarty_tpl->tpl_vars['media']->value){
 $_smarty_tpl->tpl_vars['stylesheet']->value = $_smarty_tpl->tpl_vars['media']->key;
?>
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('baseUrl')->value;?>
css/<?php echo $_smarty_tpl->tpl_vars['stylesheet']->value;?>
" type="text/css" media="<?php echo $_smarty_tpl->tpl_vars['media']->value;?>
" />
<?php }} ?>