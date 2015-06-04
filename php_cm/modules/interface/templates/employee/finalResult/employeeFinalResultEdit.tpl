<!-- employeeFinalResultEdit.tpl -->
{assign var=valueObject         value=$interfaceObject->getValueObject()}
{assign var=totalScoreEditType  value=$interfaceObject->getTotalScoreEditType()}
<span id="{$interfaceObject->getToggleNotesHtmlId()}">
    <table cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()}">
        </tr>
            <th class="form-label" style="width:150px;">
                <label for="assessment_date">{'CONVERSATION_DATE'|TXT_UCW} {$interfaceObject->getRequiredFieldIndicator()}</label>
            </th>
            <td class="form-value" style="width:650px;">
                {$interfaceObject->getAssessmentDatePicker()}
            </td>
            <td class="actions"    style="width:50px;">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td colspan="100%">&nbsp;</td>
        </tr>
        <tr style="text-align: left">
            <th class="shaded_title"  colspan="2">
                {'FINAL_RESULT'|TXT_UCW}
            </th>
            <th class="shaded_title actions">
                {if $interfaceObject->showRemarks()}
                    {$interfaceObject->getToggleNotesVisibilityLink()}
                {else}
                    &nbsp;
                {/if}
            </th>
        </tr>
        <tr>
            <td class="form-label">{'TOTAL_RESULT'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</td>
            <td class="form-value">
                {if $totalScoreEditType == TotalScoreEditType::SELECT_LIST}
                {assign var=totalScores value=$interfaceObject->getTotalScoreIdValues()}
                <select id="total_score" name="total_score">
                    {include    file='components/selectIdValuesComponent.tpl'
                                idValues=$totalScores
                                currentValue=$valueObject->getTotalScore()
                                required=true
                                subject='FINAL_RESULT'|TXT_LC}
                </select>
                {elseif $totalScoreEditType == TotalScoreEditType::RADIO_BUTTONS}
                {include    file='components/finalResultEditComponent.tpl'
                            scaleType=ScaleValue::SCALE_1_5
                            inputName='total_score'
                            isEmptyAllowed=false
                            score=$valueObject->getTotalScore()}
                {/if}
            </td>
            <td class="actions">
                {if $interfaceObject->showRemarks()}
                    {$interfaceObject->getToggleNoteVisibilityLink(EmployeeFinalResultEdit::TOTAL_NOTE_NAME)}
                {/if}
            </td>
        </tr>
        {if $interfaceObject->showRemarks()}
        <tr id="{$interfaceObject->getToggleNoteId(EmployeeFinalResultEdit::TOTAL_NOTE_NAME)}" class="comment-row" {if !$interfaceObject->isInitialVisibleNotes()}style="display:none;"{/if}>
            <td class="form_value" colspan="100%" style="padding-left:69px;">
                <textarea id="total_score_comment" name="total_score_comment" style="height:100px; width:690px">{$valueObject->getTotalScoreComment()}</textarea>
            </td>
        </tr>
        {/if}
        {if $interfaceObject->showDetailScores()}
        <tr>
            <td class="form-label" style="padding-left: 30px">{'BEHAVIOUR'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</td>
            <td class="form-value">
                {include    file='components/scoreEditComponent.tpl'
                            scaleType=ScaleValue::SCALE_1_5
                            inputName='behaviour_score'
                            isEmptyAllowed=false
                            score=$valueObject->getBehaviourScore()}
            </td>
            <td class="actions">
                {if $interfaceObject->showRemarks()}
                    {$interfaceObject->getToggleNoteVisibilityLink(EmployeeFinalResultEdit::BEHAVIOUR_NOTE_NAME)}
                {/if}
            </td>
        </tr>
        {if $interfaceObject->showRemarks()}
        <tr id="{$interfaceObject->getToggleNoteId(EmployeeFinalResultEdit::BEHAVIOUR_NOTE_NAME)}" class="comment-row" {if !$interfaceObject->isInitialVisibleNotes()}style="display:none;"{/if}>
            <td class="form_value" colspan="100%" style="padding-left:69px;">
                <textarea id="behaviour_score_comment" name="behaviour_score_comment" style="height:100px; width:690px">{$valueObject->getBehaviourScoreComment()}</textarea>
            </td>
        </tr>
        {/if}
        <tr>
            <td class="form-label" style="padding-left: 30px">{'RESULTS'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</td>
            <td class="form-value">
                {include    file='components/scoreEditComponent.tpl'
                            scaleType=ScaleValue::SCALE_1_5
                            inputName='results_score'
                            isEmptyAllowed=false
                            score=$valueObject->getResultsScore()}
            </td>
            <td class="actions">
                {if $interfaceObject->showRemarks()}
                    {$interfaceObject->getToggleNoteVisibilityLink(EmployeeFinalResultEdit::RESULTS_NOTE_NAME)}
                {/if}
            </td>
        </tr>
        {if $interfaceObject->showRemarks()}
        <tr id="{$interfaceObject->getToggleNoteId(EmployeeFinalResultEdit::RESULTS_NOTE_NAME)}" class="comment-row" {if !$interfaceObject->isInitialVisibleNotes()}style="display:none;"{/if}>
            <td class="form_value" colspan="100%" style="padding-left:69px;">
                <textarea id="results_score_comment" name="results_score_comment" style="height:100px; width:690px">{$valueObject->getResultsScoreComment()}</textarea>
            </td>
        </tr>
        {/if}
        {/if}
    </table>
</span>
<!-- /employeeFinalResultEdit.tpl -->