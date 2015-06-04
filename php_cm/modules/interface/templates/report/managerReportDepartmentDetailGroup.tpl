<!-- managerReportDepartmentDetailGroup.tpl -->
<h1 class="centered">{'ACCESS'|TXT_UCW}</h1>
<table style="width:{$interfaceObject->getDisplayWidth()};" align="center">
    <tr>
        <th class="bottom_line shaded_title">{'DEPARTMENT'|TXT_UCF}</th>
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
<!-- /managerReportDepartmentDetailGroup.tpl -->