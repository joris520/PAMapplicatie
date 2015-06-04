<!-- pdpActionSelectClusterView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{assign var=radioId     value='pdp_action_selector_'|cat:$valueObject->getId()}
<tr>
    <td>
        <input type="radio"
               onClick="{$interfaceObject->getSelectLink()}"
               name="ID_PDPAID"
               id="{$radioId}"
               value="{$valueObject->getId()}"{if $interfaceObject->isSelected()} checked="checked"{/if}>
        <label for="{$radioId}">{$valueObject->getActionName()}</label>
    </td>
    <td>
        {$valueObject->getProvider()}
    </td>
    <td>
        {$valueObject->getDuration()}
    </td>
    <td>
        {PdpCostConverter::display($valueObject->getCost())}
    </td>
</tr>
<!-- /pdpActionSelectClusterView.tpl -->