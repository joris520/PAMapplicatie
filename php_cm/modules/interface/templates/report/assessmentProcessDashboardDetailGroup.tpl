<!-- assessmentProcessDashboardDetailGroup.tpl -->
<h2>{$interfaceObject->getBossName()}</h2>
<table style="width:{$interfaceObject->getDisplayWidth()};" class="">
    <tr>
        <th class="shaded_title" style="width:250px;">{'EMPLOYEE'|TXT_UCF}</th>
        {if $interfaceObject->showSelectDetails()}
        <th class="shaded_title" style="width:100px;">{'DATE'|TXT_UCF}</th>
        {/if}
        {if $interfaceObject->showCalculationDetails()}
        <th class="shaded_title" style="width:100px;">{'SCORE_SUM'|TXT_UCF}</th>
        <th class="shaded_title" style="width:200px;">{'SCORE_RANK'|TXT_UCF}</th>
        {/if}
        {if $interfaceObject->showEvaluationDetails()}
        <th class="shaded_title" style="width:250px;">{'REPORT_ASSESSMENT_EVALUATION_STATUS'|TXT_UCF}</th>
        {/if}
        {if $interfaceObject->showEvaluationStatusDetails()}
        <th class="shaded_title" style="width:250px;">{'EVALUATION_DATE'|TXT_UCF}</th>
        <th class="shaded_title" style="width:250px;">{'REPORT_ASSESSMENT_EVALUATION_STATUS'|TXT_UCF}</th>
        {/if}
        {* filler *}
        <th class="shaded_title">&nbsp;</th>
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
<br />
<!-- /assessmentProcessDashboardDetailGroup.tpl -->