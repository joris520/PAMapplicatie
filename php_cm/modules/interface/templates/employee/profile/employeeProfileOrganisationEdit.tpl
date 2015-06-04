<!-- employeeProfileOrganisationEdit.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()}">
    <tr>
        <td class="form-label" style="width:220px;">
            <label for="department">{'DEPARTMENT'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            {assign var=departmentIdValues value=$interfaceObject->getDepartmentIdValues()}
            <select id="department" name="department">
                {include    file='components/selectIdValuesComponent.tpl'
                            idValues=$departmentIdValues
                            currentValue=$valueObject->getDepartmentId()
                            required=false
                            subject='DEPARTMENT'|TXT_LC}
            </select>
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="boss">{'BOSS'|TXT_UCF}</label>
        </td>
        <td class="form-value">
            {assign var=bossIdValues value=$interfaceObject->getBossIdValues()}
            <select id="boss" name="boss">
                {include    file='components/selectIdValuesComponent.tpl'
                            idValues=$bossIdValues
                            currentValue=$valueObject->getBossId()
                            required=false
                            subject='BOSS'|TXT_LC}
            </select>
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="boss">{'IS_SELECTABLE_AS_BOSS'|TXT_UCF}</label>
        </td>
        <td class="form-value">
            <input id="is_boss" name="is_boss" type="checkbox" {if $valueObject->hasSubordinates()} disabled="disabled"{/if} value="is_boss" {if $interfaceObject->isBossChecked()} checked{/if}/>
            {if $valueObject->hasSubordinates()}&nbsp;<em>({'BOSS_CURRENTLY_HAS_SUBORDINATES'|TXT_UCF})</em>{/if}
        </td>
    </tr>
    <tr>
        <td class="form-label">&nbsp;</td>
        <td class="form-value">&nbsp;</td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="phone_number_work">{'PHONE_WORK'|TXT_UCF}</label>
        </td>
        <td class="form-value">
            <input id="phone_number_work" name="phone_number_work" type="text" size="30" value="{$valueObject->getPhoneNumberWork()}">
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="employment_FTE">{'EMPLOYMENT_PERCENTAGE'|TXT_UCF}</label>
        </td>
        <td class="form-value">
            <input  id="employment_FTE" name="employment_FTE" type="text" size="30" maxlength="4" value="{EmployeeFteConverter::input($valueObject->getFte())}">
        </td>
    </tr>
    <tr>
        <td class="form-label" >
            <label for="employment_date">{'EMPLOYMENT_DATE'|TXT_UCF}</label>
        </td>
        <td class="form-value">
            {$interfaceObject->getEmploymentDatePicker()}
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="contract_state">{'CONTRACT_STATE'|TXT_UCF}</label>
        </td>
        <td class="form-value">
            <select name="contract_state">
            {include    file='components/selectOptionsComponent.tpl'
                        values=EmployeeContractStateValue::values()
                        currentValue=$valueObject->getContractState()
                        converter='EmployeeContractStateConverter'}
            </select>
        </td>
    </tr>
</table>
<!-- /employeeProfileOrganisationEdit.tpl -->