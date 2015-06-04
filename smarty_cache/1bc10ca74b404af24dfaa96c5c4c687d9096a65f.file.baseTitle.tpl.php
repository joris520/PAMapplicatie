<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 11:45:23
         compiled from "C:\xampp\htdocs\broodjesalami\php_cm/modules/interface/templates\base/baseTitle.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1713855701e3329a027-15789838%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1bc10ca74b404af24dfaa96c5c4c687d9096a65f' => 
    array (
      0 => 'C:\\xampp\\htdocs\\broodjesalami\\php_cm/modules/interface/templates\\base/baseTitle.tpl',
      1 => 1433407468,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1713855701e3329a027-15789838',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- baseTitle.tpl -->
<?php if ($_smarty_tpl->getVariable('interfaceObject')->value->isSubHeader()){?>
<?php $_smarty_tpl->tpl_vars['headerClass'] = new Smarty_variable(' subheader', null, null);?>
<?php }else{ ?>
<?php $_smarty_tpl->tpl_vars['headerClass'] = new Smarty_variable('', null, null);?>
<?php }?>

<div class="application-content block-title <?php echo $_smarty_tpl->getVariable('headerClass')->value;?>
" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
; margin-top:20px;">
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
        <tr>
            <?php echo $_smarty_tpl->getVariable('additionalHeaderRow')->value->fetchHtml();?>

        </tr>
        <?php }} ?>
    </table>
</div>
<!-- /baseTitle.tpl -->