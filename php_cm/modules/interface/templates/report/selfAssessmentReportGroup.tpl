<!-- selfAssessmentReportGroup.tpl -->
<h2>{$interfaceObject->getBossName()}</h2>
<table style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <th class="bottom_line shaded_title">{'EMPLOYEE'|TXT_UCF}</th>
        <th class="bottom_line shaded_title" style="width:80px;">{'DATE_INVITED'|TXT_UCF}</th>
        <th class="bottom_line shaded_title" style="width:120px;">{'DATE_SENT'|TXT_UCF}</th>
        <th class="bottom_line shaded_title" style="width:100px;">{'IS_COMPLETED'|TXT_UCF}</th>
        <th class="bottom_line shaded_title" style="width:120px;">{'DATE_COMPLETED'|TXT_UCF}</th>
        <th class="bottom_line shaded_title" style="width:120px;">{'DATE_REMINDER1'|TXT_UCF}</th>
        <th class="bottom_line shaded_title" style="width:120px;">{'DATE_REMINDER2'|TXT_UCF}</th>
    </tr>
    {if $interfaceObject->getInterfaceObjects()|count > 0}
        {foreach $interfaceObject->getInterfaceObjects() as $viewInterfaceObject}
            {$viewInterfaceObject->fetchHtml()}
        {/foreach}
        <tr>
            <td colspan="100%"></td>
        </tr>
    {else}
    <tr>
        <td colspan="100%">{$interfaceObject->displayEmptyMessage()}</td>
    </tr>
    {/if}
</table>
<br />
<!-- /selfAssessmentReportGroup.tpl -->