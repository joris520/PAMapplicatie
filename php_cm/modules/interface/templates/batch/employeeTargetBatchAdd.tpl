<!-- employeeTargetBatchAdd.tpl -->
<table cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="form-label" style="width: 150px;">
            <label for="target_name">{'TARGET'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <input id="target_name" name="target_name" size="50" type="text" value="" />
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="performance_indicator">{'KPI'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <input id="performance_indicator" name="performance_indicator" size="50" type="text" value="" />
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="end_date">{'TARGET_END_DATE'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            {$interfaceObject->getEndDatePicker()}
        </td>
    </tr>
</table>
<br/>
<p>{'SELECT'|TXT_UCW} {'EMPLOYEES'|TXT_UCW} {$interfaceObject->getRequiredFieldIndicator()}</p>
{$interfaceObject->getEmployeesSelectorHtml()}
<br/>
<!-- /employeeTargetBatchAdd.tpl -->