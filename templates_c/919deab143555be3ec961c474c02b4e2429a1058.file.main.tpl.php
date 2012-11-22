<?php /* Smarty version Smarty-3.0.8, created on 2012-11-22 20:47:57
         compiled from "/var/www/tarmo.puhti.com-ssl/mobile/templates/GraphsTemperature/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1863671784509e4d822a4dd8-37494919%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '919deab143555be3ec961c474c02b4e2429a1058' => 
    array (
      0 => '/var/www/tarmo.puhti.com-ssl/mobile/templates/GraphsTemperature/main.tpl',
      1 => 1353610016,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1863671784509e4d822a4dd8-37494919',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<meta http-equiv="refresh" content="300">
<div id="Graphs">
    <fieldset id="RangeButtons" data-role="controlgroup" data-type="horizontal">
    <?php  $_smarty_tpl->tpl_vars["range"] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars["k"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('ranges')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["range"]->key => $_smarty_tpl->tpl_vars["range"]->value){
 $_smarty_tpl->tpl_vars["k"]->value = $_smarty_tpl->tpl_vars["range"]->key;
?>
        <input type="radio" name="Range" id="Range_<?php echo $_smarty_tpl->getVariable('range')->value['ID'];?>
" value="<?php echo $_smarty_tpl->getVariable('range')->value['ID'];?>
" <?php if ($_smarty_tpl->getVariable('checkedRange')->value==$_smarty_tpl->getVariable('range')->value['ID']){?>checked="checked" <?php }?>/>
        <label for="Range_<?php echo $_smarty_tpl->getVariable('range')->value['ID'];?>
"><?php echo $_smarty_tpl->getVariable('range')->value['Label'];?>
</label>
    <?php }} ?>
    </fieldset>

    <div id="GraphImages">
    <?php echo $_smarty_tpl->getVariable('imageData')->value;?>

    </div>
</div>
