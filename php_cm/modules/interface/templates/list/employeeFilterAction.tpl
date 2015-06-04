<!-- /employeeFilterAction.tpl -->
{if $interfaceObject->showFilters()}
<div class="actions{if $interfaceObject->warnActiveFilters()} warning{/if}" style="width:{$interfaceObject->getDisplayWidth()};">
   {$interfaceObject->getFilterLabel()}&nbsp;&nbsp;&nbsp;{$interfaceObject->getFilterToggleLink()}
</div>
{/if}
<!-- /employeeFilterAction.tpl -->
