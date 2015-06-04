<!-- assessmentCycleDetail.tpl -->
{assign var=detailInterfaceObject value=$interfaceObject->getInterfaceObject()}
{* todo: style naar css *}
<table style="width:{$interfaceObject->getDisplayWidth()};" border="0" cellspacing="0" cellpadding="2" class="border1px">
    <tr>
        <td>
            {$detailInterfaceObject->fetchHtml()}
        </td>
    </tr>
</table>
<!-- /assessmentCycleDetail.tpl -->