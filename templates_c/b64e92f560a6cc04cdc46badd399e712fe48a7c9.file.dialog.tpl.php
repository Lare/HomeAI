<?php /* Smarty version Smarty-3.0.8, created on 2012-01-01 13:00:08
         compiled from "/var/www/tarmo.puhti.com-ssl/mobile/templates/dialog.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2210183544f003cb8725ae5-90835673%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b64e92f560a6cc04cdc46badd399e712fe48a7c9' => 
    array (
      0 => '/var/www/tarmo.puhti.com-ssl/mobile/templates/dialog.tpl',
      1 => 1325415071,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2210183544f003cb8725ae5-90835673',
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
            <div data-role="header" data-theme="b">
                <h1><?php echo $_smarty_tpl->getVariable('pageTitle')->value;?>
</h1>
            </div>

            <div data-role="content">
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

        </div>
    </div>
</body>

</html>
