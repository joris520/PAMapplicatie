<!-- employeeTargetGroup.tpl -->
<table class="content-table" style="width:{$interfaceObject->getDisplayWidth()};">
{if $interfaceObject->getInterfaceObjects()|count > 0}
    <tr>
        <th class="bottom_line shaded_title" style="width:250px;">
            {'TARGET'|TXT_UCF}
        </th>
        <th class="bottom_line shaded_title" style="width:245px;">
            {'KPI'|TXT_UCF}
        </th>
        {if $interfaceObject->isViewAllowedEvaluation()}
        <th class="bottom_line shaded_title" style="width:175px;">
            {'TARGET_STATUS'|TXT_UCF}
        </th>
        {/if}
        <th class="bottom_line shaded_title" style="width:100px;">
            {'TARGET_END_DATE'|TXT_UCF}
        </th>
        <th class="bottom_line shaded_title actions" style="width:75px;">
            &nbsp;
        </th>
    </tr>
    {foreach $interfaceObject->getInterfaceObjects() as $viewInterfaceObject}
        {$viewInterfaceObject->fetchHtml()}
    {/foreach}
{else}
    <tr>
        <td colspan="100%">{$interfaceObject->displayEmptyMessage()}</td>
    </tr>
{/if}
</table><!-- /employeeTargetGroup.tpl -->