<!-- managerReportView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{assign var=userValueObject value=$valueObject->getManagerUserValueObject()}
{if $interfaceObject->hiliteRow()}
    {assign var='new_row_indicator' value='class="short_hilite"'}
{else}
    {assign var='new_row_indicator' value=''}
{/if}
<tr {$new_row_indicator} id="detail_row_{$valueObject->getId()}" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
    <td class="bottom_line">
        {$valueObject->getManagerName()}
    </td>
    <td class="bottom_line centered icon-link">
        {NumberConverter::display($valueObject->getSubordinatesCount())}&nbsp; <span class="activeRow icon-style">{$interfaceObject->getEmployeeDetailLink()}</span>
    </td>
    <td class="bottom_line{if !$userValueObject->isActive} inactive{/if}">
        {$userValueObject->login}
    </td>
    <td class="bottom_line centered{if !$userValueObject->isActive} inactive{/if}">
        {UserLevelConverter::display($userValueObject->userLevel)}
    </td>
    {assign var=accessAll value=$userValueObject->accessAllDepartments == 'ALWAYS_ACCESS_ALL_DEPARTMENTS'|constant}
    <td class="bottom_line centered {if !$accessAll}icon-link{/if}{if !$userValueObject->isActive} inactive{/if}">
        {if $accessAll}{'ALL_DEPARTMENTS'|TXT_UCF}
        {else}
        {NumberConverter::display($userValueObject->departmentCount)}&nbsp;<span class="activeRow icon-style">{$interfaceObject->getDepartmentDetailLink()}</span>
        {/if}
    </td>
</tr>
<!-- /managerReportView.tpl -->