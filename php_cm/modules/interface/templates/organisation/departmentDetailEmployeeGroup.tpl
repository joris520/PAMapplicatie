<!-- departmentDetailEmployeeGroup.tpl -->
<h1 class="centered">{'EMPLOYEES'|TXT_UCW}</h1>
<table align="center" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <th class="bottom_line shaded_title" style="width:200px;">{'EMPLOYEE'|TXT_UCF}</th>
        <th class="bottom_line shaded_title" style="width:300px;">{'FUNCTION'|TXT_UCF}</th>
        <th class="bottom_line shaded_title" style="width:200px;">{'DEPARTMENT'|TXT_UCF}</th>
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
<!-- /departmentDetailEmployeeGroup.tpl -->