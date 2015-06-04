<!-- employeeTargetAdd.tpl -->
<table border="0" cellspacing="0" cellpadding="4" style="width:{$interfaceObject->getDisplayWidth()}">
    <tr>
        <td class="form-label" style="width:150px;">
            <label for="target_name">{'TARGET'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <input id="target_name" name="target_name" size="80" type="text" value="" />
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="performance_indicator">{'KPI'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <input id="performance_indicator" name="performance_indicator" size="80" type="text" value="" />
        </td>
    </tr>
    </tr>
        <td class="form-label">
            <label for="end_date">{'TARGET_END_DATE'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">{$interfaceObject->getEndDatePicker()}
        </td>
    </tr>
    {if $interfaceObject->isAddAllowedEvaluation()}
    <tr>
        <td colspan="100%">&nbsp;</td>
    </tr>
    <tr>
        <td class="form-label"><label for="status">{'TARGET_STATUS'|TXT_UCF}</label></td>
        <td class="form-value">
            <select id="status" name="status">
            {include    file         = 'components/selectOptionsComponent.tpl'
                        values       = EmployeeTargetStatusValue::values()
                        currentValue = NULL
                        required     = false
                        converter    = 'EmployeeTargetStatusConverter'}
            </select>
        </td>
    </tr>
    {/if}
</table>
<!-- /employeeTargetAdd.tpl -->
