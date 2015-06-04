<!-- employeePdpActionView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
    <tr>
        <td class="{if $valueObject->isCancelled()}inactive{/if}" title="{PdpActionNameConverter::title($valueObject->isUserDefined())}{if $valueObject->isCancelled()}, {PdpActionCompletedConverter::display($valueObject->getIsCompletedStatus())}{/if}">
            <strong>{PdpActionNameConverter::display($valueObject->getActionName(), PdpActionNameConverter::EMPTY_LABEL, $valueObject->isUserDefined())}</strong>
        </td>
        <td class="">
            {PdpActionCompletedConverter::image($valueObject->getIsCompletedStatus())}
        </td>
        <td class="{if $interfaceObject->hasDateWarning()}warning-text{/if}">
            {DateConverter::display($valueObject->getTodoBeforeDate())}
        </td>
        <td class="">
            {$valueObject->getOwnerName()}
        </td>
        <td class="">
            {DateConverter::display($valueObject->getEmailAlertDate())}
        </td>
        <td class="actions">
            {$interfaceObject->getActionLinks()}
        </td>
    </tr>
    <tr>
        <th class="sub-header">
            &nbsp;
        </th>
        <th class="sub-header shaded_title" colspan="2">
            {'PROVIDER'|TXT_UCF}
        </th>
        <th class="sub-header shaded_title">
            {'DURATION'|TXT_UCF}
        </th>
        <th class="sub-header shaded_title"
            >{'COST'|TXT_UCF}
        </th>
        <th class="sub-header" >
            &nbsp;
        </td>
    </tr>
    <tr>
        <td class="">
            &nbsp;
        </td>
        <td class="" colspan="2">
            {$valueObject->getProvider()}
        </td>
        <td class="">
            {$valueObject->getDuration()}
        </td>
        <td class="{if $valueObject->isCancelled()}inactive" title="{PdpActionCompletedConverter::display($valueObject->getIsCompletedStatus())}{/if}">
            &euro; {PdpCostConverter::display($valueObject->getCost())}
        </td>
        <td class="">
            &nbsp;
        </td>
    </tr>
    {if $interfaceObject->showDetailInfo()}
    <tr>
        <td class="">
            &nbsp;
        </td>
        <td colspan="4" style="padding-left:0px; padding-right:0px;">
            <div class="remarks-content" style=" padding:10px;">
                {if $interfaceObject->hasRelatedCompetences()}
                <strong>{'RELATED_COMPETENCES'|TXT_LC}</strong>
                <br />
                <span class="comment">{$interfaceObject->getRelatedCompetences()}</span>
                <br />
                {if $valueObject->hasNote()}
                <br />
                {/if}
                {/if}
                {if $valueObject->hasNote()}
                <strong>{'REASONS_REMARKS'|TXT_LC}</strong>
                <br />
                <span class="comment">{$valueObject->getNote()|nl2br}</span>
                {/if}
            </div>
        </td>
        <td class="">
            &nbsp;
        </td>
    </tr>
    {/if}
    <tr>
        <td class="bottom_line" colspan="100%">
            &nbsp;
        </td>
    </tr>
<!-- /employeePdpActionView.tpl -->