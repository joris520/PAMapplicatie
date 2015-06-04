<!-- documentClusterEdit.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
    <tr>
        <td class="form-label" style="width:150px;">
            <label for="cluster_name">{'ATTACHMENT_CLUSTER_NAME'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <input  id="cluster_name" name="cluster_name" type="text" size="30" value="{$valueObject->clusterName}">
        </td>
    </tr>
</table>
<!-- /documentClusterEdit.tpl -->