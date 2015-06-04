<!-- employeeAssessmentEvaluationEdit.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table border="0" cellspacing="0" cellpadding="4" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="form-label" style="width:200px;">
            <label for="assessment_evaluation_date">{'EVALUATION_DATE'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            {$interfaceObject->getAssessmentEvaluationDatePicker()}
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="assessment_evaluation_status">{'ASSESSMENT_EVALUATION_STATUS'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <select name="assessment_evaluation_status">
            {include    file='components/selectOptionsComponent.tpl'
                        values=$interfaceObject->getAssessmentEvaluationStatusValues()
                        currentValue=$valueObject->getAssessmentEvaluationStatus()
                        required=true
                        converter='AssessmentEvaluationStatusConverter'}
            </select>
        </td>
    </tr>
    {if $interfaceObject->getShowUpload()}
    <tr>
        <td colspan="100%">
            <br />
            <strong>{'EVALUATION_ATTACHMENT'|TXT_UCF}</strong>
            <iframe id="upload_evaluation_attachment" class="border1px" src ="upload_evaluation_attachment.php" width="99%" frameBorder="0" >
                <p>Your browser does not support iframes.</p>
            </iframe>
        </td>
    </tr>
    {else}
    <tr>
        <td class="form-label">{'EVALUATION_ATTACHMENT'|TXT_UCF}</td>
        <td class="form-value">{$interfaceObject->getAttachmentLink()}</td>
    </tr>
    {/if}
</table>
<!-- /employeeAssessmentEvaluationEdit.tpl -->