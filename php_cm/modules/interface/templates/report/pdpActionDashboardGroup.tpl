<!-- pdpActionDashboardGroup.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{assign var=keyIdValues value=$interfaceObject->getKeyIdValues()}
{assign var=keyColCount value=count($keyIdValues)}
<table class="dashboard" cellspacing="0" cellpadding="0" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <th class="alternate" style="text-align:left; padding-top:10px;">&nbsp;</th>
        <th class="" colspan="2" style="padding-top:10px;">{'NUMBER_OF_EMPLOYEES'|TXT_UCF}</th>
        <th class="seperator" style="width:20px; padding-top:10px;">&nbsp;</th>
        <th class="" colspan="{$keyColCount}" style="padding-top:10px;" title="{'TITLE_NUMBER_OF_PDP_ACTIONS'|TXT_UCF}">{'NUMBER_OF_PDP_ACTIONS'|TXT_UCF}</th>
    </tr>
    <tr>
        <th class="last alternate" style="text-align:left; padding-top:10px;">{'MANAGER'|TXT_UCF}</th>
        <th class="last" style="width:80px; padding-top:10px;">{'REPORT_ALL_EMPLOYEES'|TXT_UCF}</th>
        <th class="last" style="width:130px; padding-top:10px;">{'NO_PDP_ACTIONS'|TXT_UCF}</th>
        <th class="seperator" style="width:20px; padding-top:10px;">&nbsp;</th>
        {foreach $keyIdValues as $keyIdValue}
            {assign var=keyLabel value=$keyIdValue->getValue()}
            {assign var=key value=$keyIdValue->getDatabaseId()}
            <th class="last{if $key == PdpActionCompletedStatusValue::NOT_COMPLETED_EXPIRED} alternate{/if}" style="padding-top:10px;">{$keyLabel}</th>
        {/foreach}
    </tr>
    {if $interfaceObject->getCount()>0}
    {foreach $interfaceObject->getInterfaceObjects() as $viewObject}
        {$viewObject->fetchHtml()}
    {/foreach}
    <tr>
        <td class="last alternate">&nbsp;</td>
        <td class="last" colspan="2" >&nbsp;</td>
        <td class="seperator">&nbsp;</td>
        {foreach $keyIdValues as $keyIdValue}
            {assign var=key value=$keyIdValue->getDatabaseId()}
            <td class="last{if $key == PdpActionCompletedStatusValue::NOT_COMPLETED_EXPIRED} alternate{/if}">&nbsp;</td>
        {/foreach}
    </tr>
    {if $interfaceObject->showTotals()}
    <tr style="text-align:center; font-weight:bold;" id="detail_dashboard_totals" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
        <td class="last alternate" style="text-align:left;">
            {'DASHBOARD_TOTALS'|TXT_UC}
        </td>
        <td class="last icon-link">
            {NumberConverter::display($valueObject->getEmployeesTotal())}
            &nbsp;<span class="last activeRow icon-style ">{$interfaceObject->getTotalDetailLink()}</span>
        </td>
        <td class="last icon-link">
            {NumberConverter::display($interfaceObject->getEmployeesWithout())}
            &nbsp;<span class="last activeRow icon-style ">{$interfaceObject->getWithoutDetailLink()}</span>
        </td>
        <td class="last seperator">&nbsp;</td>
        {foreach $keyIdValues as $keyIdValue}
        {assign var=key value=$keyIdValue->getDatabaseId()}
        <td class="last icon-link {if $key == PdpActionCompletedStatusValue::NOT_COMPLETED_EXPIRED} alternate{/if}">
            {NumberConverter::display($valueObject->getEmployeeCountForKey($key))}
            &nbsp;<span class="activeRow icon-style">{$interfaceObject->getKeyDetailLink($key)}
        </td>
        {/foreach}
    </tr>
    {/if}
    {else}
    <tr>
        <td class="last" colspan="100%">{$interfaceObject->displayEmptyMessage()}</td>
    </tr>
    {/if}
</table>
<!-- /pdpActionDashboardGroup.tpl -->