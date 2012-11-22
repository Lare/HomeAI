<?php /* Smarty version Smarty-3.0.8, created on 2012-11-22 20:48:12
         compiled from "/var/www/tarmo.puhti.com-ssl/mobile/templates/Control/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:791277221509e96a125bcd3-53633568%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2dabfc1383ad873f439a4ce573a24d5d7d032da5' => 
    array (
      0 => '/var/www/tarmo.puhti.com-ssl/mobile/templates/Control/main.tpl',
      1 => 1353610016,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '791277221509e96a125bcd3-53633568',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="Left">
    <div id="ControlBox">
        <?php echo $_smarty_tpl->getVariable('controls')->value;?>

    </div>
</div>

<div id="Right">
    <div id="TemperatureBox">
        <ul data-role="listview" data-inset="true">
            <li data-role="list-divider"><div id="TemperatureImage"></div>Lämpötilat</li>
            <li><div id="Temperature"><?php echo $_smarty_tpl->getVariable('temperature')->value;?>
</div></li>
        </ul>
    </div>

    <div id="ActionBox">
        <ul id="Actions" data-role="listview" data-inset="true">
            <li data-role="list-divider"><div id="ActionImage"></div>Toiminnot</li>
            <?php  $_smarty_tpl->tpl_vars["control"] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars["k"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('controls')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["control"]->key => $_smarty_tpl->tpl_vars["control"]->value){
 $_smarty_tpl->tpl_vars["k"]->value = $_smarty_tpl->tpl_vars["control"]->key;
?>
                <?php  $_smarty_tpl->tpl_vars["action"] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars["k"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('actions')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["action"]->key => $_smarty_tpl->tpl_vars["action"]->value){
 $_smarty_tpl->tpl_vars["k"]->value = $_smarty_tpl->tpl_vars["action"]->key;
?>
                    <li><a href="<?php echo $_smarty_tpl->getVariable('action')->value['URL'];?>
" data-ajax="false"><?php echo $_smarty_tpl->getVariable('action')->value['Title'];?>
</a></li>
                <?php }} ?>
            <?php }} ?>
        </ul>
    </div>
</div>
