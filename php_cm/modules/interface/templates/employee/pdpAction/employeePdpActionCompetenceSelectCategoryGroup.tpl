<!-- employeePdpActionCompetenceSelectCategoryGroup.tpl -->
{if !$isFirst}
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
{/if}
{if $interfaceObject->showCategory()}
    <tr>
        <td colspan="3"><h2>{CategoryConverter::display($interfaceObject->getCategoryName())}</h2></td>
    </tr>
{/if}
{foreach $interfaceObject->getInterfaceObjects() as $clusterInterfaceObject}
    {$clusterInterfaceObject->fetchHtml()}
{/foreach}
<!-- /employeePdpActionCompetenceSelectCategoryGroup.tpl -->