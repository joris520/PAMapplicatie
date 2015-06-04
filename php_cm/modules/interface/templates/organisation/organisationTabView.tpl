<!-- organisationTabView.tpl -->
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="left_panel" style="width:{$interfaceObject->getDisplayWidth()}; min-width:{$interfaceObject->getDisplayWidth()};">
            <div id="organisation_menu_panel">
                {$interfaceObject->getMenuHtml()}
            </div>
        </td>
        <td class="right_panel">
            <div class="top_nav"></div>
            <div id="organisation-content">
                {$interfaceObject->getContentHtml()}
            </div>
        </td>
    </tr>
</table>
<!-- /organisationTabView.tpl -->