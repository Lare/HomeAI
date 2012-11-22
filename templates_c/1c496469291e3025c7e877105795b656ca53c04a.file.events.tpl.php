<?php /* Smarty version Smarty-3.0.8, created on 2012-01-01 13:00:08
         compiled from "/var/www/tarmo.puhti.com-ssl/mobile/templates/Events/events.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14516021164f003cb86568d6-47028738%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c496469291e3025c7e877105795b656ca53c04a' => 
    array (
      0 => '/var/www/tarmo.puhti.com-ssl/mobile/templates/Events/events.tpl',
      1 => 1325415071,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14516021164f003cb86568d6-47028738',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="EventsAjax">
    <ul data-role="listview">
        <?php if (count($_smarty_tpl->getVariable('events')->value)==0){?>
            <li>Päivällä ei vielä tapahtumia...</li>
        <?php }else{ ?>
            <?php  $_smarty_tpl->tpl_vars['event'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('events')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
        <?php }?>
        <li data-role="list-divider">Lisää uusi tapahtuma päivälle</li>
        <li>
            <form id="EventForm" name="EventForm" action="" method="post">
                <div data-role="fieldcontain">
                    <label for="EventFormTitle">Otsikko:</label>
                    <input id="EventFormTitle" name="EventFormTitle" type="text" />
                </div>
                <div data-role="fieldcontain">
                    <label for="EventFormDescription">Kuvaus:</label>
                    <textarea id="EventFormDescription" name="EventFormDescription"></textarea>
                </div>
                <div data-role="fieldcontain">
                    <input type="button" id="EventFormSubmit" data-date="<?php echo $_smarty_tpl->getVariable('date')->value;?>
" value="Lisää tapahtuma" />
                </div>
            </form>
        </li>
    </ul>
</div>

