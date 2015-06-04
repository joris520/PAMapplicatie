<!-- baseReportPeriodDatesEdit.tpl -->
<table border="0" cellspacing="0" cellpadding="4" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="form-label">
            <label for="start_date">{'START_DATE'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            {$interfaceObject->getStartDatePicker()}
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="end_date">{'END_DATE'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            {$interfaceObject->getEndDatePicker()}
        </td>
    </tr>
</table>

<!-- /baseReportPeriodDatesEdit.tpl -->