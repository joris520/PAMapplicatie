<!-- organisationInfoEdit.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="form-label" style="width:150px;"><label for="company_info">{'COMPANY_INFORMATION'|TXT_UCF}</label></td>
        <td class="form-value">
            <textarea rows="10" cols="80" name="company_info" id="company_info">{$valueObject->infoText}</textarea>
        </td>
    </tr>
</table>
<!-- /organisationInfoEdit.tpl -->