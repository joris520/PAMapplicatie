<!-- selfAssessmentDashboardDetailGroup.tpl -->
<h2>{$interfaceObject->getBossName()}</h2>
{assign var=showEmployeeCompleted   value=$interfaceObject->showEmployeeCompleted()}
{assign var=showEmployeeStatus      value=$interfaceObject->showEmployeeStatus()}
{assign var=showBossStatus          value=$interfaceObject->showBossStatus()}
{assign var=showDetails             value=$interfaceObject->showDetails()}
<table style="width:{$interfaceObject->getDisplayWidth()};" class="">
    {if $showEmployeeStatus && $showBossStatus}
    <tr>
        <th class="shaded_title">&nbsp;</th>
        {if $showEmployeeStatus}
        <th class="shaded_title" colspan="{if !$showEmployeeCompleted}4{else}2{/if}">{'DASHBOARD_COMPLETED_BY_EMPLOYEE'|TXT_UCF}</th>
        {/if}
        {if $showBossStatus}
        <th class="shaded_title" colspan="{if $showDetails}3{else}2{/if}">{'DASHBOARD_COMPLETED_BY_MANAGER'|TXT_UCF}</th>
        {/if}
        <th class="shaded_title">&nbsp;</th>
    </tr>
    {/if}
    <tr>
        <th class="shaded_title" style="width:250px;">{'EMPLOYEE'|TXT_UCF}</th>
        {if $showEmployeeStatus}
        <th class="shaded_title" style="width:80px;">{'DATE_INVITED'|TXT_UCF}</th>
        {if !$showEmployeeCompleted}
        <th class="shaded_title" style="width:120px;">{'DATE_SENT'|TXT_UCF}</th>
        {/if}
        {if !$showEmployeeCompleted}
        <th class="shaded_title" style="width:120px;">{'DATE_REMINDER1'|TXT_UCF}</th>
        <th class="shaded_title" style="width:120px;">{'DATE_REMINDER2'|TXT_UCF}</th>
        {else}
        <th class="shaded_title" style="width:120px;">{'DATE_COMPLETED'|TXT_UCF}</th>
        {/if}
        {/if}
        {if $showBossStatus}
        <th class="shaded_title" style="width:100px;">{'CONVERSATION_DATE'|TXT_UCF}</th>
        {if $showDetails}
        <th class="shaded_title" style="width:100px;">{'SCORE_STATUS'|TXT_UCF}</th>
        {/if}
        <th class="shaded_title" style="width:120px;">{'DATE_SAVED'|TXT_UCF}</th>
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
<!-- /selfAssessmentDashboardDetailGroup.tpl -->