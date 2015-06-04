<!-- employeeAssessmentEdit.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table border="0" cellspacing="0" cellpadding="6" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="form-label" style="width:150px;">
            <label for="assessment_date">{'CONVERSATION_DATE'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            {$interfaceObject->getAssessmentDatePicker()}
        </td>
    </tr>
    {if $interfaceObject->isViewAllowedScoreStatus()}
    <tr>
        <td class="form-label">
            <label for="score_status">{'SCORE_STATUS'|TXT_UCF}</label>
        </td>
        <td class="form-value">
            {if $interfaceObject->isEditAllowedScoreStatus()}
            {include    file='components/selectImageRadioComponent.tpl'
                        values=ScoreStatusValue::values()
                        currentValue=$valueObject->getScoreStatus()
                        required=true
                        inputName='score_status'
                        converter='ScoreStatusConverter'}
            {else}
            {ScoreStatusConverter::display($valueObject->getScoreStatus())}
            {/if}
        </td>
    </tr>
    {if $interfaceObject->isEditAllowedScoreStatus() && $interfaceObject->showAssessmentNote()}

    <tr>
        <td class="form-label" style="width:120px;">
            <label for="assessment_note">{'REMARKS'|TXT_UCF}</label>
        </td>
        <td class="form-value">
            <textarea id="assessment_note" name="assessment_note" style="height:50px;" cols="60">{*altijd nieuwe opmerking $valueObject->getAssessmentNote()*}</textarea>
        </td>
    </tr>
    {/if}
    {/if}
</table>
<!-- /employeeAssessmentEdit.tpl -->