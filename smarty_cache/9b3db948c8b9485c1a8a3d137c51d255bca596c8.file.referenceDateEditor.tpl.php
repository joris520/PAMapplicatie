<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 09:18:33
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/application/interface/templates\referenceDateEditor.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17319556ffbc935de99-07057019%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9b3db948c8b9485c1a8a3d137c51d255bca596c8' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/application/interface/templates\\referenceDateEditor.tpl',
      1 => 1433243234,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17319556ffbc935de99-07057019',
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