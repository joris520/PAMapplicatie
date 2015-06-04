<!-- organisationMenuPam4.tpl -->
{function name=activeClass menuName=''}
{strip}
    {if $active == $menuName|constant}active-menu-item{/if}
    {if $lastModule == $menuName|constant} last{/if}
{/strip}
{/function}
<div class="application-content block-menu" style="margin-left: auto; margin-right:auto;">
    <table class="tab-menu">
        <tr>
        {if $showCompanyInformation}
            <td class="clickable {activeClass menuName='MODULE_ORGANISATION_MENU_COMPANY_INFO'}"
                onclick="xajax_public_organisationInfo__displayInfo();return false;">
                <a href="">{'COMPANY_INFORMATION'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showDepartments}
            <td class="clickable {activeClass menuName='MODULE_ORGANISATION_MENU_DEPARTMENTS'}"
                onclick="xajax_public_organisation__displayDepartments();return false;">
                <a href="">{'DEPARTMENTS'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showManagers}
            <td class="clickable {activeClass menuName='MODULE_ORGANISATION_MENU_MANAGERS'}"
                onclick="xajax_public_organisation__displayManagers();return false;">
                <a href="">{'REPORT_MANAGERS'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showBatchAddPDP}
            <td class="clickable {activeClass menuName='MODULE_ORGANISATION_MENU_PDP_ACTIONS_BATCH'}"
                onclick="xajax_moduleOrganisation_pdpActionsBatchForm();return false;">
                <a href="">{'MENU_ADD_NEW_PDP_ACTION'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showBatchAddTarget}
            <td class="clickable {activeClass menuName='MODULE_ORGANISATION_MENU_TARGETS_BATCH'}"
                onclick="xajax_public_batch_addTarget();return false;">
                <a href="">{'MENU_ADD_NEW_TARGET'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showBatchAddFiles}
            <td class="clickable {activeClass menuName='MODULE_ORGANISATION_MENU_ATTACHMENT_BATCH'}"
                onclick="xajax_moduleOrganisation_attachmentBatchForm();return false;">
                <a href="">{'MENU_UPLOAD_NEW_ATTACHMENT'|TXT_TAB}</a>
            </td>
        {/if}
        </tr>
    </table>
</div>
<!-- /organisationMenuPam4.tpl -->
