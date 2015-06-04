<!-- employeeProfileInformationEdit.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()}">
    <tr>
        <td class="form-label" style="width:150px;">
            <label for="education_level">{'EDUCATION_LEVEL'|TXT_UCF}</label>
        </td>
        <td class="form-value">
            <select name="education_level">
            {include    file='components/selectOptionsComponent.tpl'
                        values=EmployeeEducationLevelValue::values()
                        currentValue=$valueObject->getEducationLevel()
                        converter='EmployeeEducationLevelConverter'}
            </select>
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="additional_info">{'ADDITIONAL_INFO'|TXT_UCF}</label>
        </td>
        <td class="form-value">
            <textarea id="additional_info" name="additional_info" style="height:60px;" cols="60">{$valueObject->getAdditionalInfo()}</textarea>
        </td>
    </tr>
    {if $interfaceObject->isEditAllowedManagerInfo()}
    <tr>
        <td class="form-label">
            <label for="manager_info">{'MANAGERS_COMMENTS'|TXT_UCF}</label>
        </td>
        <td class="form-value">
            <textarea id="manager_info" name="manager_info" style="height:60px;" cols="60">{$valueObject->getManagerInfo()}</textarea>
        </td>
    </tr>
    {/if}
</table>
<!-- /employeeProfileInformationEdit.tpl -->