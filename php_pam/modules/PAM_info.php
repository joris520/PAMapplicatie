<?php

require_once('modules/interface/interfaceobjects/base/BaseBlockHtmlInterfaceObject.class.php');

function modulePAMInfo() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        ApplicationNavigationService::setCurrentApplicationModule(MODULE_INFO);

        $aboutTitle = TXT_UCF('ABOUT_SYSTEM_VERSION') . ' ' . PAM_VERSION;
        $aboutContentHtml = '
            <table class="content-table" width="700" >
                <tr>
                    <td>
                        <strong>' . TXT_UCF('FUNCTIONAL_DEVELOPMENT') . ':</strong> PAMpeople (Binne Visser)<br /><br />
                        <strong>' . TXT_UCF('TECHNICAL_DEVELOPMENT') . ':</strong> Gino b.v. <br /><br />
                        <strong>' . TXT_UCF('QUALITY_ASSURANCE') . ':</strong> PAMpeople / Gino b.v. <br /><br />
                        <span style="color:#aaa"><strong>icons: </strong>http://www.gettyicons.com</span><br />
                    </td>
                    <td rowspan="2" align="center" width="300">
                        <img src="images/logo/default_logo.jpg"/>
                    </td>
                </tr>
            </table>
            ';

        $aboutBlock = BaseBlockHtmlInterfaceObject::create($aboutTitle, 700);
        $aboutBlock->setContentHtml($aboutContentHtml);

        $companyInfoTitle = TXT_UCF('COMPANY_INFORMATION');
        $companyInfoHtml = '
            <table class="content-table" cellspacing="10" width="700" >
                <tr>
                    <td>
                        <br/>
                        <div style="margin:3px 0;">
                            <a href="' . TXT('PAMPEOPLE_URL') . '" target="_blank">' . TXT('PAMPEOPLE_URL') . '</a>
                        </div>
                    </td>
                    <td align="center" width="300">
                        <img src="images/logo/pampeople_logo.jpg"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br />
                        <div style="margin:3px 0;">
                            <a href="' . TXT('GINO_URL') . '" target="_blank">' . TXT('GINO_URL') . '</a>
                        </div>
                    </td>
                    <td align="center" width="300">
                        <br />
                        <img src="images/logo/ginologo.jpg"/>
                    </td>
                </tr>
            </table>
            ';

        $companyInfoBlock = BaseBlockHtmlInterfaceObject::create($companyInfoTitle, 700);
        $companyInfoBlock->setContentHtml($companyInfoHtml);

        $html = '
        <div id="module_pam_info" width="100%">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td>
                        <table width="700" align="center">
                            <tr>
                                <td>
                                ' . $aboutBlock->fetchHtml() . '
                                ' . $companyInfoBlock->fetchHtml() . '
                                </td>
                            </tr>
                        </table>
                        <br />
                        <br />
                    </td>
                </tr>
            </table>
        </div>';

        $objResponse->assign('module_main_panel', 'innerHTML', $html);
        $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_INFO));
    }

    return $objResponse;
}

?>
