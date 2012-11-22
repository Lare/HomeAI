<?php /* Smarty version Smarty-3.0.8, created on 2012-01-30 20:34:17
         compiled from "/var/www/tarmo.puhti.com-ssl/mobile/templates/EggTimer/timer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12287705254f26e2a97f4cb6-53345771%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '249f59357426e0e3819b48337e36075d19a0a1c6' => 
    array (
      0 => '/var/www/tarmo.puhti.com-ssl/mobile/templates/EggTimer/timer.tpl',
      1 => 1327948153,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12287705254f26e2a97f4cb6-53345771',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="Timer">

    <div data-role="fieldcontain">
        <label for="TimerDuration">Valitse aika:</label>
        <input name="TimerDuration" id="TimerDuration" type="date" data-role="datebox" data-options='{"mode": "durationbox", "durationNoDays": 1}'>
    </div>

    <div data-role="fieldcontain">
        <input type="button" id="StartTimer" value="Käynnistä kello" />
    </div>

    <div id="EggTimer"></div>

    <div style="display: block;">
        <audio id="AlarmSound" preload="auto" controls="controls" loop="loop">
            <source src="<?php echo $_smarty_tpl->getVariable('baseUrl')->value;?>
sounds/alarm.mp3" type="audio/mpeg" />
            <source src="<?php echo $_smarty_tpl->getVariable('baseUrl')->value;?>
sounds/alarm.ogg" type="audio/ogg" />
        </audio>
    </div>
</div>
