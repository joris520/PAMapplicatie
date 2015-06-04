<!-- employeeTargetBatchAddResult.tpl -->
<table style="width:{$interfaceObject->getDisplayWidth()};" border="0" cellspacing="0" cellpadding="4">
    <tr class="">
        <td class="bottom_line" width="350">{'RESULT_FOR_COLLECTIVELY_ADDING_TARGET'|TXT_UCF}: </td>
        <td class="bottom_line">{$interfaceObject->getTargetName()}</td>
    </tr>
    <tr class="">
        <td class="bottom_line">{'EMPLOYEES_DID_GET_A_NEW_TARGET'|TXT_UCF}: </td>
        <td class="bottom_line">{$interfaceObject->getEmployeeCount()}</td>
    </tr>
</table>
<!-- employeeTargetBatchAddResult.tpl -->