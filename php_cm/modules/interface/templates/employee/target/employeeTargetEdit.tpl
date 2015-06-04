<!-- employeeTargetEdit.tpl -->
{assign var=valueObject                 value=$interfaceObject->getValueObject()}
{if $interfaceObject->showLabel()}
<h2>{'TARGET'|TXT_UCW}</h2>
{/if}
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="form-label" style="width:150px;">
            <label for="target_name">{'TARGET'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            {if $interfaceObject->isEditAllowedTarget()}
                <input id="target_name" name="target_name" size="80" type="text" value="{$valueObject->getTargetName()}" />
            {else}
                {$valueObject->getTargetName()}
            {/if}
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="performance_indicator">{'KPI'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            {if $interfaceObject->isEditAllowedTarget()}
                <input id="performance_indicator" name="performance_indicator" size="80" type="text" value="{$valueObject->getPerformanceIndicator()}" />
            {else}
                {$valueObject->getPerformanceIndicator()}
            {/if}
        </td>
    </tr>
    </tr>
        <td class="form-label">
            <label for="end_date">{'TARGET_END_DATE'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            {if $interfaceObject->isEditAllowedTarget()}
                {$interfaceObject->getEndDatePicker()}
            {else}
                {DateUtils::convertToDisplayDate($valueObject->getEndDate())}
            {/if}
        </td>
    </tr>
</table>
{if $interfaceObject->isViewAllowedEvaluation()}
{if $interfaceObject->showLabel()} {* beetje redundant, maar toch *}
<h2>{'EVALUATION'|TXT_UCW}</h2>
{/if}
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="form-label">
            <label for="status">{'TARGET_STATUS'|TXT_UCF}</label>
        </td>
        <td class="form-value">
            {if $interfaceObject->isEditAllowedEvaluation()}
                <select id="status" name="status">
                {include    file         = 'components/selectOptionsComponent.tpl'
                            values       = EmployeeTargetStatusValue::values()
                            currentValue = $valueObject->getStatus()
                            required     = false
                            converter    = 'EmployeeTargetStatusConverter'}
                </select>
            {else}
                {EmployeeTargetStatusConverter::image($valueObject->getStatus())}&nbsp;{EmployeeTargetStatusConverter::display($valueObject->getStatus())}
            {/if}
        </td>
    </tr>
    </tr>
        <td class="form-label" style="width:150px;">
            <label for="evaluation_date">{'CONVERSATION_DATE'|TXT_UCF}</label>
        </td>
        <td class="form-value">
            {if $interfaceObject->isEditAllowedEvaluation()}
                {$interfaceObject->getEvaluationDatePicker()}
            {else}
                {DateUtils::convertToDisplayDate($valueObject->getEvaluationDate())}
            {/if}
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="evaluation">{'EVALUATION'|TXT_UCF}</label>
        </td>
        <td class="form-value">
            {if $interfaceObject->isEditAllowedEvaluation()}
                <textarea id="evaluation" rows="4" cols="60" name="evaluation">{$valueObject->getEvaluation()}</textarea>
            {else}
                {$valueObject->getEvaluation()|nl2br}
            {/if}
        </td>
    </tr>
</table>
{/if}
<!-- /employeeTargetEdit.tpl -->
