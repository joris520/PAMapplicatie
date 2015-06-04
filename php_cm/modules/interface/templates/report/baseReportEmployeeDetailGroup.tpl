<!-- baseReportEmployeeDetailGroup.tpl -->
<table style="width:{$interfaceObject->getDisplayWidth()};" align="center">
    <tr>
        <td colspan="100%"><h2>{$interfaceObject->getBossName()}</h2></td>
    </tr>
    <tr>
        <th class="bottom_line shaded_title" style="width:200px;">{'EMPLOYEE'|TXT_UCF}</th>
        <th class="bottom_line shaded_title" style="width:300px;">{'FUNCTION'|TXT_UCF}</th>
        <th class="bottom_line shaded_title" style="width:200px;">{'DEPARTMENT'|TXT_UCF}</th>
        {if $interfaceObject->showCount()}
        <th class="bottom_line shaded_title centered" style="width:100px;">{$interfaceObject->getCountTitle()}</th>
        {/if}
    </tr>
    {if $interfaceObject->getInterfaceObjects()|count > 0}
        {foreach $interfaceObject->getInterfaceObjects() as $viewObject}
            {$viewObject->fetchHtml()}
        {/foreach}
    {else}
    <tr>
        <td colspan="100%">{$interfaceObject->displayEmptyMessage()}</td>
    </tr>
    {/if}
</table>
<!-- /baseReportEmployeeDetailGroup.tpl -->