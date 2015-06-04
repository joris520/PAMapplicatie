<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 09:18:48
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\employee/profile/employeeProfilePersonalView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17207556ffbd825ed82-11249817%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3fd6897607ec6cb96446a5e49fb7c295a1a9bad5' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\employee/profile/employeeProfilePersonalView.tpl',
      1 => 1433243739,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17207556ffbd825ed82-11249817',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeeProfilePersonalView.tpl -->
<?php $_smarty_tpl->tpl_vars['valueObject'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getValueObject(), null, null);?>
<?php $_smarty_tpl->tpl_vars['styleLabelWidth'] = new Smarty_variable('style="width:220px;"', null, null);?>
<table class="content-table employee" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
;" >
    <tr>
        <td class="content-label" <?php echo $_smarty_tpl->getVariable('styleLabelWidth')->value;?>
><?php echo TXT_UCF('EMPLOYEE_NAME');?>
:</td>
        <td class="content-value"><?php echo EmployeeNameConverter::display($_smarty_tpl->getVariable('valueObject')->value->getFirstname(),$_smarty_tpl->getVariable('valueObject')->value->getLastname());?>
</td>
        <td class="" rowspan="9" style="width:250px;">
            <?php $_smarty_tpl->tpl_vars['displayablePhoto'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getDisplayablePhoto(), null, null);?>
            <?php if (!empty($_smarty_tpl->getVariable('displayablePhoto',null,true,false)->value)){?>
            <?php $_smarty_tpl->tpl_vars['deletePhotoLink'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getDeletePhotoLink(), null, null);?>
            <table>
                <tr id="employee_photo" <?php if (!empty($_smarty_tpl->getVariable('deletePhotoLink',null,true,false)->value)){?>onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);"<?php }?>>
                    <td>
                        <div style="padding: 4px; margin:10px;">
                            <img src="<?php echo $_smarty_tpl->getVariable('displayablePhoto')->value;?>
" alt="<?php echo TXT_UCF('PHOTO_EMPLOYEE');?>
" width="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getPhotoWidth();?>
" height="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getPhotoHeight();?>
">
                        </div>
                    </td>
                    <td>
                        <span class="activeRow"><?php echo $_smarty_tpl->getVariable('deletePhotoLink')->value;?>
</span>
                    </td>
                </tr>
            </table>
            <?php }else{ ?>
                <span title="<?php echo TXT_UCF('NO_CURRENT_PHOTO');?>
">&nbsp;</span>
            <?php }?>
        </td>
    </tr>
    <?php $_smarty_tpl->tpl_vars['extraRows'] = new Smarty_variable(0, null, null);?>
    <?php $_smarty_tpl->tpl_vars['bsn'] = new Smarty_variable($_smarty_tpl->getVariable('valueObject')->value->getBsn(), null, null);?>
    <?php if (!empty($_smarty_tpl->getVariable('bsn',null,true,false)->value)){?>
    <tr>
        <td class="content-label"><?php echo TXT_UCF('SOCIAL_NUMBER');?>
:</td>
        <td class="content-value"><?php echo $_smarty_tpl->getVariable('bsn')->value;?>
</td>
    </tr>
    <?php }else{ ?>
        <?php $_smarty_tpl->tpl_vars['extraRows'] = new Smarty_variable($_smarty_tpl->getVariable('extraRows')->value+1, null, null);?>
    <?php }?>
    <?php $_smarty_tpl->tpl_vars['gender'] = new Smarty_variable($_smarty_tpl->getVariable('valueObject')->value->getGender(), null, null);?>
    <?php if (!empty($_smarty_tpl->getVariable('gender',null,true,false)->value)){?>
    <tr>
        <td class="content-label"><?php echo TXT_UCF('GENDER');?>
:</td>
        <td class="content-value"><?php echo EmployeeGenderConverter::display($_smarty_tpl->getVariable('gender')->value);?>
</td>
    </tr>
    <?php }else{ ?>
        <?php $_smarty_tpl->tpl_vars['extraRows'] = new Smarty_variable($_smarty_tpl->getVariable('extraRows')->value+1, null, null);?>
    <?php }?>
    <?php $_smarty_tpl->tpl_vars['birthDate'] = new Smarty_variable($_smarty_tpl->getVariable('valueObject')->value->getBirthDate(), null, null);?>
    <?php if (!empty($_smarty_tpl->getVariable('birthDate',null,true,false)->value)){?>
    <tr>
        <td class="content-label"><?php echo TXT_UCF('DATE_OF_BIRTH');?>
:</td>
        <td class="content-value"><?php echo $_smarty_tpl->getVariable('birthDate')->value;?>
</td>
    </tr>
    <?php }else{ ?>
        <?php $_smarty_tpl->tpl_vars['extraRows'] = new Smarty_variable($_smarty_tpl->getVariable('extraRows')->value+1, null, null);?>
    <?php }?>
    <?php $_smarty_tpl->tpl_vars['nationality'] = new Smarty_variable($_smarty_tpl->getVariable('valueObject')->value->getNationality(), null, null);?>
    <?php if (!empty($_smarty_tpl->getVariable('nationality',null,true,false)->value)){?>
    <tr>
        <td class="content-label"><?php echo TXT_UCF('NATIONALITY');?>
:</td>
        <td class="content-value"><?php echo $_smarty_tpl->getVariable('valueObject')->value->getNationality($_smarty_tpl->getVariable('nationality')->value);?>
</td>
    </tr>
    <?php }else{ ?>
        <?php $_smarty_tpl->tpl_vars['extraRows'] = new Smarty_variable($_smarty_tpl->getVariable('extraRows')->value+1, null, null);?>
    <?php }?>
    <tr>
        <td class="content-label">&nbsp;</td>
        <td class="content-value">&nbsp;</td>
    </tr>
    <?php $_smarty_tpl->tpl_vars['emailAddress'] = new Smarty_variable($_smarty_tpl->getVariable('valueObject')->value->getEmailAddress(), null, null);?>
    <?php if (!empty($_smarty_tpl->getVariable('emailAddress',null,true,false)->value)){?>
    <tr>
        <td class="content-label"><?php echo TXT_UCF('E_MAIL_ADDRESS');?>
:</td>
        <td class="content-value"><?php echo $_smarty_tpl->getVariable('emailAddress')->value;?>
</td>
    </tr>
    <?php }else{ ?>
        <?php $_smarty_tpl->tpl_vars['extraRows'] = new Smarty_variable($_smarty_tpl->getVariable('extraRows')->value+1, null, null);?>
    <?php }?>
    <?php $_smarty_tpl->tpl_vars['street'] = new Smarty_variable($_smarty_tpl->getVariable('valueObject')->value->getStreet(), null, null);?>
    <?php $_smarty_tpl->tpl_vars['postcode'] = new Smarty_variable($_smarty_tpl->getVariable('valueObject')->value->getPostcode(), null, null);?>
    <?php $_smarty_tpl->tpl_vars['city'] = new Smarty_variable($_smarty_tpl->getVariable('valueObject')->value->getCity(), null, null);?>
    <?php if (!empty($_smarty_tpl->getVariable('street',null,true,false)->value)||!empty($_smarty_tpl->getVariable('postcode',null,true,false)->value)||!empty($_smarty_tpl->getVariable('city',null,true,false)->value)){?>
    <tr>
        <td class="content-label"><?php echo TXT_UCF('ADDRESS');?>
:</td>
        <td class="content-value">
            <?php echo $_smarty_tpl->getVariable('street')->value;?>
<br/>
            <?php echo $_smarty_tpl->getVariable('postcode')->value;?>
<?php if (!empty($_smarty_tpl->getVariable('postcode',null,true,false)->value)){?>&nbsp;&nbsp;<?php }?><?php echo $_smarty_tpl->getVariable('city')->value;?>

        </td>
    </tr>
    <?php }else{ ?>
        <?php $_smarty_tpl->tpl_vars['extraRows'] = new Smarty_variable($_smarty_tpl->getVariable('extraRows')->value+1, null, null);?>
    <?php }?>
    <?php $_smarty_tpl->tpl_vars['phoneNumber'] = new Smarty_variable($_smarty_tpl->getVariable('valueObject')->value->getPhoneNumber(), null, null);?>
    <?php if (!empty($_smarty_tpl->getVariable('phoneNumber',null,true,false)->value)){?>
    <tr>
        <td class="content-label"><?php echo TXT_UCF('TELEPHONE_NUMBER');?>
:</td>
        <td class="content-value"><?php echo $_smarty_tpl->getVariable('phoneNumber')->value;?>
</td>
    </tr>
    <?php }else{ ?>
        <?php $_smarty_tpl->tpl_vars['extraRows'] = new Smarty_variable($_smarty_tpl->getVariable('extraRows')->value+1, null, null);?>
    <?php }?>
    <?php if (!empty($_smarty_tpl->getVariable('displayablePhoto',null,true,false)->value)){?>
    <?php $_smarty_tpl->tpl_vars['extraRow'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['extraRow']->step = 1;$_smarty_tpl->tpl_vars['extraRow']->total = (int)ceil(($_smarty_tpl->tpl_vars['extraRow']->step > 0 ? $_smarty_tpl->getVariable('extraRows')->value+1 - (1) : 1-($_smarty_tpl->getVariable('extraRows')->value)+1)/abs($_smarty_tpl->tpl_vars['extraRow']->step));
if ($_smarty_tpl->tpl_vars['extraRow']->total > 0){
for ($_smarty_tpl->tpl_vars['extraRow']->value = 1, $_smarty_tpl->tpl_vars['extraRow']->iteration = 1;$_smarty_tpl->tpl_vars['extraRow']->iteration <= $_smarty_tpl->tpl_vars['extraRow']->total;$_smarty_tpl->tpl_vars['extraRow']->value += $_smarty_tpl->tpl_vars['extraRow']->step, $_smarty_tpl->tpl_vars['extraRow']->iteration++){
$_smarty_tpl->tpl_vars['extraRow']->first = $_smarty_tpl->tpl_vars['extraRow']->iteration == 1;$_smarty_tpl->tpl_vars['extraRow']->last = $_smarty_tpl->tpl_vars['extraRow']->iteration == $_smarty_tpl->tpl_vars['extraRow']->total;?>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <?php }} ?>
    <?php }?>
</table>
<!-- /employeeProfilePersonalView.tpl -->