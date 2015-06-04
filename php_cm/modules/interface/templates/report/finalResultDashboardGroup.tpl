<!-- finalResultDashboardGroup.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{assign var=keyIdValues value=$interfaceObject->getKeyIdValues()}
{assign var=scoreColCount value=count($keyIdValues)}
<table class="dashboard" cellspacing="0" cellpadding="0" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <th class="last alternate" style="text-align:left; padding-top:10px;">{'MANAGER'|TXT_UCF}</th>
        <th class="last" style="width:100px; padding-top:10px;">{'EMPLOYEES'|TXT_UCF}</th>
        <th class="seperator" style="width:20px; padding-top:10px;">&nbsp;</th>
        {foreach $keyIdValues as $keyIdValue}
            {assign var=scoreLabel value=$keyIdValue->getValue()}
            {assign var=key value=$keyIdValue->getDatabaseId()}
            <th class="last{if $valueObject->isNotAssessedScoreId($key)} alternate{/if}" style="padding-top:10px;">{$scoreLabel}</th>
        {/foreach}
    </tr>
    {if $interfaceObject->getCount()>0}
    {foreach $interfaceObject->getInterfaceObjects() as $viewObject}
        {$viewObject->fetchHtml()}
    {/foreach}
    <tr>
        <td class="last alternate">&nbsp;</td>
        <td class="last">&nbsp;</td>
        <td class="seperator">&nbsp;</td>
        {foreach $keyIdValues as $keyIdValue}
            {assign var=key value=$keyIdValue->getDatabaseId()}
            <td class="last{if $valueObject->isNotAssessedScoreId($key)} alternate{/if}">&nbsp;</td>
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
        <td class="last seperator">&nbsp;</td>
        {foreach $keyIdValues as $keyIdValue}
        {assign var=key value=$keyIdValue->getDatabaseId()}
        <td class="last icon-link {if $valueObject->isNotAssessedScoreId($key)} alternate{/if}">
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
<!-- /finalResultDashboardGroup.tpl -->