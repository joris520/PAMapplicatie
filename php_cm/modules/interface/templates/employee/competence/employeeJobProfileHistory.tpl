<!-- employeeJobProfileHistory.tpl -->
{assign var=displayCycleId value='NULL'}
{assign var=isFirstCycle value=true}
{if $interfaceObject->getValueObjects()|count > 0}
{foreach $interfaceObject->getValueObjects() as $valueObject}
    {assign var=assessmentCycleValueObject value=$valueObject->getAssessmentCycleValueObject()}
    {assign var=mainFunction value=$valueObject->getMainFunction()}
    {assign var=additionalFunctions value=$valueObject->getAdditionalFunctions()}
    {if $displayCycleId != $assessmentCycleValueObject->getId()}
    {if !$isFirstCycle}
    </table>
    {/if}
    {* de vorige compare resetten bij een nieuwe cyclus *}
    {assign var=compareValueObject value=$valueObject}
    {assign var=compareMainFunction value=$mainFunction}

    {include    file='components/historyAssessmentCycleDetail.tpl'
                displayWidth                =   $interfaceObject->getDisplayWidth()
                assessmentCycleValueObject  =   $assessmentCycleValueObject}

    <table cellspacing="0" cellpadding="0" style="width:{$interfaceObject->getDisplayWidth()};">
    {/if}
    {assign var=isFirstCycle value=false}
    {assign var=displayCycleId value=$assessmentCycleValueObject->getId()}
        <tr style="text-align: left">
            <th class="bottom_line form-label" style="width:200px;">
                {'DATE_SAVED'|TXT_UCW}
            </th>
            <th class="bottom_line shaded_title form-label" style="width:100px;">
                {'DATE'|TXT_UCW}
            </td>
            <th class="bottom_line shaded_title form-label" style="width:300px;">
                {'JOB_PROFILE'|TXT_UCF}
            </th>
            <th class="bottom_line shaded_title form-label">
                {'REMARKS'|TXT_UCF}
            </th>
        </tr>
        <tr style="text-align: left">
            <td class="bottom_line form-value">
                {DateTimeConverter::display($valueObject->getSavedDateTime())}<br/>{$valueObject->getSavedByUserName()}
            </td>
            <td class="bottom_line form-value">
                <span class="{$interfaceObject->diff($compareValueObject->getFunctionDate(),$valueObject->getFunctionDate())}">
                    {DateConverter::display($valueObject->getFunctionDate())}
                </span>
            </td>
            <td class="bottom_line form-value info-list">
                {if $valueObject->hasAdditionalFunctions()}
                {'MAIN_JOB_PROFILE'|TXT_UCF}
                <br/>
                {/if}
                <span class="{$interfaceObject->diff($compareMainFunction->getFunctionId(),$mainFunction->getFunctionId())}">
                    {$mainFunction->getFunctionName()}
                </span>
                {if $valueObject->hasAdditionalFunctions()}
                <br/><br/>
                {'ADDITIONAL_JOB_PROFILES'|TXT_UCF}
                <ul>
                    {foreach $additionalFunctions as $additionalFunction}
                    <li>
                        {$additionalFunction->getFunctionName()}
                    </li>
                    {/foreach}
                </ul>
                {/if}
            </td>
            <td class="bottom_line form-value">
                <span class="{$interfaceObject->diff($compareValueObject->getNote(),$valueObject->getNote())}">
                    {$valueObject->getNote()|nl2br}
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="100%"><hr /></td>
        </tr>
    {assign var=compareValueObject value=$valueObject}{* voor de volgende loop onthouden *}
    {assign var=compareMainFunction value=$mainFunction}{* voor de volgende loop onthouden *}
{/foreach}
{else}
    <table width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="100%">{$interfaceObject->displayEmptyMessage()}</td>
    </tr>
{/if}
    </table>
<!-- /employeeJobProfileHistory.tpl -->