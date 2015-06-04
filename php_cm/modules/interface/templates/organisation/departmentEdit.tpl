<!-- departmentEdit.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table border="0" cellspacing="0" cellpadding="4" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="form-label" style="width:150px;">
            <label for="cluster_name">{'DEPARTMENT'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <input  id="department_name" name="department_name" type="text" size="50" value="{$valueObject->departmentName}">
        </td>
    </tr>
</table>
<!-- /departmentEdit.tpl -->