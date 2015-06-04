<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 09:22:41
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/application/interface/templates\navigation/libraryMenuPam4.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1525556ffcc13e8f84-00960790%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '10f57f25eda0cef757f0d08b1929a54d5999cbc1' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/application/interface/templates\\navigation/libraryMenuPam4.tpl',
      1 => 1433243548,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1525556ffcc13e8f84-00960790',
  'function' => 
  array (
    'activeClass' => 
    array (
      'parameter' => 
      array (
        'menuName' => '',
      ),
      'compiled' => '',
    ),
  ),
  'has_nocache_code' => 0,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- libraryMenuPam4.tpl -->
<?php if (!function_exists('smarty_template_function_activeClass')) {
    function smarty_template_function_activeClass($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->template_functions['activeClass']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
<?php if ($_smarty_tpl->getVariable('active')->value==constant($_smarty_tpl->getVariable('menuName')->value)){?>active-menu-item<?php }?><?php if ($_smarty_tpl->getVariable('lastModule')->value==constant($_smarty_tpl->getVariable('menuName')->value)){?> last<?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>

<div class="application-content block-menu">
    <table class="tab-menu">
        <tr>
        <?php if ($_smarty_tpl->getVariable('showCompetences')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_COMPETENCES'));?>
"
                onclick="xajax_moduleCompetence(1);return false;">
                <a href=""><?php echo TXT_TAB('COMPETENCES');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showJobProfiles')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_JOB_PROFILES'));?>
"
                onclick="xajax_moduleFunctions(1);return false;">
                <a href=""><?php echo TXT_TAB('JOB_PROFILES');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showScales')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_SCALES'));?>
"
                onclick="xajax_moduleOptions_scales();return false;">
                <a href=""><?php echo TXT_TAB('NORM');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showQuestions')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_QUESTIONS'));?>
"
                onclick="xajax_public_library__displayQuestions();return false;">
                <a href=""><?php echo TXT_TAB('QUESTIONS');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showAssessmentCycle')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_ASSESSMENT_CYCLE'));?>
"
                onclick="xajax_public_library__displayAssessmentCycles();return false;">
                <a href=""><?php echo TXT_TAB('ASSESSMENT_CYCLES');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showDepartments')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_LIBRARY_DEPARTMENTS'));?>
"
                onclick="xajax_public_library__displayDepartments();return false;">
                <a href=""><?php echo TXT_TAB('DEPARTMENTS');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showDocumentClusters')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_DOCUMENT_CLUSTERS'));?>
"
                onclick="xajax_public_library__displayDocumentClusters();return false;">
                <a href=""><?php echo TXT_TAB('ATTACHMENT_CLUSTERS');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showPdpActionLib')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_PDP_ACTION_LIB'));?>
"
                onclick="xajax_public_library__displayPdpActions();return false;">
                <a href=""><?php echo TXT_TAB('PDP_ACTION_LIBRARY');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showPdpTaskLib')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_PDP_TASK_LIB'));?>
"
                onclick="xajax_modulePDPTaskLibrary();return false;">
                <a href=""><?php echo TXT_TAB('PDP_TASK_LIBRARY');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showPdpTaskOwner')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_PDP_TASK_OWNER'));?>
"
                onclick="xajax_modulePDPTaskOwnerLibrary();return false;">
                <a href=""><?php echo TXT_TAB('PDP_TASK_OWNER');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showEmails')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_EMAILS'));?>
"
                onclick="xajax_moduleEmails_displayExternalEmailAddresses();return false;">
                <a href=""><?php echo TXT_TAB('EMAILS');?>
</a>
            </td>
        <?php }?>
        </tr>
    </table>
</div>
<!-- /libraryMenuPam4.tpl -->