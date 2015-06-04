<?php
require_once('modules/interface/interfaceobjects/base/BaseBlockHtmlInterfaceObject.class.php');


function moduleTechnicalManual() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        ApplicationNavigationService::setCurrentApplicationModule(MODULE_TECH_MANUAL);

        $technicalManualTitle       =  TXT_UCF('TECHNICAL_MANUAL') ;
        $technicalManualContentHtml = '
            <table class="content-table" width="700" style="padding:10px;">
                <tr>
                    <td>
                        ' . TXT_UCF("APPLICATION_REQUIREMENTS") . ': <br>
                        <ul style="margin-top:0px;">
                            <li style="padding:5px;">' . TXT_UCF("BEST_VIEWED_IN_IE")    . '</li>
                            <li style="padding:5px;">' . TXT_UCF("BEST_VIEWED_IN_OTHER") . '</li>
                        </ul>
                    </td>
                </tr>
            </table>';

        $technicalManualBlock = BaseBlockHtmlInterfaceObject::create($technicalManualTitle, 700);
        $technicalManualBlock->setContentHtml($technicalManualContentHtml);

        $getgt_data = '
        <div id="mode_department">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td>
                        <table align="center" style="width:700px">
                            <tr>
                                <td style="width:100%" >
                                ' . $technicalManualBlock->fetchHtml() . '
                                </td>
                            </tr>
                        </table>
                        <br />
                    </td>
                </tr>
            </table>
            <br />
        </div>';

        $objResponse->assign('module_main_panel', 'innerHTML', $getgt_data);
        $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_TECH_MANUAL));
    }

    return $objResponse;
}

?>
