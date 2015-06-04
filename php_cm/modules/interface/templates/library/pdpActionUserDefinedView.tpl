<!-- pdpActionUserDefinedView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{if $interfaceObject->hiliteRow()}
    {assign var='new_row_indicator' value='class="short_hilite"'}
{else}
    {assign var='new_row_indicator' value=''}
{/if}

    <tr {$new_row_indicator} id="detail_row_{$valueObject->getEmployeePdpActionId()}" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
        <td class="" title="{'ORIGINAL_VALUE'|TXT_UCF}: {$valueObject->getActionName()}">
            <span class="{$interfaceObject->diff($valueObject->getActionName(),$valueObject->getUserDefinedActionName())}">
                {PdpActionNameConverter::display($valueObject->getUserDefinedActionName(), PdpActionNameConverter::EMPTY_LABEL, $valueObject->isUserDefined())}
            </span>
        </td>
        <td class="" title="{'ORIGINAL_VALUE'|TXT_UCF}: {$valueObject->getProvider()}">
            <span class="{$interfaceObject->diff($valueObject->getProvider(),$valueObject->getUserDefinedProvider())}">
                {$valueObject->getUserDefinedProvider()}
            </span>
        </td>
        <td class="" title="{'ORIGINAL_VALUE'|TXT_UCF}: {$valueObject->getDuration()}">
            <span class="{$interfaceObject->diff($valueObject->getDuration(),$valueObject->getUserDefinedDuration())}">
                {$valueObject->getUserDefinedDuration()}
            </span>
        </td>
        <td class="" style="text-align:right;" title="{'ORIGINAL_VALUE'|TXT_UCF}: {PdpCostConverter::display($valueObject->getCost())}">
            <span class="{$interfaceObject->diff($valueObject->getCost(),$valueObject->getUserDefinedCost())}">
                {PdpCostConverter::display($valueObject->getUserDefinedCost())}
            </span>
        </td>
        <td class=" centered icon-link">
            &nbsp;
        </td>
        <td class=" actions">
            {$interfaceObject->getActionLinks()}
        </td>
    </tr>
<!-- /pdpActionUserDefinedView.tpl -->