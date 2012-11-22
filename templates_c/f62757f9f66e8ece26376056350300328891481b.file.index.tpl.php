<?php /* Smarty version Smarty-3.0.8, created on 2012-11-22 20:47:57
         compiled from "/var/www/tarmo.puhti.com-ssl/mobile/templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1643967899509e4d82323ed9-15070109%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f62757f9f66e8ece26376056350300328891481b' => 
    array (
      0 => '/var/www/tarmo.puhti.com-ssl/mobile/templates/index.tpl',
      1 => 1353610016,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1643967899509e4d82323ed9-15070109',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $_smarty_tpl->getVariable('pageTitle')->value;?>
</title>
     
    <base href="<?php echo $_smarty_tpl->getVariable('BaseHref')->value;?>
" />

    <!-- Meta information -->
    <meta name="author" content="Lare" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="robots" content="no-index, no-follow" />
    <meta name="rating" content="General" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="refresh" content="86400">

    <!-- CSS definitions -->
<?php echo $_smarty_tpl->getVariable('pageCSS')->value;?>


    <!-- JS definitions -->
<?php echo $_smarty_tpl->getVariable('pageJS')->value;?>


    <script type="text/javascript">
        var jq = jQuery.noConflict();
        var systemUrl = '<?php echo $_smarty_tpl->getVariable('BaseHref')->value;?>
';
        var module = '<?php echo $_smarty_tpl->getVariable('Module')->value;?>
';
        <?php if (is_array($_smarty_tpl->getVariable('pageVar')->value)){?>
            <?php  $_smarty_tpl->tpl_vars['js'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('pageVar')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['js']->key => $_smarty_tpl->tpl_vars['js']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['js']->key;
?>
                <?php echo $_smarty_tpl->tpl_vars['js']->value;?>

            <?php }} ?>
        <?php }?>

        <?php if (is_array($_smarty_tpl->getVariable('pageScript')->value)){?>
        
        jq(function(){
        
            <?php  $_smarty_tpl->tpl_vars['script'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('pageScript')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['script']->key => $_smarty_tpl->tpl_vars['script']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['script']->key;
?>
        <?php echo $_smarty_tpl->tpl_vars['script']->value;?>

            <?php }} ?>
        
        });
        
        <?php }?>

    </script>

    <!-- Custom head definitions -->
<?php echo $_smarty_tpl->getVariable('pageHead')->value;?>


</head>

<body>
    <div id="wrapper" >
        <div id="wrapperInside" data-role="page" data-theme="a">

            <div id="header" data-role="header" data-theme="a">
                <h1 id="Clock"><?php echo $_smarty_tpl->getVariable('date')->value;?>
</h1>
                <?php echo $_smarty_tpl->getVariable('Header')->value;?>

                <?php $_template = new Smarty_Internal_Template('calendar_input.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('events','{$Events}'); echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
            </div>

            <div id="content" data-role="content">
                <?php if (is_array($_smarty_tpl->getVariable('Content')->value)){?>
                    <?php  $_smarty_tpl->tpl_vars['content'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('Content')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['content']->key => $_smarty_tpl->tpl_vars['content']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['content']->key;
?>
                        <?php echo $_smarty_tpl->tpl_vars['content']->value;?>

                    <?php }} ?>
                <?php }else{ ?>
                    <?php echo $_smarty_tpl->getVariable('Content')->value;?>

                <?php }?>
            </div>

            <div class="push"></div>

            <div id="footer" data-role="footer" data-theme="a" data-position="fixed">
                <a href="<?php echo $_smarty_tpl->getVariable('BaseHref')->value;?>
" id="HomeIcon" data-icon="home" data-iconpos="notext" data-ajax="false">Etusivulle</a>
                <div id="SystemInfo">
                    <span><?php echo $_smarty_tpl->getVariable('SystemName')->value;?>
 <?php echo $_smarty_tpl->getVariable('Version')->value;?>
</span>
                </div>
                <?php echo $_smarty_tpl->getVariable('Footer')->value;?>

            </div>
        </div>
    </div>


    <div style="display: none;">
        <a id="linkEvents" href="" data-rel="dialog">t</a>

    </div>

</body>

</html>
