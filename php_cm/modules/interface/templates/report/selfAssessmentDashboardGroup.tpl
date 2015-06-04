<!-- selfAssessmentDashboardGroup.tpl -->
{assign var=iconNotCompleted  value=AssessmentInvitationCompletedConverter::image(AssessmentInvitationCompletedValue::NOT_COMPLETED)}
{assign var=iconCompleted     value=AssessmentInvitationCompletedConverter::image(AssessmentInvitationCompletedValue::COMPLETED)}
<table class="dashboard" cellspacing="0" cellpadding="0" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <th class="alternate">&nbsp;</th>
        <th style="width:100px;">&nbsp;</th>
        <th style="width:20px;" class="seperator">&nbsp;</th>
        <th class="alternate" colspan="2">&nbsp;</th>
        <th colspan="2">&nbsp;</th>
        <th style="width:80px;" class="alternate">&nbsp;</th>
    </tr>
    <tr>
        <th class="alternate">&nbsp;</th>
        <th>&nbsp;</th>
        <th class="seperator">&nbsp;</th>
        <th class="alternate" colspan="2">{'DASHBOARD_COMPLETED_BY_EMPLOYEE'|TXT_LC}</th>
        <th colspan="2">{'DASHBOARD_COMPLETED_BY_MANAGER'|TXT_LC}</th>
        <th class="alternate">{'DASHBOARD_COMPLETED_BY_BOTH'|TXT_LC}</th>
    </tr>
    <tr>
        <th class="last alternate">{'MANAGER'|TXT_LC}</th>
        <th class="last">{'INVITED'|TXT_LC}</th>
        <th class="seperator">&nbsp;</th>
        <th style="width:80px;" class="last alternate">{$iconNotCompleted}&nbsp;{'NO'|TXT_LC}</th>
        <th style="width:80px;" class="last alternate">{$iconCompleted}&nbsp;{'YES'|TXT_LC}</th>
        <th style="width:80px;" class="last">{$iconNotCompleted}&nbsp;{'NO'|TXT_LC}</th>
        <th style="width:80px;" class="last">{$iconCompleted}&nbsp;{'YES'|TXT_LC}</th>
        <th class="last alternate">{$iconCompleted}&nbsp;{$iconCompleted}</th>
    </tr>
    {* per boss de rij tonen *}
    {if $interfaceObject->getCount()>0}
    {foreach $interfaceObject->getInterfaceObjects() as $viewObject}
        {$viewObject->fetchHtml()}
    {/foreach}
    {* de totaal rij tonen *}
    <tr>
        <td class="last alternate">&nbsp;</td>
        <td class="last">&nbsp;</td>
        <td class="seperator">&nbsp;</td>
        <td class="last alternate">&nbsp;</td>
        <td class="last alternate">&nbsp;</td>
        <td class="last">&nbsp;</td>
        <td class="last">&nbsp;</td>
        <td class="last alternate">&nbsp;</td>
    </tr>
    {if $interfaceObject->showTotals()}
    <tr style="text-align:center; font-weight:bold;" id="detail_dashboard_totals" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
        <td class="last alternate">
            {'DASHBOARD_TOTALS'|TXT_UC}
        </td>
        <td class="last icon-link">
            {$interfaceObject->getInvitedTotal()}
            &nbsp;<span class="activeRow icon-style">{$interfaceObject->getInvitedDetailLink()}</span>
        </td>
        <td class="last seperator">&nbsp;</td>
        <td class="last icon-link alternate row-not-completed">
            {$interfaceObject->getEmployeeNotCompleted()}
            &nbsp;<span class="activeRow icon-style">{$interfaceObject->getEmployeeNotCompletedDetailLink()}
        </td>
        <td class="last icon-link alternate row-completed">
           {$interfaceObject->getEmployeeCompleted()+$interfaceObject->getEmployeeDeleted()}
           &nbsp;<span class="activeRow icon-style">{$interfaceObject->getEmployeeCompletedDetailLink()}
        </td>
        <td class="last icon-link row-not-completed">
            {$interfaceObject->getBossNotCompleted()}
            &nbsp;<span class="activeRow icon-style">{$interfaceObject->getBossNotCompletedDetailLink()}
        </td>
        <td class="last icon-link row-completed">
            {$interfaceObject->getBossCompleted()}
            &nbsp;<span class="activeRow icon-style">{$interfaceObject->getBossCompletedDetailLink()}
        </td>
        <td class="last icon-link alternate row-completed">
            {$interfaceObject->getBothCompleted()}
            &nbsp;<span class="activeRow icon-style">{$interfaceObject->getBothCompletedDetailLink()}
        </td>
    </tr>
    {/if}
    {else}
    <tr>
        <td class="last" colspan="100%">{$interfaceObject->displayEmptyMessage()}</td>
    </tr>
    {/if}
</table>
<br />
<!-- /selfAssessmentDashboardGroup.tpl -->