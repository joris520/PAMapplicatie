<!-- employeeFilterView.tpl -->
{if $interfaceObject->showSearch()}
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td>
            <input type="text" name="search_employee" name="search_employee" size="25" maxlength="250" value="{$interfaceObject->getEmployeeSearchValue()}" onkeyup="{$interfaceObject->submitFunction()}">
            <a href="" onClick="{$interfaceObject->submitFunction()}"><img src="{'ICON_SEARCH'|constant}" title="{'SEARCH_EMPLOYEE'|TXT_UCF}" alt="search" class="icon-style" /></a>
        </td>
    </tr>
</table>
{/if}
{if $interfaceObject->showFilters()}
<div id="{$interfaceObject->getReplaceActionHtmlId()}" style="padding:3px">
    {$interfaceObject->getFilterActionHtml()}
</div>
<div id="{$interfaceObject->getReplaceFormHtmlId()}">
    {$interfaceObject->getFilterDetailHtml()}
</div>
{/if}
{if $interfaceObject->showSearch() ||
    $interfaceObject->showFilters()}
<hr />
{/if}
<!-- /employeeFilterView.tpl -->