<!-- employeeAssessmentEvaluationDelete.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<p>{$interfaceObject->getConfirmQuestion()}</p>
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="bottom_line form-label" style="width:200px;">{'EVALUATION_DATE'|TXT_UCF}</td>
        <td class="bottom_line form-value">{DateConverter::display($valueObject->getAssessmentEvaluationDate())}</td>
    </tr>
    <tr>
        <td class="content-label">{'ASSESSMENT_EVALUATION_STATUS'|TXT_UCF} :</td>
        <td class="content-value">{AssessmentEvaluationStatusConverter::display($valueObject->getAssessmentEvaluationStatus())}</td>
    </tr>
    <tr>
        <td class="content-label">{'EVALUATION_ATTACHMENT'|TXT_UCF} :</td>
        <td class="content-value">{$interfaceObject->getAttachmentLink()}</td>
    </tr>
</table>
<!-- /employeeAssessmentEvaluationDelete.tpl -->