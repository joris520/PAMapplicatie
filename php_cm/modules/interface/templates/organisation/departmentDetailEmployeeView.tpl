<!-- departmentDetailEmployeeView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<tr>
    <td class="bottom_line{if !$valueObject->isActive()} warning-text inactive" title="{'EMPLOYEE_DELETED'|TXT_UCF}{/if}">
        {EmployeeNameConverter::displaySortable($valueObject->getFirstName(), $valueObject->getLastName())}
    </td>
    <td class="bottom_line">
        {$valueObject->getFunctionName()}
    </td>
    <td class="bottom_line">
        {$valueObject->getDepartmentName()}
    </td>
</tr>
<!-- /departmentDetailEmployeeView.tpl -->