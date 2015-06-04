<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 09:21:26
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\employee/pdpAction/employeePdpActionCompetenceSelector.tpl" */ ?>
<?php /*%%SmartyHeaderCode:30212556ffc760deaa9-67193853%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8db0fe62ccc94339e988ef88631a63d7410b8131' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\employee/pdpAction/employeePdpActionCompetenceSelector.tpl',
      1 => 1433243737,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '30212556ffc760deaa9-67193853',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeePdpActionCompetenceSelector.tpl -->
<table cellpadding="4">
    <tr>
        <td class="form-label" style="width:100px;">
            <?php echo TXT_UCF('COMPETENCES');?>

        </td>
        <td class="form-value">
            <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getRelatedCompetenceLabel();?>

        </td>
    </tr>
    <tr>
        <td class="form-label">
            &nbsp;
        </td>
        <td class="form-value" id="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getToggleHtmlId();?>
">
            <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getActionLinks();?>

        </td>
    </tr>
    <tr>
        <td class="form-label">
            &nbsp;
        </td>
        <td class="form-value">
            <div id="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getContentHtmlId();?>
" style="display:none; background-color:white;">
                <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getInterfaceObject()->fetchHtml();?>

            </div>
        </td>
    </tr>
</table>
<!-- /employeePdpActionCompetenceSelector.tpl -->