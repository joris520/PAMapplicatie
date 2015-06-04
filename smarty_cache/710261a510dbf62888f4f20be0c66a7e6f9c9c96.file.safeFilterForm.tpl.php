<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 11:01:12
         compiled from "C:\xampp\htdocs\broodjesalami\php_cm/application/interface/templates\components/safeFilterForm.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5550557013d8826b44-56185240%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '710261a510dbf62888f4f20be0c66a7e6f9c9c96' => 
    array (
      0 => 'C:\\xampp\\htdocs\\broodjesalami\\php_cm/application/interface/templates\\components/safeFilterForm.tpl',
      1 => 1433407462,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5550557013d8826b44-56185240',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- /safeFilterForm.tpl -->
<form id="<?php echo $_smarty_tpl->getVariable('formId')->value;?>
" name="<?php echo $_smarty_tpl->getVariable('formId')->value;?>
" onsubmit="submitFilterSafeForm('<?php echo $_smarty_tpl->getVariable('safeFormIdentifier')->value;?>
', this.name);return false;">
    <?php echo $_smarty_tpl->getVariable('safeFormToken')->value;?>

    <?php echo $_smarty_tpl->getVariable('formContent')->value;?>

</form>
<!-- /safeFilterForm.tpl -->