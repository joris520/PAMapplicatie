<!-- employeeCompetenceGroupEdit.tpl -->
{* group van category *}
{* todo: styles naar css *}
{* alle categorien uitklappen *}
{if $interfaceObject->getInterfaceObjects()|count > 0}
{if $interfaceObject->showRemarks()}
<div class="actions" style="padding-top:10px; padding-bottom:10px;" width:{$interfaceObject->getDisplayWidth()};">
    {$interfaceObject->getToggleNotesVisibilityLink()}
</div>
{/if}
<span id="{$interfaceObject->getToggleNotesHtmlId()}">
    {foreach $interfaceObject->getInterfaceObjects() as $categoryInterfaceObject}
        {$categoryInterfaceObject->fetchHtml()}
    {/foreach}{* categoryInterfaceObject *}
</span>
{/if}
<!-- /employeeCompetenceGroupEdit.tpl -->