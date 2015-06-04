<!-- employeeSelfAssessmentReportGroup.tpl -->
{assign var=displayCycleId          value='NULL'}
{assign var=isFirstCycle            value=true}
{assign var=viewInterfaceObjects    value=$interfaceObject->getInterfaceObjects()}
{assign var=displayWidth            value=$interfaceObject->getDisplayWidth()}
{if $viewInterfaceObjects|count > 0}
{foreach $viewInterfaceObjects as $viewInterfaceObject}
    {assign var=valueObject                 value=$viewInterfaceObject->getValueObject()}
    {assign var=assessmentCycleValueObject  value=$viewInterfaceObject->getAssessmentCycleValueObject()}
    {if $displayCycleId != $assessmentCycleValueObject->getId()}
    {if !$isFirstCycle}
    </table>
    {/if}
    {* de vorige compare resetten bij een nieuwe cyclus *}
    {include    file='components/historyAssessmentCycleDetail.tpl'
                displayWidth=$interfaceObject->getDisplayWidth()
                assessmentCycleValueObject=$assessmentCycleValueObject}

    <table width="{$displayWidth}" cellspacing="0" cellpadding="2">
        <tr>
            <th class="bottom_line shaded_title">{'EMPLOYEE'|TXT_UCF}</th>
            <th class="bottom_line shaded_title" style="width:80px;">{'DATE_INVITED'|TXT_UCF}</th>
            <th class="bottom_line shaded_title" style="width:120px;">{'DATE_SENT'|TXT_UCF}</th>
            <th class="bottom_line shaded_title" style="width:100px;">{'IS_COMPLETED'|TXT_UCF}</th>
            <th class="bottom_line shaded_title" style="width:120px;">{'DATE_COMPLETED'|TXT_UCF}</th>
            <th class="bottom_line shaded_title" style="width:120px;">{'DATE_REMINDER1'|TXT_UCF}</th>
            <th class="bottom_line shaded_title" style="width:120px;">{'DATE_REMINDER2'|TXT_UCF}</th>
        </tr>
    {/if}
    {assign var=isFirstCycle value=false}
    {assign var=displayCycleId value=$assessmentCycleValueObject->getId()}
    {$viewInterfaceObject->fetchHtml()}
{/foreach}
{else}
    <table width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="100%">{$interfaceObject->displayEmptyMessage()}</td>
    </tr>
{/if}
    </table>
    <br />
<!-- /employeeSelfAssessmentReportGroup.tpl -->