<!-- employeePdpActionLibrarySelector.tpl -->
<table border="0" cellspacing="1" cellpadding="2">
    <tr>
        <td class="form-label" style="width:{$interfaceObject->getDisplayWidth()};">
            &nbsp;
        </td>
        <td class="form-value">
            <span id="{$interfaceObject->getToggleHtmlId()}">
                {$interfaceObject->getActionLinks()}
            </span>
            <div id="{$interfaceObject->getContentHtmlId()}" style="display:none; background-color:white;">
                {$interfaceObject->getInterfaceObject()->fetchHtml()}
            </div>
        </td>
    </tr>
</table>
<!-- /employeePdpActionLibrarySelector.tpl -->