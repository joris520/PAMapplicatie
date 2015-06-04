<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 11:45:35
         compiled from "C:\xampp\htdocs\broodjesalami\php_cm/modules/interface/templates\base/baseBlockHtml.tpl" */ ?>
<?php /*%%SmartyHeaderCode:723055701e3f476a98-16795914%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f6ec357652ac5ad4902ae0a059e813ac4e2efbe7' => 
    array (
      0 => 'C:\\xampp\\htdocs\\broodjesalami\\php_cm/modules/interface/templates\\base/baseBlockHtml.tpl',
      1 => 1433407468,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '723055701e3f476a98-16795914',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- baseBlockHtml.tpl -->
<?php if ($_smarty_tpl->getVariable('interfaceObject')->value->isSubHeader()){?>
<?php $_smarty_tpl->tpl_vars['headerClass'] = new Smarty_variable(' no-header-block', null, null);?>
<?php }else{ ?>
<?php $_smarty_tpl->tpl_vars['headerClass'] = new Smarty_variable('', null, null);?>
<?php }?>
<?php if (!$_smarty_tpl->getVariable('interfaceObject')->value->hasFooter()){?>
<?php $_smarty_tpl->tpl_vars['noFooterClass'] = new Smarty_variable(' no-footer-block', null, null);?>
<?php }else{ ?>
<?php $_smarty_tpl->tpl_vars['noFooterClass'] = new Smarty_variable('', null, null);?>
<?php }?>
<div class="application-content block-header<?php echo $_smarty_tpl->getVariable('headerClass')->value;?>
" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
;">
    <table border="0" cellspacing="0" cellpadding="2" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
;">
        <tr>
            <td>
                <h2><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getHeaderTitle();?>
</h2>
            </td>
            <td style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getActionsWidth();?>
; text-align:right">
                <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getActionLinks();?>

            </td>
        </tr>
        <?php  $_smarty_tpl->tpl_vars['additionalHeaderRow'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('interfaceObject')->value->getAdditionalHeaderRows(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['additionalHeaderRow']->key => $_smarty_tpl->tpl_vars['additionalHeaderRow']->value){
?>
            <?php echo $_smarty_tpl->getVariable('additionalHeaderRow')->value->fetchHtml();?>

        <?php }} ?>
    </table>
</div>
<div class="application-content block-data<?php echo $_smarty_tpl->getVariable('headerClass')->value;?>
<?php echo $_smarty_tpl->getVariable('noFooterClass')->value;?>
" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
;">
    <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getContentHtml();?>

</div>
<!-- /baseBlockHtml.tpl -->