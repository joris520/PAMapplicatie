<!-- managerReportGroup.tpl -->
<table class="content-table" cellpadding="4" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <th class="bottom_line shaded_title">{'MANAGER'|TXT_UCF}</th>
        <th class="bottom_line shaded_title centered" style="width:100px;">{'EMPLOYEES'|TXT_UCF}</th>
        <th class="bottom_line shaded_title" style="width:150px;">{'USERNAME'|TXT_UCF}</th>
        <th class="bottom_line shaded_title centered" style="width:150px;">{'SECURITY'|TXT_UCF}</th>
        <th class="bottom_line shaded_title centered" style="width:100px;">{'DEPARTMENTS'|TXT_UCF}</th>
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
<!-- /managerReportGroup.tpl -->