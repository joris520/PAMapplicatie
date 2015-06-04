{* smarty *}
<!-- modifiedLog.tpl -->
<table width="300" border="0" cellspacing="1" cellpadding="1" class="border1px">
    <tr>
        <td width="130" class="bottom_line shaded_title">{'LAST_MODIFIED_BY'|TXT_UCF}</td>
        <td width="150" class="activated">{$modifiedBy}</td>
    </tr>
    <tr>
        <td class="bottom_line shaded_title">{'LAST_MODIFIED_ON'|TXT_UCF}</td>
        <td class="activated">{$modifiedDate}&nbsp;{$modifiedTime}</td>
    </tr>
</table>
<!-- /modifiedLog.tpl -->