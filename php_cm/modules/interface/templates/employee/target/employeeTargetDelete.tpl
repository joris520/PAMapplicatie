<!-- employeeTargetDelete.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<p>{$interfaceObject->getConfirmQuestion()}</p>
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()}">
    <tr>
        <td class="bottom_line form-label" style="width:150px;">{'TARGET'|TXT_UCF}</td>
        <td class="bottom_line form-value">
            {$valueObject->getTargetName()}
        </td>
    </tr>
    <tr>
        <td class="bottom_line form-label">{'KPI'|TXT_UCF}</td>
        <td class="bottom_line form-value">
            {$valueObject->getPerformanceIndicator()}
        </td>
    </tr>
    <tr>
        <td class="bottom_line form-label">{'END_DATE'|TXT_UCF}</td>
        <td class="bottom_line form-value">
            {DateConverter::display($valueObject->getEndDate())}
        </td>
    </tr>
</table>
<!-- /employeeTargetDelete.tpl -->