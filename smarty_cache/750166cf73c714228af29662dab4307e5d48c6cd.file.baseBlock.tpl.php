<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 09:18:47
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\base/baseBlock.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5585556ffbd7f27f10-93636839%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '750166cf73c714228af29662dab4307e5d48c6cd' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\base/baseBlock.tpl',
      1 => 1433243578,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5585556ffbd7f27f10-93636839',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- baseBlock.tpl -->
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

<?php $_template = new Smarty_Internal_Template('base/baseBlockHeader.inc.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<?php $_smarty_tpl->tpl_vars['dataInterfaceObject'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getDataInterfaceObject(), null, null);?>
<div class="application-content block-data<?php echo $_smarty_tpl->getVariable('headerClass')->value;?>
<?php echo $_smarty_tpl->getVariable('noFooterClass')->value;?>
" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
;">
    <?php echo $_smarty_tpl->getVariable('dataInterfaceObject')->value->fetchHtml();?>

</div>
<!-- /baseBlock.tpl -->