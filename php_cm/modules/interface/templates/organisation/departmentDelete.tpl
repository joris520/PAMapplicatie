<!-- departmentDelete.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<p>{$interfaceObject->getConfirmQuestion()}</p>
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="bottom_line form-label" style="width:100px;">{'DEPARTMENT'|TXT_UCF}</td>
        <td class="bottom_line form-value">{$valueObject->departmentName}</td>
    </tr>
</table>

<!-- /departmentDelete.tpl -->