<!-- genericMenuTabView.tpl -->
<table border="0" cellspacing="0" cellpadding="0" width="100%" class="top_border1px">
    <tr>
        <td class="left_panel" style="width:{$interfaceObject->getDisplayWidth()}; min-width:{$interfaceObject->getDisplayWidth()};">
            <div id="{$interfaceObject->getMenuPanelHtmlId()}">
                {$interfaceObject->getMenuHtml()}
            </div>
        </td>
        <td class="right_panel">
            <div class="top_nav"></div>
            <div id="{$interfaceObject->getContentPanelHtmlId()}">
                {$interfaceObject->getContentHtml()}
            </div>
        </td>
    </tr>
</table>
<!-- /genericMenuTabView.tpl -->