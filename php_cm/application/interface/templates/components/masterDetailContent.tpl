{* smarty *}
{* master detail tab scherm *}
<!-- masterDetailContent.tpl -->
<div id="tab_content" class="tab-content-layout">
    <table class="master-detail-layout-helper" cellspacing="0" cellpadding="0">
        <tr>
            {* het linker deel, master panel *}
            <td class="layout-master-panel" id="master-panel">
                <table class="master-control" cellspacing="0" cellpadding="0">
                    <tr class="master-header-row">
                        <td id="master-header-title" class="spaced">
                             <h1 id="master_title" class="master">{$master_title}</h1>
                        </td>
                        <td id="master_buttons" class="spaced">
                            {$master_buttons}
                        </td>
                    </tr>
                    <tr>
                        <td id="master_search" class="master_search spaced" colspan="100%">
                            {$master_search}
                        </td>
                    </tr>
                    <tr>
                        <td id="master_search_limit" class="master_search spaced" colspan="100%">
                            {$master_search_limit}
                        </td>
                    </tr>
                    <tr class="master-content-row">
                        {* optie voor scrollDiv toevoegen *}
                        <td id="left-content" class="master-content" colspan="100%">
                            <div id="master_scroll_content" class="scroll-content">
                            {$master_scroll_content}
                            </div>
                        </td>
                    </tr>
                </table>
            </td><!-- master-panel -->
            {* het rechter deel, detail panel *}
            <td id="detail-panel" class="layout-detail-panel">
                <table class="detail-navigation" cellspacing="0" cellpadding="0">
                    {* ruimte voor de knoppen bovenin *}
                    <tr class="detail-top-nav">
                        <td id="top_nav_content" class="top-buttons">{$top_nav_content}</td>
                    </tr>
                    {* submenu tabjes *}
                    <tr class="detail-tab-nav">
                        <td id="tab_nav_content" class="detail-tab">{$tab_nav_content}</td>
                    </tr>
                </table>
                <table class="detail-content" cellspacing="0" cellpadding="0">
                    {* ruimte voor de knoppen bovenin *}
                    <tr class="detail-top-nav">
                        <td id="detail_nav_content" class="top-buttons">{$detail_nav_content}</td>
                    </tr>
                    {* de echte inhoud *}
                    <tr class="detail-content">
                        <td id="detail_content" class="detail-content">{$detail_content}</td>
                    </tr>
                </table>
            </td><!-- detail panel -->
        </tr>
    </table>
</div><!-- tab-content-layout -->
<!-- /masterDetailContent.tpl -->