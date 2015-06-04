<!-- employeeAnswerHistory.tpl -->
{assign var=displayCycleId value='NULL'}
{assign var=isFirstCycle value=true}
{if $interfaceObject->getValueObjects()|count > 0}
{foreach $interfaceObject->getValueObjects() as $valueObject}
    {assign var=assessmentCycleValueObject value=$valueObject->getAssessmentCycleValueObject()}
    {if $displayCycleId != $assessmentCycleValueObject->getId()}
    {if !$isFirstCycle}
    </table>
    {/if}
    {* de vorige compare resetten bij een nieuwe cyclus *}
    {assign var=compareValueObject value=$valueObject}

    {include    file='components/historyAssessmentCycleDetail.tpl'
                displayWidth=$interfaceObject->getDisplayWidth()
                assessmentCycleValueObject=$assessmentCycleValueObject}

    <table cellspacing="0" cellpadding="0" style="width:{$interfaceObject->getDisplayWidth()};">
    {/if}
    {assign var=isFirstCycle value=false}
    {assign var=displayCycleId value=$assessmentCycleValueObject->getId()}
        <tr style="text-align: left">
            <th class="form-label" style="width:200px;">{'DATE_SAVED'|TXT_UCW}</th>
            <th class="shaded_title form-label" >{$valueObject->getAnsweredQuestion()|nl2br}</th>
        </tr>
        <tr style="text-align: left">
            <td class="form-value">
                {DateTimeConverter::display($valueObject->getSavedDateTime())}<br/>{$valueObject->getSavedByUserName()}
            </td>
            <td class="form-value">
                <span class="{$interfaceObject->diff($compareValueObject->getAnswer(),$valueObject->getAnswer())}">
                    {$valueObject->getAnswer()|nl2br}
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="100%"><hr /></td>
        </tr>
    {assign var=compareValueObject value=$valueObject}{* voor de volgende loop onthouden *}
{/foreach}
{else}
    <table width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="100%">{$interfaceObject->displayEmptyMessage()}</td>
    </tr>
{/if}
    </table>
<!-- /employeeAnswerHistory.tpl -->