<!-- pdpActionClusterView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{if $interfaceObject->hiliteRow()}
    {assign var='new_row_indicator' value='class="short_hilite"'}
{else}
    {assign var='new_row_indicator' value=''}
{/if}

    <tr {$new_row_indicator} id="detail_row_{$valueObject->getId()}" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
        <td class="bottom_line">
            {$valueObject->getActionName()}
        </td>
        <td class="bottom_line">
            {$valueObject->getProvider()}
        </td>
        <td class="bottom_line">
            {$valueObject->getDuration()}
        </td>
        <td class="bottom_line" style="text-align:right;">
            {PdpCostConverter::display($valueObject->getCost())}
        </td>
        <td class="bottom_line centered icon-link">
            {NumberConverter::display($valueObject->getUsageCount())}&nbsp;<span class="activeRow icon-style">{$interfaceObject->getEmployeeDetailLink()}</span>
        </td>
        <td class="bottom_line actions">
            {$interfaceObject->getActionLinks()}
        </td>
    </tr>
<!-- /pdpActionClusterView.tpl -->