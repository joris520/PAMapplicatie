<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 09:21:25
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\library/pdpActionSelectGroup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8625556ffc75d22045-02381642%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c701b50f2406bb7f2289c3c6a58d45e5f025c74' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\library/pdpActionSelectGroup.tpl',
      1 => 1433243583,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8625556ffc75d22045-02381642',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- pdpActionSelectGroup.tpl -->
<div style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth(ApplicationInterfaceBuilder::DIALOG_WIDTH_CORRECTION);?>
; height:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getContentHeight();?>
; overflow:auto;">
    <?php if (count($_smarty_tpl->getVariable('interfaceObject')->value->getInterfaceObjects())>0){?>
    <table border="0" cellspacing="0" cellpadding="2" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
;">
        <?php  $_smarty_tpl->tpl_vars['clusterInterfaceObject'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('interfaceObject')->value->getInterfaceObjects(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['clusterInterfaceObject']->key => $_smarty_tpl->tpl_vars['clusterInterfaceObject']->value){
?>
            <?php echo $_smarty_tpl->getVariable('clusterInterfaceObject')->value->fetchHtml();?>

        <?php }} ?>
    </table>
    <?php }else{ ?>
        <br/>
        <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->displayEmptyMessage();?>

    <?php }?>
</div>
<!-- /pdpActionSelectGroup.tpl -->