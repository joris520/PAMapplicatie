<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 11:01:10
         compiled from "C:\xampp\htdocs\broodjesalami\php_cm/application/interface/templates\referenceDateEditor.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1378557013d63d63d0-33221995%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a2aba8c90e9017bf2b660a5ea0a8a9e00fec38f8' => 
    array (
      0 => 'C:\\xampp\\htdocs\\broodjesalami\\php_cm/application/interface/templates\\referenceDateEditor.tpl',
      1 => 1433407463,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1378557013d63d63d0-33221995',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- referenceDateEditor.tpl -->
&nbsp;peildatum: <?php echo $_smarty_tpl->getVariable('editorDatePicker')->value;?>

&nbsp;<input name="modify" type="button" value="aanpassen" onClick="xajax_public_modifyCurrentDate(xajax.getFormValues('<?php echo $_smarty_tpl->getVariable('editorFormName')->value;?>
')); return false;">
<!-- /referenceDateEditor.tpl -->