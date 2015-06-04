<?php /* Smarty version Smarty-3.0.7, created on 2013-09-23 18:40:03
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/application/interface/templates\components/safeActionForm.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1073952406ee382c0f2-29735035%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '85186e7477423b4e4631081ff2bbe309439e4bea' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/application/interface/templates\\components/safeActionForm.tpl',
      1 => 1379954112,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1073952406ee382c0f2-29735035',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- /safeActionForm.tpl -->
<form id="<?php echo $_smarty_tpl->getVariable('formId')->value;?>
" name="<?php echo $_smarty_tpl->getVariable('formId')->value;?>
" onsubmit="submitActionSafeForm('<?php echo $_smarty_tpl->getVariable('safeFormIdentifier')->value;?>
', this.name);return false;">
    <?php echo $_smarty_tpl->getVariable('safeFormToken')->value;?>

    <?php echo $_smarty_tpl->getVariable('formContent')->value;?>

</form>
<!-- /safeActionForm.tpl -->