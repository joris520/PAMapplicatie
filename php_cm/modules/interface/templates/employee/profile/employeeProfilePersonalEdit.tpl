<!-- employeeProfilePersonalEdit.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()}">
    <tr>
        <td class="form-label" style="width:150px;">
            <label for="firstname">{'FIRST_NAME'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <input id="firstname" name="firstname" type="text" size="30" value="{$valueObject->getFirstname()}">
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="lastname">{'LAST_NAME'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <input id="lastname" name="lastname" type="text" size="30" value="{$valueObject->getLastname()}">
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="SN">{'SOCIAL_NUMBER'|TXT_UCF}</label>
        </td>
        <td class="form-value">
            <input id="SN" name="SN" type="text" size="30" value="{$valueObject->getBsn()}">
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="sex">{'GENDER'|TXT_UCF}</label>
        </td>
        <td class="form-value">
            {include    file='components/selectRadioComponent.tpl'
                        inputName='sex'
                        values=EmployeeGenderValue::values()
                        currentValue=$valueObject->getGender()
                        converter='EmployeeGenderConverter'}
        </td>
    </tr>
    <tr>
        <td class="form-label" >
            <label for="birth_date">{'DATE_OF_BIRTH'|TXT_UCF}</label>
        </td>
        <td class="form-value">
            {$interfaceObject->getBirthDatePicker()}
        </td>
    </tr>
    <tr>
        <td class="form-label" >
            <label for="nationality">{'NATIONALITY'|TXT_UCF}</label>
        </td>
        <td class="form-value">
            <input id="nationality" name="nationality" type="text" size="30" value="{$valueObject->getNationality()}">
        </td>
    </tr>
    <tr>
        <td class="form-label">&nbsp;</td>
        <td class="form-value">&nbsp;</td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="email_address">{'E_MAIL_ADDRESS'|TXT_UCF}{if $interfaceObject->isEmailRequired()} {$interfaceObject->getRequiredFieldIndicator()}{/if}</label>
        </td>
        <td class="form-value">
            <input id="email_address" name="email_address" type="text" size="30" value="{$valueObject->getEmailAddress()}">
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="street">{'STREET'|TXT_UCF}</label>
        </td>
        <td class="form-value">
            <input id="street" name="street" type="text" size="30" value="{$valueObject->getStreet()}">
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="postal_code">{'ZIP_CODE'|TXT_UCF}</label>
        </td>
        <td class="form-value">
            <input id="postal_code" name="postal_code" type="text" size="30" value="{$valueObject->getPostcode()}">
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="city">{'CITY'|TXT_UCF}</label>
        </td>
        <td class="form-value">
            <input id="city" name="city" type="text" size="30" value="{$valueObject->getCity()}">
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="phone_number">{'TELEPHONE_NUMBER'|TXT_UCF}</label>
        </td>
        <td class="form-value">
            <input id="phone_number" name="phone_number" type="text" size="30" value="{$valueObject->getPhoneNumber()}">
        </td>
    </tr>
</table>
<!-- /employeeProfilePersonalEdit.tpl -->