<!-- employeeListView.tpl -->
<!-- sortfilter:{EmployeeFilterService::retrieveSortFilter()} -->
<div class="actions">
    {$interfaceObject->getAddLink()}
</div>
<div id="{$interfaceObject->getReplaceHtmlId()}">
    {$interfaceObject->getFilteredEmployees()->fetchHtml()}
</div><!-- /{$interfaceObject->getReplaceHtmlId()} -->
<!-- /employeeListView.tpl -->