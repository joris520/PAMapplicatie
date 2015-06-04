<!-- libraryMenuPam4.tpl -->
{function name=activeClass menuName=''}
{strip}
    {if $active == $menuName|constant}active-menu-item{/if}
    {if $lastModule == $menuName|constant} last{/if}
{/strip}
{/function}
<div class="application-content block-menu">
    <table class="tab-menu">
        <tr>
        {if $showCompetences}
            <td class="clickable {activeClass menuName='MODULE_COMPETENCES'}"
                onclick="xajax_moduleCompetence(1);return false;">
                <a href="">{'COMPETENCES'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showJobProfiles}
            <td class="clickable {activeClass menuName='MODULE_JOB_PROFILES'}"
                onclick="xajax_moduleFunctions(1);return false;">
                <a href="">{'JOB_PROFILES'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showScales}
            <td class="clickable {activeClass menuName='MODULE_SCALES'}"
                onclick="xajax_moduleOptions_scales();return false;">
                <a href="">{'NORM'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showQuestions}
            <td class="clickable {activeClass menuName='MODULE_QUESTIONS'}"
                onclick="xajax_public_library__displayQuestions();return false;">
                <a href="">{'QUESTIONS'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showAssessmentCycle}
            <td class="clickable {activeClass menuName='MODULE_ASSESSMENT_CYCLE'}"
                onclick="xajax_public_library__displayAssessmentCycles();return false;">
                <a href="">{'ASSESSMENT_CYCLES'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showDepartments}
            <td class="clickable {activeClass menuName='MODULE_LIBRARY_DEPARTMENTS'}"
                onclick="xajax_public_library__displayDepartments();return false;">
                <a href="">{'DEPARTMENTS'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showDocumentClusters}
            <td class="clickable {activeClass menuName='MODULE_DOCUMENT_CLUSTERS'}"
                onclick="xajax_public_library__displayDocumentClusters();return false;">
                <a href="">{'ATTACHMENT_CLUSTERS'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showPdpActionLib}
            <td class="clickable {activeClass menuName='MODULE_PDP_ACTION_LIB'}"
                onclick="xajax_public_library__displayPdpActions();return false;">
                <a href="">{'PDP_ACTION_LIBRARY'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showPdpTaskLib}
            <td class="clickable {activeClass menuName='MODULE_PDP_TASK_LIB'}"
                onclick="xajax_modulePDPTaskLibrary();return false;">
                <a href="">{'PDP_TASK_LIBRARY'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showPdpTaskOwner}
            <td class="clickable {activeClass menuName='MODULE_PDP_TASK_OWNER'}"
                onclick="xajax_modulePDPTaskOwnerLibrary();return false;">
                <a href="">{'PDP_TASK_OWNER'|TXT_TAB}</a>
            </td>
        {/if}
        {if $showEmails}
            <td class="clickable {activeClass menuName='MODULE_EMAILS'}"
                onclick="xajax_moduleEmails_displayExternalEmailAddresses();return false;">
                <a href="">{'EMAILS'|TXT_TAB}</a>
            </td>
        {/if}
        </tr>
    </table>
</div>
<!-- /libraryMenuPam4.tpl -->