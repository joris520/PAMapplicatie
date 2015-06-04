<!-- targetDashboardView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{assign var=keyIdValues value=$interfaceObject->getKeyIdValues()}
<tr style="text-align:center;" id="detail_dashboard_{$valueObject->getBossId()}" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
    <td class="alternate" style="text-align:left;">
        {NameConverter::display($valueObject->getBossName())}
    </td>
    <td class="icon-link">
        {NumberConverter::display($valueObject->getEmployeesTotal())}
        &nbsp;<span class="activeRow icon-style">{$interfaceObject->getTotalDetailLink()}</span>
    </td>
    <td class="icon-link">
        {NumberConverter::display($valueObject->getEmployeesWithout())}
        &nbsp;<span class="activeRow icon-style">{$interfaceObject->getWithoutDetailLink()}</span>
    </td>
    <td class="seperator">&nbsp;</td>
    {foreach $keyIdValues as $keyIdValue}
    {assign var=keyId value=$keyIdValue->getDatabaseId()}
    <td class="icon-link {if $keyId == EmployeeTargetStatusValue::NO_STATUS_EXPIRED} alternate{/if}">
        {NumberConverter::display($valueObject->getEmployeeCountForKey($keyId))}
        &nbsp;<span class="activeRow icon-style">{$interfaceObject->getKeyDetailLink($keyId)}
    </td>
    {/foreach}
</tr>
{if $interfaceObject->showDebug()}
<tr>
    <td colspan="100%">
        <pre>{print_r($valueObject, true)}</pre>
    </td>
</tr>
{/if}
<!-- /targetDashboardView.tpl -->