<!-- employeeProfileUserEdit.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()}">
    <tr>
        <td class="form-label" style="width:150px;">
            <label for="username">{'USERNAME'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <input id="username" name="username" type="text" size="30" value="">
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="password">{'PASSWORD'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <input id="password" name="password" type="password" size="30" value="">
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="email_address">{'E_MAIL_ADDRESS'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <input id="email_address" name="email_address" type="text" size="30" value="{$valueObject->getEmailAddress()}">
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="user_level">{'SECURITY'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <select name="user_level">
            {include    file='components/selectOptionsComponent.tpl'
                        values=UserLevelValue::values($interfaceObject->getUserLevelMode())
                        subject='SECURITY'|TXT_LC
                        converter='UserLevelConverter'}
            </select>
        </td>
    </tr>
</table>
<!-- /employeeProfileUserEdit.tpl -->