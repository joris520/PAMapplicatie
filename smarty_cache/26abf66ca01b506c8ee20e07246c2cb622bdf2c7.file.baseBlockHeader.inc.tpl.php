<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 09:18:48
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\base/baseBlockHeader.inc.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10294556ffbd810dfb5-10892214%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '26abf66ca01b506c8ee20e07246c2cb622bdf2c7' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\base/baseBlockHeader.inc.tpl',
      1 => 1433243578,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10294556ffbd810dfb5-10892214',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- baseBlockHeader.inc.tpl -->
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
                <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getHeaderTitleStyled();?>

            </td>
            <td id="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getActionId();?>
" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getActionsWidth();?>
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
<!-- /baseBlockHeader.inc.tpl -->