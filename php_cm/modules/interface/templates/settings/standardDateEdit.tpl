<!-- standardDateEdit.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="form-label" style="width:150px;">
            <label for="default_end_date">{'DEFAULT_END_DATE'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            {$interfaceObject->getDefaultEndDatePicker()}
        </td>
    </tr>
</table>
<!-- /standardDateEdit.tpl -->