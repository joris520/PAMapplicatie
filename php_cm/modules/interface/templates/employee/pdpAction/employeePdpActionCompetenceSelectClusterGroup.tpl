<!-- employeePdpActionCompetenceSelectClusterGroup.tpl -->
    <tr>
        <td class="shaded_title" colspan="3" style="padding-left: 5px;">
            {$interfaceObject->getClusterName()}
        </td>
    </tr>
    {foreach $interfaceObject->getInterfaceObjects() as $viewInterfaceObject}
        {$viewInterfaceObject->fetchHtml()}
    {/foreach}
<!-- /employeePdpActionCompetenceSelectClusterGroup.tpl -->