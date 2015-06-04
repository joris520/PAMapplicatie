<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 09:21:26
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\employee/pdpAction/employeePdpActionCompetenceSelectView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:28272556ffc763cfaf3-15321867%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f060c715fdcb6dc0848664287404575c78fee377' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\employee/pdpAction/employeePdpActionCompetenceSelectView.tpl',
      1 => 1433243738,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '28272556ffc763cfaf3-15321867',
  'function' => 
  array (
    'writeCheckbox' => 
    array (
      'parameter' => 
      array (
        'input_id' => '',
        'is_selected' => false,
      ),
      'compiled' => '',
    ),
    'writeLabel' => 
    array (
      'parameter' => 
      array (
        'label_name' => '',
        'input_id' => '',
        'is_selected' => false,
      ),
      'compiled' => '',
    ),
  ),
  'has_nocache_code' => 0,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeePdpActionCompetenceSelectView.tpl -->
<?php $_smarty_tpl->tpl_vars['valueObject'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getValueObject(), null, null);?>
<?php $_smarty_tpl->tpl_vars['inputId'] = new Smarty_variable(($_smarty_tpl->getVariable('interfaceObject')->value->getCheckboxPrefix()).($_smarty_tpl->getVariable('valueObject')->value->getId()), null, null);?>

<?php if (!function_exists('smarty_template_function_writeCheckbox')) {
    function smarty_template_function_writeCheckbox($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->template_functions['writeCheckbox']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
    <input type="checkbox"
           name="<?php echo $_smarty_tpl->getVariable('input_id')->value;?>
"
           id="<?php echo $_smarty_tpl->getVariable('input_id')->value;?>
"
           <?php if ($_smarty_tpl->getVariable('is_selected')->value){?> checked="checked" <?php }?>><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>


<?php if (!function_exists('smarty_template_function_writeLabel')) {
    function smarty_template_function_writeLabel($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->template_functions['writeLabel']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
    <label for="<?php echo $_smarty_tpl->getVariable('input_id')->value;?>
"
           <?php if ($_smarty_tpl->getVariable('is_selected')->value){?> style="font-weight: bold" <?php }?>
           >
        <?php echo $_smarty_tpl->getVariable('label_name')->value;?>

    </label><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>

    <tr>
        <td style="padding-left: 20px; width: 25px;">
            <?php smarty_template_function_writeCheckbox($_smarty_tpl,array('input_id'=>$_smarty_tpl->getVariable('inputId')->value,'is_selected'=>$_smarty_tpl->getVariable('interfaceObject')->value->isSelected()));?>

        </td>
        <td>
            <?php smarty_template_function_writeLabel($_smarty_tpl,array('label_name'=>$_smarty_tpl->getVariable('valueObject')->value->getCompetenceName(),'input_id'=>$_smarty_tpl->getVariable('inputId')->value,'is_selected'=>$_smarty_tpl->getVariable('interfaceObject')->value->isSelected()));?>

        </td>
        <td>
        </td>
    </tr>
<!-- /employeePdpActionCompetenceSelectView.tpl -->