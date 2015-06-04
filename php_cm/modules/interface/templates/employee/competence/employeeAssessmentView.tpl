<!-- employeeAssessmentView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table  class="content-table employee" style="width:{$interfaceObject->getDisplayWidth()};">
    {if $valueObject->hasAssessment()}
    <tr>
        <td class="content-label"  style="width:150px;">
            {'CONVERSATION_DATE'|TXT_UCF}:
        </td>
        <td class="content-value">
            {DateConverter::display($valueObject->getAssessmentDate(), TXT_UCF('NO_ASSESSMENT_DATE'))}
        </td>
    </tr>
    {if $interfaceObject->isViewAllowedScoreStatus()}
    <tr>
        <td class="content-label">
            {'SCORE_STATUS'|TXT_UCF}:
        </td>
        <td class="content-value">
            {ScoreStatusConverter::display($valueObject->getScoreStatus())}
        </td>
    </tr>
    {if $interfaceObject->showAssessmentNote()}
        {assign var=assessmentNote value=$valueObject->getAssessmentNote()}
        {if !empty($assessmentNote)}
        <tr>
            <td class="content-label">
                {'REMARKS'|TXT_UCF}:
            </td>
            <td class="content-value">
                {$assessmentNote|nl2br}
            </td>
        </tr>
        {/if}
    {/if}
    {/if}
    {else}
    <tr>
        <td class="content-label"  style="width:150px;">
            {'ASSESSMENT'|TXT_UCF}:
        </td>
        <td class="content-value">
            {'NO_ASSESSMENT_DONE'|TXT_UCF}
        </td>
    </tr>
    {/if}
    {if $interfaceObject->showSelfAssessment()}
    <tr>
        <td class="content-label" style="width:150px;">
            {'SELF_ASSESSMENT'|TXT_UCF}:
        </td>
        <td class="content-value">
            {SelfAssessmentInvitationStateConverter::display($interfaceObject->getSelfAssessmentState())}
            {if $interfaceObject->showCompletedStatus()}
            {AssessmentInvitationCompletedConverter::image($interfaceObject->getCompletedStatus())}
            {AssessmentInvitationCompletedConverter::displayReport($interfaceObject->getCompletedStatus())}
            {/if}
        </td>
    </tr>
    {/if}
</table>
<!-- /employeeAssessmentView.tpl -->