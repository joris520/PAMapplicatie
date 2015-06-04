<?php /* Smarty version Smarty-3.0.7, created on 2013-09-23 18:40:44
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\base/baseBlockHeaderRow.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1230152406f0c177343-74946966%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c7599f9ee6125f6a459850f7b1c7645d36ba48c3' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\base/baseBlockHeaderRow.tpl',
      1 => 1379954116,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1230152406f0c177343-74946966',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- baseBlockHeaderRow.tpl -->
<?php if ($_smarty_tpl->getVariable('interfaceObject')->value->hiliteRow()){?>
    <?php $_smarty_tpl->tpl_vars['new_row_indicator'] = new Smarty_variable('class="short_hilite"', null, null);?>
<?php }else{ ?>
    <?php $_smarty_tpl->tpl_vars['new_row_indicator'] = new Smarty_variable('', null, null);?>
<?php }?>
    <tr <?php echo $_smarty_tpl->getVariable('new_row_indicator')->value;?>
>
        <td>
            <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getContentInterfaceObject()->fetchHtml();?>

        </td>
        <td id="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getActionId();?>
" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getActionsWidth();?>
; text-align:right">
            <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getActionLinks();?>

        </td>
    </tr>

<!-- /baseBlockHeaderRow.tpl -->