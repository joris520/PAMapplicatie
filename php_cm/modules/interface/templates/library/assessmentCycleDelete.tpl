<!-- assessmentCycleDelete.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<p>{$interfaceObject->getConfirmQuestion()}</p>
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="bottom_line form-label" style="width:150px;">
            {'EVALUATION_PERIOD'|TXT_UCF}
        </td>
        <td class="bottom_line form-value">
            {$valueObject->getAssessmentCycleName()}
        </td>
    </tr>
    <tr>
        <td class="bottom_line form-label">
            {'START_DATE'|TXT_UCF}
        </td>
        <td class="bottom_line form-value">
            {DateConverter::display($valueObject->getStartDate())}
        </td>
    </tr>
</table>
<!-- /assessmentCycleDelete.tpl -->