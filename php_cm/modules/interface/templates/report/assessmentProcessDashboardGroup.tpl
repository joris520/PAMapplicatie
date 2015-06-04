<!-- assessmentProcessDashboardGroup.tpl -->
<br/>
<table class="dashboard" cellspacing="0" cellpadding="0" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <th class="alternate">&nbsp;</th>
        <th style="width:100px;">&nbsp;</th>
        <th class="seperator" style="width:20px;">&nbsp;</th>
        <th class="alternate last" colspan="13">{'DASHBOARD_PROGRESS'|TXT_LC}</th>
    </tr>
    <tr>
        <th class="alternate">&nbsp;</th>
        <th>&nbsp;</th>
        <th class="seperator">&nbsp;</th>
        <th class="alternate" style="width:70px;"><em>{'DASHBOARD_PHASE1'|TXT_LC}</em></th>
        <th style="width:70px;"><em>{'DASHBOARD_PHASE2'|TXT_LC}</em></th>
        <th class="alternate"style="width:70px;"><em>{'DASHBOARD_PHASE3'|TXT_LC}</em></th>
        <th class="seperator" style="width:20px;">&nbsp;</th>
        <th class="alternate" colspan="3"><em>{'DASHBOARD_PHASE3_EVALUATIONS'|TXT_LC}</em></th>
    </tr>
    <tr>
        <th class="last alternate">{'MANAGER'|TXT_LC}</th>
        <th class="last">{'INVITED'|TXT_LC}</th>
        <th class="seperator">&nbsp;</th>
        <th class="alternate last" title="{'DASHBOARD_PHASE1_DESCRIPTION'|TXT_UCF}">{'DASHBOARD_PHASE1_LABEL'|TXT_LC}</th>
        <th class="last" title="{'DASHBOARD_PHASE2_DESCRIPTION'|TXT_UCF}">{'DASHBOARD_PHASE2_LABEL'|TXT_LC}</th>
        <th class="alternate last" title="{'DASHBOARD_PHASE3_DESCRIPTION'|TXT_UCF}">{'DASHBOARD_PHASE3_LABEL'|TXT_LC}</th>
        <th class="seperator">&nbsp;</th>
        <th style="width:70px;" class="last alternate" title="{'DASHBOARD_PHASE3_NO_DESCRIPTION'|TXT_UCF}">{'DASHBOARD_PHASE3_NO_LABEL'|TXT_LC}</th>
        <th style="width:70px;" class="last alternate" title="{'DASHBOARD_PHASE3_PLANNED_DESCRIPTION'|TXT_UCF}">{'DASHBOARD_PHASE3_PLANNED_LABEL'|TXT_LC}</th>
        <th style="width:70px;" class="last alternate" title="{'DASHBOARD_PHASE3_READY_DESCRIPTION'|TXT_UCF}">{'DASHBOARD_PHASE3_READY_LABEL'|TXT_LC}</th>
    </tr>
    {if $interfaceObject->getCount()>0}
    {foreach $interfaceObject->getInterfaceObjects() as $viewObject}
        {$viewObject->fetchHtml()}
    {/foreach}
    <tr>
        <td class="last alternate">&nbsp;</td>
        <td class="last">&nbsp;</td>
        <td class="seperator">&nbsp;</td>
        <td class="last alternate">&nbsp;</td>
        <td class="last">&nbsp;</td>
        <td class="last alternate">&nbsp;</td>
        <td class="seperator">&nbsp;</td>
        <td class="last alternate" colspan="3">&nbsp;</td>
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
        <td class="last icon-link alternate">
            {$interfaceObject->getPhaseInvitedTotal()}
            &nbsp;<span class="activeRow icon-style">{$interfaceObject->getPhaseInvitedDetailLink()}</span>
        </td>
        <td class="last icon-link">
           {$interfaceObject->getPhaseSelectEvaluationTotal()}
           &nbsp;<span class="activeRow icon-style">{$interfaceObject->getPhaseSelectEvaluationLink()}</span>
        </td>
        <td class="last icon-link alternate">
            {$interfaceObject->getPhaseEvaluationTotal()}
            &nbsp;<span class="activeRow icon-style">{$interfaceObject->getPhaseEvaluationLink()}</span>
        </td>
        <td class="last seperator">&nbsp;</td>
        <td class="last icon-link alternate">
            {$interfaceObject->getEvaluationNotRequestedTotal()}
            &nbsp;<span class="activeRow icon-style">{$interfaceObject->getEvaluationNotRequestedDetailLink()}</span>
        </td>
        <td class="last icon-link alternate row-not-completed">
            {$interfaceObject->getEvaluationPlannedTotal()}
            &nbsp;<span class="activeRow icon-style">{$interfaceObject->getEvaluationPlannedDetailLink()}
        </td>
        <td class="last icon-link alternate row-completed">
            {NumberConverter::display(  $interfaceObject->getEvaluationDoneTotal() +
                                        $interfaceObject->getEvaluationDoneNotRequestedTotal() +
                                        $interfaceObject->getEvaluationCancelledTotal())}
            &nbsp;<span class="activeRow icon-style">{$interfaceObject->getEvaluationReadyDetailLink()}</span>
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
<!-- /assessmentProcessDashboardGroup.tpl -->