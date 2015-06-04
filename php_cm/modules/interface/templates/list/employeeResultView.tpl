<!-- employeeResultView.tpl -->
{assign var=employeeId value=$interfaceObject->getEmployeeId()}
    <tr id="rowLeftNav{$employeeId}" class="{if $interfaceObject->isSelected()}divLeftWbg{else}divLeftRow{/if}">
        {include file=$interfaceObject->getDetailTemplateFile()}
        <td class="dashed_line" id="leftNav{$employeeId}" style="padding: 3px 0px;">
        {if $interfaceObject->isAllowedArrowKeys()}
            <a id="link{$employeeId}" onclick="{$interfaceObject->getSelectOnClick()} selectRow('rowLeftNav{$employeeId}'); setCurrentRow({$employeeId});" >
        {else}
            <a id="link{$employeeId}" onclick="{$interfaceObject->getSelectOnClick()} selectRow('rowLeftNav{$employeeId}'); return false;" >
        {/if}
                <span id="{$interfaceObject->getEmployeeNameHtmlId()}{$employeeId}" >{$interfaceObject->getEmployeeName()}<span>
            </a>
        </td>
    </tr>
<!-- /employeeResultView.tpl -->