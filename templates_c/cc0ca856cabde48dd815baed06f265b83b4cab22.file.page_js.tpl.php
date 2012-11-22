<?php /* Smarty version Smarty-3.0.8, created on 2012-11-22 20:47:57
         compiled from "/var/www/tarmo.puhti.com-ssl/mobile/templates/page_js.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2098279025509e4d822f2537-49595925%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cc0ca856cabde48dd815baed06f265b83b4cab22' => 
    array (
      0 => '/var/www/tarmo.puhti.com-ssl/mobile/templates/page_js.tpl',
      1 => 1353610016,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2098279025509e4d822f2537-49595925',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php  $_smarty_tpl->tpl_vars['js'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['js']->key => $_smarty_tpl->tpl_vars['js']->value){
?>
    <script src="<?php echo $_smarty_tpl->getVariable('baseUrl')->value;?>
js/<?php echo $_smarty_tpl->tpl_vars['js']->value;?>
"></script>
<?php }} ?>