<!-- standardDateView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table class="content-table" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="form-label" style="width:200px;">
            {'DEFAULT_END_DATE'|TXT_UCF}
        </td>
        <td class="form-value">
            {DateConverter::display($valueObject->defaultEndDate)}
        </td>
    </tr>
</table>
<!-- /standardDateView.tpl -->