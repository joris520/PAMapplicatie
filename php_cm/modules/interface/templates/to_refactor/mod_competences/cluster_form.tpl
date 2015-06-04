{* smarty *}
<!-- cluster_form.tpl -->
<table class="form-layout" width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
        <td width="20%" class="form-label">{'CATEGORY'|TXT_UCF} {'REQUIRED_FIELD_INDICATOR'|constant} : </td>
        <td width="80%" class="form-value">{$category_selector}</td>
    </tr>
    <tr>
        <td class="form-label">{'CLUSTER'|TXT_UCF} {'REQUIRED_FIELD_INDICATOR'|constant}: </td>
        <td class="form-value"><input name="cluster" type="text" id="cluster" size="30" value="{$clusterName}"></td>
    </tr>
    {if $showMainCompetence}
    <tr>
        <td class="form-label">{'CLUSTER_MAIN_COMPETENCE'|TXT_UCF} : </td>
        <td class="form-value">{$main_competence_selector}</td>
    </tr>
    {/if}
</table>
<!-- /cluster_form.tpl -->
