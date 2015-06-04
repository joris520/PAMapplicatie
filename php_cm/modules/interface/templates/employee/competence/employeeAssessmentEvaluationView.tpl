<!-- employeeAssessmentEvaluationView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table class="content-table employee" style="width:{$interfaceObject->getDisplayWidth()};" >
    {if $interfaceObject->showEvaluationStatus()}
    <tr>
        <td class="content-label" style="width:200px;">{'ASSESSMENT_EVALUATION_STATUS'|TXT_UCF}:</td>
        <td class="content-value">{$interfaceObject->getStatusIconHtml()} {$interfaceObject->getEvaluationStateLabel()}</td>
    </tr>
    {/if}
    {if $interfaceObject->showEvaluationDate()}
    <tr>
        <td class="content-label" style="width:200px;">{'EVALUATION_DATE'|TXT_UCF}:</td>
        <td class="content-value">{DateConverter::display($valueObject->getAssessmentEvaluationDate())}</td>
    </tr>
    {/if}
    {if $interfaceObject->showAttachmentLink()}
    <tr>
        <td class="content-label" style="width:200px;">{'EVALUATION_ATTACHMENT'|TXT_UCF}:</td>
        <td class="content-value">{$interfaceObject->getAttachmentLink()}</td>
    </tr>
    {/if}
</table>
<!-- /employeeAssessmentEvaluationView.tpl -->