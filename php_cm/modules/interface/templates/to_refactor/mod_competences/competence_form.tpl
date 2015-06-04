{* smarty *}
<!-- competence_form.tpl -->
<table class="form-layout" width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
        <td width="20%" class="form-label">{'CATEGORY'|TXT_UCF} : </td>
        <td width="80%" class="form-value">{$category_selector}</td>
    </tr>
    {if $showCopyFrom}
    <tr>
        <td width="20%" class="form-label">{'COPY_COMPETENCE_FROM'|TXT_UCF} : </td>
        <td width="80%" class="form-value">{$competence_selector}</td>
    </tr>
    <tr>
        <td colspan="100%">&nbsp;</td>
    </tr>
    {/if}
    <tr>
        <td class="form-label">{'CLUSTER'|TXT_UCF} {'REQUIRED_FIELD_INDICATOR'|constant} : </td>
        <td id="clusterSelect" class="form-value">{$cluster_selector}</td>
    </tr>
    <tr>
        <td class="form-label">{'COMPETENCE'|TXT_UCF} {'REQUIRED_FIELD_INDICATOR'|constant} : </td>
        <td class="form-value">
            <input name="competence" type="text" id="competence" size="30" value="{$competence.knowledge_skill_point}">
        </td>
    </tr>
    <tr>
        <td class="form-label">{'KEY_COMPETENCE'|TXT_UCF} : </td>
        <td class="form-value">{$is_key_selector}</td>
    </tr>
    <tr>
        <td class="form-label">{'DESCRIPTION'|TXT_UCF} {'REQUIRED_FIELD_INDICATOR'|constant} : </td>
        <td class="form-value"><textarea name="description" cols="40" rows="5" id="description">{$competence.description}</textarea></td>
    </tr>
    <tr>
        <td class="form-label">{'IS_NA_ALLOWED'|TXT_UCF} : </td>
        <td class="form-value">{$is_na_allowed_selector}</td>
    </tr>
        <tr>
            <td class="form-label">{'SCALE'|TXT_UCF} {'REQUIRED_FIELD_INDICATOR'|constant} : </td>
            <td class="form-value">{$scale_selector}</td>
        </tr>
        <tr>
            <td colspan="2" id="scale_div">{$selectedScaleContent}</td><!-- xajax hook -->
        </tr>
</table>
<!-- /competence_form.tpl -->