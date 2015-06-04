<!-- assessmentProcessDashboardView.tpl -->
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
    {assign var=phaseInvited value=$valueObject->getPhaseInvited()}
    <td class="alternate icon-link{if $phaseInvited > 0} row-current{/if}">
        {NumberConverter::display($phaseInvited)}
        &nbsp;<span class="activeRow icon-style">{$interfaceObject->getPhaseInvitedDetailLink()}
    </td>
    {assign var=phaseSelectEvaluation value=$valueObject->getPhaseSelectEvaluation()}
    <td class="icon-link{if $phaseSelectEvaluation > 0} row-current{/if}">
        {NumberConverter::display($phaseSelectEvaluation)}
        &nbsp;<span class="activeRow icon-style">{$interfaceObject->getPhaseSelectEvaluationLink()}
    </td>
    {assign var=phaseEvaluation value=$valueObject->getPhaseEvaluation()}
    <td class="alternate icon-link{if $phaseEvaluation > 0} row-current{/if}">
        {NumberConverter::display($phaseEvaluation)}
        &nbsp;<span class="activeRow icon-style">{$interfaceObject->getPhaseEvaluationLink()}
    </td>
    {if $phaseEvaluation > 0}
        {assign var=evaluationNoneAttributes value='class="alternate icon-link"'}
        {assign var=evaluationPlannedAttributes value='class="alternate icon-link row-not-completed"'}
        {assign var=evaluationDoneAttributes value='class="alternate icon-link row-completed"'}
    {else}
        {assign var=evaluationNoneAttributes value='class="icon-link"'}
        {assign var=evaluationPlannedAttributes value='class="icon-link"'}
        {if $valueObject->getEvaluationDoneNotRequested() > 0}
        {assign var=evaluationDoneAttributes value='class="icon-link row-done-not-requested"'}
        {else}
        {assign var=evaluationDoneAttributes value='class="icon-link"'}
        {/if}
    {/if}
    <td class="seperator">&nbsp;</td>
    <td {$evaluationNoneAttributes}>
        {NumberConverter::display($valueObject->getEvaluationNotRequested())}
        &nbsp;<span class="activeRow icon-style">{$interfaceObject->getEvaluationNotRequestedDetailLink()}
    </td>
    <td {$evaluationPlannedAttributes}>
        {NumberConverter::display($valueObject->getEvaluationPlanned())}
        &nbsp;<span class="activeRow icon-style">{$interfaceObject->getEvaluationPlannedDetailLink()}
    </td>
    <td {$evaluationDoneAttributes}>
        {NumberConverter::display(  $valueObject->getEvaluationDone() +
                                    $valueObject->getEvaluationDoneNotRequested() +
                                    $valueObject->getEvaluationCancelled())}
        &nbsp;<span class="activeRow icon-style">{$interfaceObject->getEvaluationReadyDetailLink()}
    </td>
</tr>
{if $interfaceObject->showDebug()}
<tr>
    <td colspan="100%">
        <pre>{print_r($valueObject, true)}</pre>
    </td>
</tr>
{/if}
<!-- /assessmentProcessDashboardView.tpl -->