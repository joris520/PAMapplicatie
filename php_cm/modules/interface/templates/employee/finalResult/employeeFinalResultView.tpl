<!-- employeeFinalResultView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{assign var=assessmentCycleValueObject value=$valueObject->getAssessmentCycleValueObject()}
{assign var=previousValueObject value=$interfaceObject->getPreviousValueObject()}
{assign var=previousAssessmentCycleValueObject value=$previousValueObject->getAssessmentCycleValueObject()}
{assign var=commentIndentation value='margin-left:200px'}
<span id="{$interfaceObject->getToggleNotesHtmlId()}">
    <p class="info-text">
        {$interfaceObject->getInstructionText()}
    </p>
    <br/>
    <table  class="content-table  employee" style="width:{$interfaceObject->getDisplayWidth()};">
        </tr>
            <td class="form-label" style="width:200px;">
                {'CONVERSATION_DATE'|TXT_UCF}
            </td>
            <td class="form-value" colspan="3">
                {DateConverter::display($valueObject->getAssessmentDate())}
            </td>
        </tr>
        <tr>
            <td colspan="100%">&nbsp;</td>
        </tr>
        <tr style="text-align: left">
            <th class="" style="width:200px;">
                &nbsp;
            </th>
            <th class="shaded_title centered previous-period-header" style="width:200px;">
                {$previousAssessmentCycleValueObject->getAssessmentCycleName()}
            </th>
            <th class="shaded_title centered current-period-header" style="width:200px;">
                {$assessmentCycleValueObject->getAssessmentCycleName()}
            </th>
            <th class="actions">
                {if $interfaceObject->showRemarks()}
                    {$interfaceObject->getToggleNotesVisibilityLink()}
                {else}
                    &nbsp;
                {/if}
            </th>
        </tr>
        <tr style="text-align: left">
            <th class="shaded_title"  colspan="100%">
                {'FINAL_RESULT'|TXT_UCW}
            </th>
        </tr>
        <tr>
            <th class="content-line">
                {'TOTAL_RESULT'|TXT_UCF}
            </th>
            <td class="content-line centered previous-period">
                {TotalScoreConverter::display($previousValueObject->getTotalScore())}
            </td>
            <td class="content-line centered current-period">
                {TotalScoreConverter::display($valueObject->getTotalScore())}
            </td>
            <td class="content-line actions">
                {if $interfaceObject->showRemarks()}
                {if $valueObject->hasTotalScoreComment() || $previousValueObject->hasTotalScoreComment()}
                {$interfaceObject->getToggleNoteVisibilityLink(EmployeeFinalResultView::TOTAL_NOTE_NAME)}
                {/if}
                {/if}
            </td>
        </tr>
    {if $interfaceObject->showRemarks()}
        {if $valueObject->hasTotalScoreComment() && $previousValueObject->hasTotalScoreComment()}
        <tr class="comment-row" id="{$interfaceObject->getToggleNoteId(EmployeeFinalResultView::TOTAL_NOTE_NAME)}" {if !$interfaceObject->isInitialVisibleNotes()} style="display:none;"{/if}>
            <td class="content-line" colspan="100%">
                {if $valueObject->hasTotalScoreComment()}
                <div class="remarks-content" style="{$commentIndentation}; padding:10px;">
                    <strong>{$assessmentCycleValueObject->getAssessmentCycleName()}  {'REMARKS'|TXT_LC}</strong><br />
                    <span class="comment">{$valueObject->getTotalScoreComment()|nl2br}</span>
                </div>
                {/if}
                {if $previousValueObject->hasTotalScoreComment()}
                <div class="remarks-content" style="{$commentIndentation}; padding:10px;">
                    <strong>{$previousAssessmentCycleValueObject->getAssessmentCycleName()}  {'REMARKS'|TXT_LC}</strong><br />
                    <span class="comment">{$previousValueObject->getTotalScoreComment()|nl2br}</span>
                </div>
                {/if}
            </td>
        </tr>
        <tr>
            <td class="content-line" colspan="100%" >
            </td>
        </tr>
        {/if}
    {/if}
        {if $interfaceObject->showDetailScores()}
        <tr>
            <td colspan="100%">&nbsp;</td>
        </tr>
        <tr>
            <th class="content-line " style="padding-left: 30px;">
                {'BEHAVIOUR'|TXT_UCF}
            </th>
            <td class="content-line centered previous-period">
                {ScoreConverter::display($previousValueObject->getBehaviourScore())}
            </td>
            <td class="content-line centered current-period">
                {ScoreConverter::display($valueObject->getBehaviourScore())}
            </td>
            <td class="content-line actions">
                {if $interfaceObject->showRemarks()}
                {if $valueObject->hasBehaviourScoreComment() || $previousValueObject->hasBehaviourScoreComment()}
                {$interfaceObject->getToggleNoteVisibilityLink(EmployeeFinalResultView::BEHAVIOUR_NOTE_NAME)}
                {/if}
                {/if}
            </td>
        </tr>
        {if $interfaceObject->showRemarks()}
        {if $valueObject->hasBehaviourScoreComment() || $previousValueObject->hasBehaviourScoreComment()}
        <tr class="comment-row" id="{$interfaceObject->getToggleNoteId(EmployeeFinalResultView::BEHAVIOUR_NOTE_NAME)}" {if !$interfaceObject->isInitialVisibleNotes()} style="display:none;"{/if}>
            <td class="content-line" colspan="100%" >
                {if $valueObject->hasBehaviourScoreComment()}
                <div class="remarks-content" style="{$commentIndentation}; padding:10px;">
                    <strong>{$assessmentCycleValueObject->getAssessmentCycleName()}  {'REMARKS'|TXT_LC}</strong><br />
                    <span class="comment">{$valueObject->getBehaviourScoreComment()|nl2br}</span>
                </div>
                {/if}
                {if $previousValueObject->hasBehaviourScoreComment()}
                <div class="remarks-content" style="{$commentIndentation}; padding:10px;">
                    <strong>{$previousAssessmentCycleValueObject->getAssessmentCycleName()}  {'REMARKS'|TXT_LC}</strong><br />
                    <span class="comment">{$previousValueObject->getBehaviourScoreComment()|nl2br}</span>
                </div>
                {/if}
            </td>
        </tr>
        <tr>
            <td class="content-line" colspan="100%" >
            </td>
        </tr>
        {/if}
        {/if}
        <tr>
            <td colspan="100%">&nbsp;</td>
        </tr>
        <tr>
            <th class="content-line" style="padding-left: 30px;">
                {'RESULTS'|TXT_UCF}
            </th>
            <td class="content-line centered previous-period">
                {ScoreConverter::display($previousValueObject->getResultsScore())}
            </td>
            <td class="content-line centered current-period">
                {ScoreConverter::display($valueObject->getResultsScore())}
            </td>
            <td class="content-line actions">
                {if $interfaceObject->showRemarks()}
                {if $valueObject->hasResultsScoreComment() || $previousValueObject->hasResultsScoreComment()}
                {$interfaceObject->getToggleNoteVisibilityLink(EmployeeFinalResultView::RESULTS_NOTE_NAME)}
                {/if}
                {/if}
            </td>
        </tr>
        {if $interfaceObject->showRemarks()}
        {if $valueObject->hasResultsScoreComment() || $previousValueObject->hasResultsScoreComment()}
        <tr class="comment-row" id="{$interfaceObject->getToggleNoteId(EmployeeFinalResultView::RESULTS_NOTE_NAME)}" {if !$interfaceObject->isInitialVisibleNotes()} style="display:none;"{/if}>
            <td class="content-line" colspan="100%" >
                {if $valueObject->hasResultsScoreComment()}
                <div class="remarks-content" style="{$commentIndentation}; padding:10px;">
                    <strong>{$assessmentCycleValueObject->getAssessmentCycleName()}  {'REMARKS'|TXT_LC}</strong><br />
                    <span class="comment">{$valueObject->getResultsScoreComment()|nl2br}</span>
                </div>
                {/if}
                {if $previousValueObject->hasResultsScoreComment()}
                <div class="remarks-content" style="{$commentIndentation}; padding:10px;">
                    <strong>{$previousAssessmentCycleValueObject->getAssessmentCycleName()}  {'REMARKS'|TXT_LC}</strong><br />
                    <span class="comment">{$previousValueObject->getResultsScoreComment()|nl2br}</span>
                </div>
                {/if}
            </td>
        </tr>
        <tr>
            <td class="content-line" colspan="100%" >
            </td>
        </tr>
        {/if}
        {/if}
        {/if}
        <tr>
            <td colspan="100%">&nbsp;</td>
        </tr>
    </table>
</span>
<!-- /employeeFinalResultView.tpl -->