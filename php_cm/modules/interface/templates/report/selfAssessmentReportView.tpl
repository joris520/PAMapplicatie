<!-- selfAssessmentReportView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<tr id="detail_invitation_{$valueObject->getId()}" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
    <td class="bottom_line">
        {$valueObject->getEmployeeName()}{if $interfaceObject->getShowLink()}&nbsp;<span class="activeRow icon-style">{$interfaceObject->getDetailLink()}</span>{/if}
    </td>
    <td class="bottom_line">
        {DateConverter::display($valueObject->getDateInvited())}
    </td>
    <td class="bottom_line">
        {DateTimeConverter::display($valueObject->getDateTimeSent())}
    </td>
    <td class="bottom_line">
        {AssessmentInvitationCompletedConverter::image($valueObject->getCompletedStatus())}
        {AssessmentInvitationCompletedConverter::displayReport($valueObject->getCompletedStatus())}
    </td>
    <td class="bottom_line">
        {DateTimeConverter::display($valueObject->getDateTimeCompleted())}
    </td>
    <td class="bottom_line">
        {DateTimeConverter::display($valueObject->getDateTimeReminder1())}
    </td>
    <td class="bottom_line">
        {DateTimeConverter::display($valueObject->getDateTimeReminder2())}
    </td>
</tr>
{if $interfaceObject->showDebug()}
<tr>
    <td colspan="100%">
        <pre>{print_r($valueObject, true)}</pre>
    </td>
</tr>
{/if}
<!-- /selfAssessmentReportView.tpl -->