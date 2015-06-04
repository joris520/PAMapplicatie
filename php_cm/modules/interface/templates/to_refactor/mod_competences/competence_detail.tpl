{* smarty *}
<!-- competence detail.tpl -->
<table width="100%" border="0" cellpadding="2" cellspacing="0" class="details-frame">
    <tr>
        <td class="details-line-label">{'CATEGORY'|TXT_UCF} :</td>
        <td colspan="4" class="details-line-value">{$category}</td>
    </tr>
    <tr>
        <td class="details-line-label">{'CLUSTER'|TXT_UCF} :</td>
        <td colspan="4" class="details-line-value">{$cluster}</td>
    </tr>
    <tr>
        <td class="details-line-label">{'DESCRIPTION'|TXT_UCF} : </td>
        <td colspan="4" class="details-line-value">{$description}</td>
    </tr>
    {if $showNumericScale}
    <tr>
        <td class="details-line-label" width="20%">[1] {'SCALE_NONE'|constant}</td>
        <td class="details-line-label" width="20%">[2] {'SCALE_BASIC'|constant}</td>
        <td class="details-line-label" width="20%">[3] {'SCALE_AVERAGE'|constant}</td>
        <td class="details-line-label" width="20%">[4] {'SCALE_GOOD'|constant}</td>
        <td class="details-line-label" width="20%">[5] {'SCALE_SPECIALIST'|constant}</td>
    </tr>
    <tr>
        <td class="details-line">{$scale_1none}</td>
        <td class="details-line">{$scale_2basic}</td>
        <td class="details-line">{$scale_3average}</td>
        <td class="details-line">{$scale_4good}</td>
        <td class="details-line">{$scale_5specialist}</td>
    </tr>
    {/if}
    {if $showYNScale}
    <tr>
        <td class="details-line-label" width="20%">[{$module_utils_object->ScoreNormLetter('Y')}] {'SCALE_YES'|constant}</td>
        <td class="details-line-label" width="20%">[{$module_utils_object->ScoreNormLetter('N')}] {'SCALE_NO'|constant}</td>
        <td class="details-line-label" width="20%">&nbsp;</td>
        <td class="details-line-label" width="20%">&nbsp;</td>
        <td class="details-line-label" width="20%">&nbsp;</td>
    </tr>
    {/if}
    {if $showLastModifiedLogs}
    <tr>
        <td colspan="100%" class="details-footer">
            <div align="right">{$lastModifiedLogs}</div>
        </td>
    </tr>
    {/if}
</table>
<!-- competence detail.tpl -->