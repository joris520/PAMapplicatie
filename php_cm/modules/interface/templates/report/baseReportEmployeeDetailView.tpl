<!-- baseReportEmployeeDetailView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<tr>
    <td class="bottom_line {if $valueObject->isInactive()} warning-text inactive" title="{'EMPLOYEE_DELETED'|TXT_UCF}{/if}">
        {$valueObject->getEmployeeName()}
    </td>
    <td class="bottom_line">
        {$valueObject->getFunctionName()}
    </td>
    <td class="bottom_line">
        {$valueObject->getDepartmentName()}
    </td>
    {if $interfaceObject->showCount()}
    <td class="bottom_line centered" >
        {$valueObject->getReportCount()}
    </td>
    {/if}
</tr>
<!-- /baseReportEmployeeDetailView.tpl -->