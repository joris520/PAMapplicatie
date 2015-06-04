<!-- employeeTargetActionView.tpl -->
{assign var=addLink   value=$interfaceObject->getAddLink()}
{assign var=printLink value=$interfaceObject->getPrintLink()}
{if !empty($addLink) || !empty($printLink)}
<div class="application-content block-title" style="width:{$interfaceObject->getDisplayWidth()};">

<table style="width:{$interfaceObject->getDisplayWidth()};" border="0" cellspacing="0" cellpadding="2">
    <tr>
        <td class="bottom_line actions" colspan="100%">{$addLink}</td>
    </tr>
</table>
<br />
{/if}
<!-- /employeeTargetActionView.tpl -->