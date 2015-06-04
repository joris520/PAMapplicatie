<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 09:18:34
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\list/employeeResultGroup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11001556ffbcaeec5c2-63425295%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f33b5768362127aeb29c8ef202686c4a5e31324a' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\list/employeeResultGroup.tpl',
      1 => 1433243584,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11001556ffbcaeec5c2-63425295',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeeResultGroup.tpl -->
<!-- EmployeeListState:<?php echo EmployeeListState::determineState();?>
 -->
<?php if (count($_smarty_tpl->getVariable('interfaceObject')->value->getInterfaceObjects())>0){?>
    <div id="searchLimitText">
        <p class="info-text">
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showLimitText()){?>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->hasHitLimit()){?>
            <?php echo TXT_UCF('EMPLOYEES_LIST_LIMITED_RESULTS');?>
.
            <br />
            <?php echo TXT_UCF_VALUE('ONLY_EMPLOYEES_LIMIT_SHOWN');?>
.
        <?php }else{ ?>
            <?php echo TXT_UCF('HEADCOUNT');?>
: <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getCount();?>

        <?php }?>
        <?php }?>
        </p>
    </div>
    <div id="scrollDiv">
        <table border="0" cellspacing="0" cellpadding="0" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
">
            <?php  $_smarty_tpl->tpl_vars['employeeView'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('interfaceObject')->value->getInterfaceObjects(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['employeeView']->key => $_smarty_tpl->tpl_vars['employeeView']->value){
?>
                <?php echo $_smarty_tpl->getVariable('employeeView')->value->fetchHtml();?>

            <?php }} ?>
        </table>
    </div><!-- scrollDiv -->
<?php }else{ ?>
<center><?php echo TXT_UCF('NO_RESULT_ON_SEARCH_CRITERIA');?>
</center>
<?php }?>
<!-- /employeeResultGroup.tpl -->