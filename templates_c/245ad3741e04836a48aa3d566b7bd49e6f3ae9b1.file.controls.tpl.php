<?php /* Smarty version Smarty-3.0.8, created on 2012-11-22 20:48:12
         compiled from "/var/www/tarmo.puhti.com-ssl/mobile/templates/Control/controls.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1474282547509e96a12154c4-97254106%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '245ad3741e04836a48aa3d566b7bd49e6f3ae9b1' => 
    array (
      0 => '/var/www/tarmo.puhti.com-ssl/mobile/templates/Control/controls.tpl',
      1 => 1353610016,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1474282547509e96a12154c4-97254106',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<ul id="Controls" data-role="listview" data-inset="true">
    <li data-role="list-divider"><div id="ControlsImage"></div>Ohjaukset</li>
    <?php  $_smarty_tpl->tpl_vars["control"] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars["k"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('controls')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["control"]->key => $_smarty_tpl->tpl_vars["control"]->value){
 $_smarty_tpl->tpl_vars["k"]->value = $_smarty_tpl->tpl_vars["control"]->key;
?>
        <li>
            <input type="checkbox" class="iPhoneSwitch" id="Control_<?php echo $_smarty_tpl->getVariable('control')->value['ID'];?>
" value="1" data-id="<?php echo $_smarty_tpl->getVariable('control')->value['ID'];?>
" data-bit="<?php echo $_smarty_tpl->getVariable('control')->value['Key'];?>
" <?php if ($_smarty_tpl->getVariable('control')->value['Status']==1){?> checked="checked"<?php }?>" />
            <?php echo $_smarty_tpl->getVariable('control')->value['Name'];?>

            <div syle="clear: both;"></div>
        </li>
    <?php }} ?>
</ul>