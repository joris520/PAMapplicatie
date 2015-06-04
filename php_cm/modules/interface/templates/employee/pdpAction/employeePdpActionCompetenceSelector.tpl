<!-- employeePdpActionCompetenceSelector.tpl -->
<table cellpadding="4">
    <tr>
        <td class="form-label" style="width:100px;">
            {'COMPETENCES'|TXT_UCF}
        </td>
        <td class="form-value">
            {$interfaceObject->getRelatedCompetenceLabel()}
        </td>
    </tr>
    <tr>
        <td class="form-label">
            &nbsp;
        </td>
        <td class="form-value" id="{$interfaceObject->getToggleHtmlId()}">
            {$interfaceObject->getActionLinks()}
        </td>
    </tr>
    <tr>
        <td class="form-label">
            &nbsp;
        </td>
        <td class="form-value">
            <div id="{$interfaceObject->getContentHtmlId()}" style="display:none; background-color:white;">
                {$interfaceObject->getInterfaceObject()->fetchHtml()}
            </div>
        </td>
    </tr>
</table>
<!-- /employeePdpActionCompetenceSelector.tpl -->