<!-- selfAssessmentDashboardView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<tr style="text-align:center;" id="detail_dashboard_{$valueObject->getBossId()}" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
    <td class="alternate" style="text-align:left;">
        {NameConverter::display($valueObject->getBossName())}
    </td>
    <td class="icon-link">
        {NumberConverter::display($valueObject->getInvitedTotal())}
        &nbsp;<span class="activeRow icon-style">{$interfaceObject->getInvitedDetailLink()}</span>
    </td>
    <td class="seperator">&nbsp;</td>
    <td class="alternate icon-link row-not-completed">
        {NumberConverter::display($valueObject->getEmployeeNotCompleted())}
        &nbsp;<span class="activeRow icon-style">{$interfaceObject->getEmployeeNotCompletedDetailLink()}
    </td>
    <td class="alternate icon-link row-completed">
        {NumberConverter::display($valueObject->getEmployeeCompleted())}
       {if $valueObject->getEmployeeDeleted()>0}&nbsp;(+{NumberConverter::display($valueObject->getEmployeeDeleted())}X){/if}
       &nbsp;<span class="activeRow icon-style">{$interfaceObject->getEmployeeCompletedDetailLink()}
    </td>
    <td class="icon-link row-not-completed">
        {NumberConverter::display($valueObject->getBossNotCompleted())}
        &nbsp;<span class="activeRow icon-style">{$interfaceObject->getBossNotCompletedDetailLink()}
    </td>
    <td class="icon-link row-completed">
        {NumberConverter::display($valueObject->getBossCompleted())}
        &nbsp;<span class="activeRow icon-style">{$interfaceObject->getBossCompletedDetailLink()}
    </td>
    <td class="alternate icon-link row-completed">
        {NumberConverter::display($valueObject->getBothCompleted())}
        &nbsp;<span class="activeRow icon-style">{$interfaceObject->getBothCompletedDetailLink()}
    </td>
</tr>
{if $interfaceObject->showDebug()}
<tr>
    <td colspan="100%">
        <pre>{print_r($valueObject, true)}</pre>
    </td>
</tr>
{/if}
<!-- selfAssessmentDashboardView.tpl -->