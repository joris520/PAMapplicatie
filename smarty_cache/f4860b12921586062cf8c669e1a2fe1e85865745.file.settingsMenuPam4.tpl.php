<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 09:20:00
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/application/interface/templates\navigation/settingsMenuPam4.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19999556ffc20d5bcb5-36147141%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f4860b12921586062cf8c669e1a2fe1e85865745' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/application/interface/templates\\navigation/settingsMenuPam4.tpl',
      1 => 1433243548,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19999556ffc20d5bcb5-36147141',
  'function' => 
  array (
    'activeClass' => 
    array (
      'parameter' => 
      array (
        'menuName' => '',
      ),
      'compiled' => '',
    ),
  ),
  'has_nocache_code' => 0,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- settingsMenuPam4.tpl -->
<?php if (!function_exists('smarty_template_function_activeClass')) {
    function smarty_template_function_activeClass($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->template_functions['activeClass']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
<?php if ($_smarty_tpl->getVariable('active')->value==constant($_smarty_tpl->getVariable('menuName')->value)){?>active-menu-item<?php }?><?php if ($_smarty_tpl->getVariable('lastModule')->value==constant($_smarty_tpl->getVariable('menuName')->value)){?> last<?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>

<div class="application-content block-menu" style="margin-left: auto; margin-right:auto;">
    <table class="tab-menu">
        <tr>
        <?php if ($_smarty_tpl->getVariable('showLevelAuthorization')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_LEVEL_AUTHORIZATION'));?>
"
                onclick="xajax_moduleLevelAuthorisation_displayLevelAuthorization();return false;">
                <a href="" ><?php echo TXT_TAB('LEVEL_AUTHORIZATION');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showUsers')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_USERS'));?>
"
                onclick="xajax_moduleUsers();return false;">
                <a href=""><?php echo TXT_TAB('USERS');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showThemes')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_THEMES'));?>
"
                onclick="xajax_moduleOptions_themeLogo();return false;">
                <a href=""><?php echo TXT_TAB('THEMES');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showDefaultDate')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_DEFAULT_DATE'));?>
"
                onclick="xajax_public_settings__displayStandardDate();return false;">
                <a href=""><?php echo TXT_TAB('DEFAULT_END_DATE');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showEmpArchives')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_EMPLOYEES_ARCHIVED'));?>
"
                onclick="xajax_moduleOptions_showEmployeesArchive();return false;">
                <a href=""><?php echo TXT_TAB('EMPLOYEE_ARCHIVES');?>
</a>
            </td>
        <?php }?>
        </tr>
    </table>
</div>
<!-- /settingsMenuPam4.tpl -->