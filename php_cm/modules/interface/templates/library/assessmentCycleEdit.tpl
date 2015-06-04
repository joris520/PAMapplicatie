<!-- assessmentCycleEdit.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="form-label" style="width:150px;">
            <label for="cycle_name">{'NAME'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <input id="cycle_name" name="cycle_name" type="text" value="{$valueObject->getAssessmentCycleName()}" />
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="start_date">{'START_DATE'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            {$interfaceObject->getStartDatePicker()}
        </td>
    </tr>
</table>
<!-- /assessmentCycleEdit.tpl -->
