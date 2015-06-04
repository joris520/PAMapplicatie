<?php /* Smarty version Smarty-3.0.7, created on 2014-05-27 16:12:29
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/application/interface/templates\components/messages.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3235253849d4d765e97-26010469%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '03fcf617e876033547f4015a119f1196228321c6' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/application/interface/templates\\components/messages.tpl',
      1 => 1379954112,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3235253849d4d765e97-26010469',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- messages.tpl -->
<div class="messages">
    <ul>
    <?php  $_smarty_tpl->tpl_vars['message'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('messages')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['message']->key => $_smarty_tpl->tpl_vars['message']->value){
?>
        <li><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</li>
    <?php }} ?>
    </ul>
</div>
<!-- /messages.tpl -->