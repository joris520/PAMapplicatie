<!-- employeePdpActionGroup.tpl -->
<table class="content-table" style="width:{$interfaceObject->getDisplayWidth()};">
{if $interfaceObject->getInterfaceObjects()|count > 0}
    <tr>
        <th class="shaded_title" width="220px">{'PDP_ACTION'|TXT_UCF}</th>
        <th class="shaded_title" width="130px">{'STATUS'|TXT_UCF}</th>
        <th class="shaded_title" width="110px">{'DEADLINE_DATE'|TXT_UCF}</th>
        <th class="shaded_title" width="220px">{'ACTION_OWNER'|TXT_UCF}</th>
        <th class="shaded_title" width="110px">{'NOTIFICATION_DATE'|TXT_UCF}</th>
        <th class="shaded_title actions" width="50px">&nbsp;</td>
    </tr>
    {foreach $interfaceObject->getInterfaceObjects() as $viewInterfaceObject}
        {$viewInterfaceObject->fetchHtml()}
    {/foreach}
{else}
    <tr>
        <td colspan="100%">{$interfaceObject->displayEmptyMessage()}</td>
    </tr>
{/if}
</table>
<!-- /employeePdpActionGroup.tpl -->