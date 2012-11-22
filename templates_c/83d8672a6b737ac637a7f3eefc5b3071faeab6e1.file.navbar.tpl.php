<?php /* Smarty version Smarty-3.0.8, created on 2012-01-01 15:09:55
         compiled from "/var/www/tarmo.puhti.com-ssl/mobile/templates/Events/navbar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16784078064f005b236f7730-40531397%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '83d8672a6b737ac637a7f3eefc5b3071faeab6e1' => 
    array (
      0 => '/var/www/tarmo.puhti.com-ssl/mobile/templates/Events/navbar.tpl',
      1 => 1325420331,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16784078064f005b236f7730-40531397',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div data-role="navbar">
    <ul>
        <li><a href="<?php echo $_smarty_tpl->getVariable('baseUrl')->value;?>
?Module=Events&Action=Default&NoAjax=1" <?php if ($_smarty_tpl->getVariable('active')->value=='future'){?>class="ui-btn-active"<?php }?>>Tulevat tapahtumat</a></li>
        <li><a href="<?php echo $_smarty_tpl->getVariable('baseUrl')->value;?>
?Module=Events&Action=ShowPast" <?php if ($_smarty_tpl->getVariable('active')->value=='past'){?>class="ui-btn-active"<?php }?>>Menneet tapahtumat</a></li>
        <li><a href="<?php echo $_smarty_tpl->getVariable('baseUrl')->value;?>
?Module=Events&Action=AddNew" <?php if ($_smarty_tpl->getVariable('active')->value=='new'){?>class="ui-btn-active"<?php }?>>Lisää uusi</a></li>
    </ul>
</div>