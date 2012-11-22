<?php /* Smarty version Smarty-3.0.8, created on 2012-01-01 15:09:59
         compiled from "/var/www/tarmo.puhti.com-ssl/mobile/templates/Events/add_new.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19852634234f005b276d4cb9-06581286%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '95a119c3adbc1f4f2773f331f7a8f7edf35e3de8' => 
    array (
      0 => '/var/www/tarmo.puhti.com-ssl/mobile/templates/Events/add_new.tpl',
      1 => 1325420331,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19852634234f005b276d4cb9-06581286',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('navbar.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('active',$_smarty_tpl->getVariable('active')->value); echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

<form id="EventForm" name="EventForm" action="<?php echo $_smarty_tpl->getVariable('baseUrl')->value;?>
" method="post" data-ajax="false">
    <input type="hidden" name="Module" value="Events" />
    <input type="hidden" name="Action" value="SaveEvent" />
    <div data-role="fieldcontain" class="row">
        <label for="Title">Otsikko:</label>
        <input id="Title" name="Title" type="text" />
        <div class="message"><div class="spacer"></div></div>
    </div>
    <div data-role="fieldcontain" class="row">
        <label for="Date">Päivämäärä:</label>
        <input name="Date" id="Date" type="date" data-role="datebox" data-options='{"mode": "calbox", "calStartDay": 1}'>
        <div class="message"><div class="spacer"></div></div>
    </div>
    <div data-role="fieldcontain">
        <label for="Description">Kuvaus:</label>
        <textarea id="Description" name="Description"></textarea>
    </div>
    <div data-role="fieldcontain">
        <input type="submit" value="Lisää tapahtuma" />
    </div>
</form>