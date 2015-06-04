<!-- employeePdpActionEdit.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table border="0" cellspacing="2" cellpadding="4" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td>
            {$interfaceObject->getPdpActionLibrarySelector()->fetchHtml()}
        </td>
    </tr>
    {* enzovoorts (maw: nog niet af ;-) *}
</table>
<!-- /employeePdpActionEdit.tpl -->