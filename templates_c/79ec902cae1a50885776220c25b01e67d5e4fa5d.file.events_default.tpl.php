<?php /* Smarty version Smarty-3.0.8, created on 2012-01-01 15:09:55
         compiled from "/var/www/tarmo.puhti.com-ssl/mobile/templates/Events/events_default.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21196583204f005b236816e6-80043297%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '79ec902cae1a50885776220c25b01e67d5e4fa5d' => 
    array (
      0 => '/var/www/tarmo.puhti.com-ssl/mobile/templates/Events/events_default.tpl',
      1 => 1325420331,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21196583204f005b236816e6-80043297',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('navbar.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('active',$_smarty_tpl->getVariable('active')->value); echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<div id="Events">
    <ul id="Events" data-role="listview" data-inset="true">
        <?php if (count($_smarty_tpl->getVariable('events')->value)==0){?>
            <li>Ei vielä yhtään tapahtumaa...</li>
        <?php }else{ ?>
            <?php  $_smarty_tpl->tpl_vars['dayEvents'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['date'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('events')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['dayEvents']->key => $_smarty_tpl->tpl_vars['dayEvents']->value){
 $_smarty_tpl->tpl_vars['date']->value = $_smarty_tpl->tpl_vars['dayEvents']->key;
?>
                <li data-role="list-divider"><?php echo $_smarty_tpl->tpl_vars['date']->value;?>
</li>
                <?php  $_smarty_tpl->tpl_vars['event'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['dayEvents']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['event']->key => $_smarty_tpl->tpl_vars['event']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['event']->key;
?>
                <li>
                    <h1><?php echo $_smarty_tpl->tpl_vars['event']->value['Title'];?>
</h1>
                    <?php if (!empty($_smarty_tpl->tpl_vars['event']->value['Description'])){?>
                    <p class="ui-li-desc" style="white-space:normal;"><?php echo nl2br($_smarty_tpl->tpl_vars['event']->value['Description']);?>
</p>
                    <?php }?>
                </li>
                <?php }} ?>
            <?php }} ?>
        <?php }?>
    </ul>
</div>