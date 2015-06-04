<!-- departmentView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{if $interfaceObject->hiliteRow()}
    {assign var='new_row_indicator' value='class="short_hilite"'}
{else}
    {assign var='new_row_indicator' value=''}
{/if}
<tr {$new_row_indicator} id="detail_row_{$valueObject->getId()}" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
    <td class="bottom_line">
        {$valueObject->departmentName}
    </td>
    <td class="bottom_line centered icon-link">
        <strong>{NumberConverter::display($valueObject->getCountedEmployees())}</strong>
        <span class="warning-text" {NumberConverter::conditional($valueObject->getCountedInactiveEmployees(), '', TXT_UCF('ARCHIVED_EMPLOYEES'))}</span>&nbsp;<span class="activeRow icon-style">{$interfaceObject->getEmployeeDetailLink()}</span>
    </td>
    <td class="bottom_line centered icon-link">
        <strong>{NumberConverter::display($valueObject->countedUsers)}</strong>&nbsp; <span class="activeRow icon-style">{$interfaceObject->getUserDetailLink()}</span>
    </td>
    <td class="bottom_line actions">
        {$interfaceObject->getEditLink()}&nbsp;{$interfaceObject->getRemoveLink()}
    </td>
</tr>
<!-- /departmentView.tpl -->