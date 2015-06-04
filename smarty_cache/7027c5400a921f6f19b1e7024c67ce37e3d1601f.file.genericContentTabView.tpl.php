<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 09:18:56
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\tab/genericContentTabView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:25981556ffbe097e4b6-26349807%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7027c5400a921f6f19b1e7024c67ce37e3d1601f' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\tab/genericContentTabView.tpl',
      1 => 1433243589,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '25981556ffbe097e4b6-26349807',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- genericContentTabView.tpl -->
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="total_panel">
            <div id="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getContentPanelHtmlId();?>
" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
; margin-left:auto; margin-right:auto;">
                <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getContentHtml();?>

                <br />
            </div>
        </td>
    </tr>
</table>
<!-- /genericContentTabView.tpl -->