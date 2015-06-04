<!-- employeeCompetenceCategoryGroup.tpl -->
{* group is een category *}
{* todo: styles naar css *}
    <tr>
        <th colspan="100%">
            {if $interfaceObject->showCategory()}
                <h2>{CategoryConverter::display($interfaceObject->getCategoryName())}</h2>
            {else}
                &nbsp;
            {/if}
        </th>
    </tr>
    <tr>
        {if $interfaceObject->show360()}
        {assign var=periodTitleColspan value=2}
        {else}
        {assign var=periodTitleColspan value=1}
        {/if}
        <th class="shaded_title2">&nbsp;</th>
        <th class="shaded_title2 centered previous-period-header"colspan="{$periodTitleColspan}">
            {$interfaceObject->getPreviousPeriodName()}{*'CUSTOMER_MGR_SCORE_LABEL'|constant|TXT_UCF*}
        </th>
        <th class="shaded_title2 centered current-period-header" colspan="{$periodTitleColspan}">
            {$interfaceObject->getCurrentPeriodName()}{*'CUSTOMER_360_SCORE_LABEL'|constant|TXT_UCF*}
        </th>
        {if $interfaceObject->showNorm()}
        <th class="shaded_title2 centered">&nbsp;</th>
        {/if}
        {if $interfaceObject->showWeight()}
        <th class="shaded_title2 centered">&nbsp;</th>
        {/if}
        {if $interfaceObject->showPdpActions()}
        <th class="shaded_title2 centered">&nbsp;</th>
        {/if}
        <th class="shaded_title2">
                &nbsp;
        </th>
    </tr>
    <tr>
        <th class="shaded_title2"></th>
        <th width="100px" class="shaded_title2 centered previous-period">
            {TXT_LC('COMPENTENCE_SCORE_HEADER_MANAGER')}
            {*$interfaceObject->getPreviousPeriodName()*}
            {$interfaceObject->getPreviousPeriodIconView()->fetchHtml()}
        </th>
        {if $interfaceObject->show360()}
        <th width="100px" class="shaded_title2 centered previous-period">
            {TXT_LC('COMPENTENCE_SCORE_HEADER_EMPLOYEE')}
            {*$interfaceObject->getPreviousPeriodName()*}
            {$interfaceObject->getPreviousPeriodEmployeeIconView()->fetchHtml()}
        </th>
        {/if}
        <th width="100px" class="shaded_title2 centered current-period">
            {TXT_LC('COMPENTENCE_SCORE_HEADER_MANAGER')}
            {*$interfaceObject->getCurrentPeriodName()*}
            {$interfaceObject->getCurrentPeriodIconView()->fetchHtml()}
        </th>
        {if $interfaceObject->show360()}
        <th width="100px" class="shaded_title2 centered current-period">
            {TXT_LC('COMPENTENCE_SCORE_HEADER_EMPLOYEE')}
            {*$interfaceObject->getCurrentPeriodName()*}
            {$interfaceObject->getCurrentPeriodEmployeeIconView()->fetchHtml()}
        </th>
        {/if}
        {if $interfaceObject->showNorm()}
        <th width="50px" class="shaded_title2 centered">
            {'NORM'|TXT_UCF}
        </th>
        {/if}
        {if $interfaceObject->showWeight()}
        <th width="60px" class="shaded_title2 centered">
            {'WEIGHT_FACTOR'|TXT_UCF}
        </th>
        {/if}
        {if $interfaceObject->showPdpActions()}
        <th width="60px"  class="shaded_title2 centered">
            {'PDP_ACTIONS'|TXT_TAB}
        </th>
        {/if}
        <th width="100px" class="shaded_title2">
            &nbsp;
        </th>
    </tr>
    {foreach $interfaceObject->getInterfaceObjects() as $clusterInterfaceObject}
        {$clusterInterfaceObject->fetchHtml()}
    {/foreach}{* clusterInterfaceObject *}
<!-- /employeeCompetenceCategoryGroup.tpl -->