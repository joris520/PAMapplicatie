<!-- displayAccess.tpl -->
<form id="accessForm" name="accessForm" onsubmit="submitSafeForm('{$formIdentifier}', this.name); return false;">
    {$form_token}
    <h1>{$level_name|strtoupper} {'PRIVILEGES'|TXT_UC}</h1>
    <h2>{$title_tabs_T|ucwords}</h2>
    <table border="0" cellspacing="0" cellpadding="4">
        <tr>
            {assign var='module_tabs_cat' value=$module_tabs_T}
            {assign var='spread' value=1}
            {assign var='label_0' value=TXT_LC('PERMISSION_NO_ACCESS')}
            {assign var='label_1' value=TXT_LC('PERMISSION_VIEW')}
            {assign var='label_2' value=TXT_LC('PERMISSION_EDIT')}
            {assign var='label_3' value=TXT_LC('PERMISSION_ADD_DELETE')}
            {include file='to_refactor/mod_level_authorization/displayCategoryTabAccess.tpl'}
        </tr>
        <tr>
            <td>
                <em>{TXT_LC('PERMISSION_VIEW')}&nbsp;&nbsp;|&nbsp;&nbsp;{TXT_LC('PERMISSION_EDIT')}&nbsp;&nbsp;|&nbsp;&nbsp;{TXT_LC('PERMISSION_ADD_DELETE')}</em>
            </td>
        </tr>
    </table>
    {if $module_tabs_P1|count > 0 ||
        $module_tabs_P2|count > 0 ||
        $module_tabs_P3|count > 0}
    <hr />
    <table border="0" cellspacing="0" cellpadding="4">
        <tr>
            <td><h2>{'PERMISSIONS_ON_TAB'|TXT_UCW}</h2></td>
        </tr>
        <tr>
            {assign var='module_tabs_cat' value=$module_tabs_P1}
            {assign var='spread' value=0}
            {assign var='label_0' value=TXT_UC('PERMISSION_NO_ACCESS')}
            {assign var='label_1' value=TXT_LC('PERMISSION_VIEW')}
            {assign var='label_2' value=TXT_LC('PERMISSION_USE')}
            {include file='to_refactor/mod_level_authorization/displayCategoryTabAccess.tpl'}

            {assign var='module_tabs_cat' value=$module_tabs_P2}
            {assign var='spread' value=0}
            {assign var='label_0' value=TXT_UC('PERMISSION_NO_ACCESS')}
            {assign var='label_1' value=TXT_LC('PERMISSION_VIEW')}
            {assign var='label_2' value=TXT_LC('PERMISSION_USE')}
            {include file='to_refactor/mod_level_authorization/displayCategoryTabAccess.tpl'}

            {assign var='module_tabs_cat' value=$module_tabs_P3}
            {assign var='spread' value=0}
            {assign var='label_0' value=TXT_UC('PERMISSION_NO_ACCESS')}
            {assign var='label_1' value=TXT_LC('PERMISSION_VIEW')}
            {assign var='label_2' value=TXT_LC('PERMISSION_EDIT')}
            {assign var='label_3' value=TXT_LC('PERMISSION_ADD_DELETE')}
            {include file='to_refactor/mod_level_authorization/displayCategoryTabAccess.tpl'}
        </tr>
    </table>
    {/if}
    <table>
        <tr>
            <td>
                <input type="submit" id="submitButton" value="{'SAVE'|TXT_BTN}" class="btn btn_width_80"/>
            </td>
        </tr>
    </table>
</form>
<!-- /displayAccess.tpl -->