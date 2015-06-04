<!-- employeeResultGroup.tpl -->
<!-- EmployeeListState:{EmployeeListState::determineState()} -->
{if $interfaceObject->getInterfaceObjects()|count > 0}
    <div id="searchLimitText">
        <p class="info-text">
        {if $interfaceObject->showLimitText()}
        {if $interfaceObject->hasHitLimit()}
            {'EMPLOYEES_LIST_LIMITED_RESULTS'|TXT_UCF}.
            <br />
            {'ONLY_EMPLOYEES_LIMIT_SHOWN'|TXT_UCF_VALUE}.
        {else}
            {'HEADCOUNT'|TXT_UCF}: {$interfaceObject->getCount()}
        {/if}
        {/if}
        </p>
    </div>
    <div id="scrollDiv">
        <table border="0" cellspacing="0" cellpadding="0" style="width:{$interfaceObject->getDisplayWidth()}">
            {foreach $interfaceObject->getInterfaceObjects() as $employeeView}
                {$employeeView->fetchHtml()}
            {/foreach}
        </table>
    </div><!-- scrollDiv -->
{else}
<center>{'NO_RESULT_ON_SEARCH_CRITERIA'|TXT_UCF}</center>
{/if}
<!-- /employeeResultGroup.tpl -->