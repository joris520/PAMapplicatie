<!-- selfAssessmentDashboardDetailView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{assign var=assessmentValueObject value=$interfaceObject->getAssessmentValueObject()}
<tr>
    <td class="bottom_line">
        {$valueObject->getEmployeeName()}
    </td>
    {if $interfaceObject->showEmployeeStatus()}
    <td class="bottom_line">
        {DateConverter::display($valueObject->getDateInvited())}
    </td>
    {if !$interfaceObject->showEmployeeCompleted()}
    <td class="bottom_line">
        {DateTimeConverter::display($valueObject->getDateTimeSent())}
    </td>
    {/if}
    {if $interfaceObject->showEmployeeCompleted()}
    <td class="bottom_line">
        {DateTimeConverter::display($valueObject->getDateTimeCompleted())}
    </td>
    {else}
    <td class="bottom_line">
        {DateTimeConverter::display($valueObject->getDateTimeReminder1())}
    </td>
    <td class="bottom_line">
        {DateTimeConverter::display($valueObject->getDateTimeReminder2())}
    </td>
    {/if}
    {/if}
    {if $interfaceObject->showBossStatus()}
    <td class="bottom_line">
        {DateConverter::display($assessmentValueObject->getAssessmentDate())}
    </td>
    {if $interfaceObject->showDetails()}
    <td class="bottom_line">
        {ScoreStatusConverter::image($assessmentValueObject->getScoreStatus())}
        {ScoreStatusConverter::display($assessmentValueObject->getScoreStatus())}
    </td>
    {/if}
    <td class="bottom_line">
        {DateTimeConverter::display($assessmentValueObject->getSavedDateTime())}
    </td>
    {/if}
    {* filler *}
    <td class="bottom_line">&nbsp;</td>
</tr>
{if $interfaceObject->showDebug()}
<tr>
    <td colspan="100%">
        <pre>{print_r($valueObject, true)}</pre>
    </td>
</tr>
{/if}
<!-- /selfAssessmentDashboardDetailView.tpl -->