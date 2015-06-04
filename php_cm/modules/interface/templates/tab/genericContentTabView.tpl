<!-- genericContentTabView.tpl -->
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="total_panel">
            <div id="{$interfaceObject->getContentPanelHtmlId()}" style="width:{$interfaceObject->getDisplayWidth()}; margin-left:auto; margin-right:auto;">
                {$interfaceObject->getContentHtml()}
                <br />
            </div>
        </td>
    </tr>
</table>
<!-- /genericContentTabView.tpl -->