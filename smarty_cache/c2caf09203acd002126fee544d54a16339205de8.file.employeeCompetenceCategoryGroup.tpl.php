<?php /* Smarty version Smarty-3.0.7, created on 2014-05-26 16:05:35
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\employee/competence/employeeCompetenceCategoryGroup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3140153834a2fca11c6-79974419%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c2caf09203acd002126fee544d54a16339205de8' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\employee/competence/employeeCompetenceCategoryGroup.tpl',
      1 => 1379954116,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3140153834a2fca11c6-79974419',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeeCompetenceCategoryGroup.tpl -->
    <tr>
        <th colspan="100%">
            <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showCategory()){?>
                <h2><?php echo CategoryConverter::display($_smarty_tpl->getVariable('interfaceObject')->value->getCategoryName());?>
</h2>
            <?php }else{ ?>
                &nbsp;
            <?php }?>
        </th>
    </tr>
    <tr>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->show360()){?>
        <?php $_smarty_tpl->tpl_vars['periodTitleColspan'] = new Smarty_variable(2, null, null);?>
        <?php }else{ ?>
        <?php $_smarty_tpl->tpl_vars['periodTitleColspan'] = new Smarty_variable(1, null, null);?>
        <?php }?>
        <th class="shaded_title2">&nbsp;</th>
        <th class="shaded_title2 centered previous-period-header"colspan="<?php echo $_smarty_tpl->getVariable('periodTitleColspan')->value;?>
">
            <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getPreviousPeriodName();?>

        </th>
        <th class="shaded_title2 centered current-period-header" colspan="<?php echo $_smarty_tpl->getVariable('periodTitleColspan')->value;?>
">
            <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getCurrentPeriodName();?>

        </th>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showNorm()){?>
        <th class="shaded_title2 centered">&nbsp;</th>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showWeight()){?>
        <th class="shaded_title2 centered">&nbsp;</th>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showPdpActions()){?>
        <th class="shaded_title2 centered">&nbsp;</th>
        <?php }?>
        <th class="shaded_title2">
                &nbsp;
        </th>
    </tr>
    <tr>
        <th class="shaded_title2"></th>
        <th width="100px" class="shaded_title2 centered previous-period">
            <?php echo TXT_LC('COMPENTENCE_SCORE_HEADER_MANAGER');?>

            <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getPreviousPeriodIconView()->fetchHtml();?>

        </th>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->show360()){?>
        <th width="100px" class="shaded_title2 centered previous-period">
            <?php echo TXT_LC('COMPENTENCE_SCORE_HEADER_EMPLOYEE');?>

            <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getPreviousPeriodEmployeeIconView()->fetchHtml();?>

        </th>
        <?php }?>
        <th width="100px" class="shaded_title2 centered current-period">
            <?php echo TXT_LC('COMPENTENCE_SCORE_HEADER_MANAGER');?>

            <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getCurrentPeriodIconView()->fetchHtml();?>

        </th>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->show360()){?>
        <th width="100px" class="shaded_title2 centered current-period">
            <?php echo TXT_LC('COMPENTENCE_SCORE_HEADER_EMPLOYEE');?>

            <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getCurrentPeriodEmployeeIconView()->fetchHtml();?>

        </th>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showNorm()){?>
        <th width="50px" class="shaded_title2 centered">
            <?php echo TXT_UCF('NORM');?>

        </th>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showWeight()){?>
        <th width="60px" class="shaded_title2 centered">
            <?php echo TXT_UCF('WEIGHT_FACTOR');?>

        </th>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showPdpActions()){?>
        <th width="60px"  class="shaded_title2 centered">
            <?php echo TXT_TAB('PDP_ACTIONS');?>

        </th>
        <?php }?>
        <th width="100px" class="shaded_title2">
            &nbsp;
        </th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['clusterInterfaceObject'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('interfaceObject')->value->getInterfaceObjects(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['clusterInterfaceObject']->key => $_smarty_tpl->tpl_vars['clusterInterfaceObject']->value){
?>
        <?php echo $_smarty_tpl->getVariable('clusterInterfaceObject')->value->fetchHtml();?>

    <?php }} ?>
<!-- /employeeCompetenceCategoryGroup.tpl -->