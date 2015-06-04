{* smarty *}
{* detail tab scherm *}
<!-- detailContent.tpl -->
<div id="tab_content" class="tab-content-layout" {$layout}>
    <table class="master-detail-layout-helper" cellspacing="0" cellpadding="0">
        <tr>
            {* het detail panel *}
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
                    {* de echte inhoud *}
                    <tr class="detail-content">
                        <td id="detail_content" class="detail-content">{$detail_content}</td>
                    </tr>
                </table>
            </td><!-- detail panel -->
        </tr>
    </table>
</div><!-- tab-content-layout -->
<!-- /detailContent.tpl -->
