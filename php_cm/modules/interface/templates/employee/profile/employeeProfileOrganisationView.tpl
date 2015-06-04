<!-- employeeProfileOrganisationView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{assign var=styleLabelWidth value='style="width:220px;"'}
<table class="content-table employee" style="width:{$interfaceObject->getDisplayWidth()};" >
    <tr>
        <td class="content-label" {$styleLabelWidth}>{'DEPARTMENT'|TXT_UCF}:</td>
        <td class="content-value">{$valueObject->getDepartmentName()}</td>
    </tr>
    <tr>
        <td class="content-label">{'BOSS'|TXT_UCF}:</td>
        <td class="content-value">{NameConverter::display($valueObject->getBossEmployeeName())}</td>
    </tr>
    <tr>
        <td class="content-label">{'IS_SELECTABLE_AS_BOSS'|TXT_UCF}:</td>
        {assign var=subordinateDisplay value=EmployeeIsBossConverter::description($valueObject->getIsBossValue(), $valueObject->getBossSubordinateCount())}
        <td class="content-value">{EmployeeIsBossConverter::display($valueObject->getIsBossValue())}{if $valueObject->isBoss()}&nbsp;&nbsp;<em>{$subordinateDisplay}</em>{/if}</td>
    </tr>
    <tr>
        <td class="content-label">&nbsp;</td>
        <td class="content-value">&nbsp;</td>
    </tr>
    {assign var=phoneNumberWork value=$valueObject->getPhoneNumberWork()}
    {if !empty($phoneNumberWork)}
    <tr>
        <td class="content-label">{'PHONE_WORK'|TXT_UCF}:</td>
        <td class="content-value">{$phoneNumberWork}</td>
    </tr>
    {/if}
    {assign var=fte value=$valueObject->getFte()}
    {if !empty($fte)}
    <tr>
        <td class="content-label">{'EMPLOYMENT_PERCENTAGE'|TXT_UCF}:</td>
        <td class="content-value">{EmployeeFteConverter::display($fte)}</td>
    </tr>
    {/if}
    {assign var=employmentDate value=$valueObject->getEmploymentDate()}
    {if !empty($employmentDate)}
    <tr>
        <td class="content-label">{'EMPLOYMENT_DATE'|TXT_UCF}:</td>
        <td class="content-value">{DateConverter::display($employmentDate)}</td>
    </tr>
    {/if}
    {assign var=contractState value=$valueObject->getContractState()}
    {if !empty($contractState)}
    <tr>
        <td class="content-label">{'CONTRACT_STATE'|TXT_UCF}:</td>
        <td class="content-value">{EmployeeContractStateConverter::display($contractState)}</td>
    </tr>
    {/if}
</table>
<!-- /employeeProfileOrganisationView.tpl -->