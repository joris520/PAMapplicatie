<!-- assessmentProcessDashboardDetailView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<tr>
    <td class="bottom_line">
        {$valueObject->getEmployeeName()}
    </td>
    {if $interfaceObject->showSelectDetails()}
    <td class="bottom_line">
        {DateConverter::display($valueObject->getAssessmentDate())}
    </td>
    {/if}
    {if $interfaceObject->showCalculationDetails()}
    <td class="bottom_line">
        {NumberConverter::display($valueObject->getScoreSum())}
    </td>
    <td class="bottom_line">
        {AssessmentProcessScoreRankingConverter::display($valueObject->getScoreRank())}
    </td>
    {/if}
    {if $interfaceObject->showEvaluationDetails()}
    <td class="bottom_line">
        {AssessmentProcessEvaluationRequestConverter::displayReport($valueObject->getEvaluationRequestStatus())}
    </td>
    {/if}
    {if $interfaceObject->showEvaluationStatusDetails()}
    <td class="bottom_line">
        {DateConverter::display($valueObject->getAssessmentEvaluationDate())}
    </td>
    <td class="bottom_line">
        {AssessmentEvaluationStatusConverter::displayReport($valueObject->getAssessmentEvaluationStatus())},
        {AssessmentProcessEvaluationRequestConverter::displayReport($valueObject->getEvaluationRequestStatus())}
    </td>
    {/if}

    <td class="bottom_line">
        &nbsp;
    </td>
</tr>
{if $interfaceObject->showDebug()}
<tr>
    <td colspan="100%">
        <pre>{print_r($valueObject, true)}</pre>
    </td>
</tr>
{/if}
<!-- /assessmentProcessDashboardDetailView.tpl -->