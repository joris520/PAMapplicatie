<?php

require_once('modules/model/service/to_refactor/EmployeeAttachmentsServiceDeprecated.class.php');
require_once('modules/interface/interfaceobjects/base/BaseBlockHtmlInterfaceObject.class.php');

function moduleOptions_showEmployeesArchive() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_EMPLOYEES_ARCHIVE)) {
        ApplicationNavigationService::setCurrentApplicationModule(MODULE_EMPLOYEES_ARCHIVED);

        $sql = 'SELECT
                    e.firstname,
                    e.lastname,
                    e.ID_E,
                    f.function,
                    d.department,
                    e.saved_datetime,
                    e.saved_by_user
                FROM
                    employees e
                    LEFT JOIN functions f
                        ON e.ID_FID = f.ID_F
                    LEFT JOIN department d
                        ON e.ID_DEPTID = d.ID_DEPT
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_DISABLED . '
                ORDER BY
                    e.lastname,
                    e.firstname';
        $archivedEmployees = MysqlUtils::getData($sql, true);

        $employeeArchiveTitle = TXT_UCF('EMPLOYEE_ARCHIVES');

        $employeeArchiveHtml = '
                        <table class="content-table" style="width:850px;">
                            <tr>
                                <th class="bottom_line shaded_title" width="25%">' . TXT_UCF('EMPLOYEE_NAME') . '</th>
                                <th class="bottom_line shaded_title" width="25%">' . TXT_UCF('DEPARTMENT')    . '</th>
                                <th class="bottom_line shaded_title" width="25%">' . TXT_UCF('JOB_PROFILE')   . '</th>
                                <th class="bottom_line shaded_title" width="15%">' . TXT_UCF('DATE_REMOVED')  . '</th>
                                <th class="bottom_line shaded_title actions" width="10%">&nbsp;</th>
                            </tr>';
            if ($archivedEmployees) {
                foreach ($archivedEmployees as $archivedEmployee) {

                    if (PermissionsService::isAddAllowed(PERMISSION_EMPLOYEES_ARCHIVE)) {
                        $actions = '<a href="" title="' . TXT_UCF('RESTORE_EMPLOYEE') . '" onclick="xajax_moduleSettings_restoreEmployee(' . $archivedEmployee[ID_E] . ');return false;"><img src="' . ICON_UNDO . '" class="icon-style" border="0"></a>
                                    <a href="" title="' . TXT_UCF('PERMANENTLY_REMOVE_EMPLOYEE') . '" onclick="xajax_moduleSettings_executeDeleteEmployee(' . $archivedEmployee[ID_E] . ');return false;"><img src="' . ICON_DELETE . '" class="icon-style" border="0"></a>';
                    } else {
                        $actions = '&nbsp;';
                    }

                    $employeeArchiveHtml .= '
                                    <tr>
                                        <td class="bottom_line">' . ModuleUtils::EmployeeName($archivedEmployee['firstname'], $archivedEmployee['lastname']) . '</td>
                                        <td class="bottom_line">' . $archivedEmployee['department'] . '</td>
                                        <td class="bottom_line">' . $archivedEmployee['function'] . '</td>
                                        <td class="bottom_line" title="' .  $archivedEmployee['saved_by_user'] . '">' . DateUtils::convertToDisplayDate($archivedEmployee['saved_datetime']) . '</td>
                                        <td class="bottom_line actions" id="deleteaction_' . $archivedEmployee['ID_E'] . '">' . $actions . '</td>
                                    </tr>';
                }
            } else {
                $employeeArchiveHtml .= '
                                    <tr>
                                        <td colspan="100%">' . TXT_UCF('NO_ARCHIVE_EMPLOYEE_S_RETURN') . '</td>
                                    </tr>';
            }
            $employeeArchiveHtml .= '
                                </table>';

        $employeeArchiveBlock = BaseBlockHtmlInterfaceObject::create($employeeArchiveTitle, 850);
        $employeeArchiveBlock->setContentHtml($employeeArchiveHtml);

        $html = '
        <table border="0" align="center" width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <table align="center">
                        <tr>
                            <td>
                                ' . $employeeArchiveBlock->fetchHtml() . '
                            <br/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>';


        $objResponse->assign('module_main_panel', 'innerHTML', $html);
        $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_EMPLOYEES_ARCHIVED));
    }

    return $objResponse;
}

function moduleSettings_restoreEmployee($id_e) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isAddAllowed(PERMISSION_EMPLOYEES_ARCHIVE)) {

        BaseQueries::startTransaction();

        $sql = 'UPDATE
                    employees
                SET
                    is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $id_e;
        BaseQueries::performUpdateQuery($sql);

        // Bij het terugzetten (reactiveren) van de medewerker moet de boss_fid NULL gemaakt worden als diens leidinggevende
        // niet meer actief is.

        $sql = 'UPDATE
                    employees e
                    INNER JOIN employees b
                        ON b.ID_E = e.boss_fid
                SET
                    e.boss_fid = NULL
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND e.ID_E = ' . $id_e . '
                    AND b.is_inactive = ' . EMPLOYEE_IS_DISABLED;

        $isUpdated = BaseQueries::performUpdateQuery($sql);

        BaseQueries::finishTransaction();

        if ($isUpdated > 0) {
            $objResponse->alert(TXT_UCF('EMPLOYEE_HAS_BEEN_RESTORED') . ".\n\n" . TXT_UCF('EMPLOYEE_HAS_REMOVED_BOSS'). '.');
        } else {
            $objResponse->alert(TXT_UCF('EMPLOYEE_HAS_BEEN_RESTORED'));
        }
        $objResponse->loadCommands(moduleOptions_showEmployeesArchive());
    }

    return $objResponse;
}

function moduleSettings_executeDeleteEmployee($id_e) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEES_ARCHIVE)) {
        $objResponse->confirmCommands(2, TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_PERMANENTLY_DELETE_THE_EMPLOYEE'));
        InterfaceXajax::addClass($objResponse, 'deleteaction_' . $id_e , 'inactive_actions');
        $objResponse->call('xajax_executePermanentlyDeleteEmployee', $id_e);
    }

    return $objResponse;
}

function DeleteFromTableForEmployee($table, $employee_id)
{
    $sql = 'DELETE
            FROM
                ' . $table . '
            WHERE
                customer_id = ' . CUSTOMER_ID . '
                AND ID_E = ' . $employee_id;
    BaseQueries::performDeleteQuery($sql);
}

function executePermanentlyDeleteEmployee($id_e)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) &&
        PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEES_ARCHIVE)) {

        try {
            // start de transactie
            BaseQueries::startTransaction();


            $sql = 'SELECT
                        ID_E
                    FROM
                        employees
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND ID_E = ' . $id_e . '
                        AND is_inactive = ' . EMPLOYEE_IS_DISABLED;
            $check_employee = BaseQueries::performTransactionalSelectQuery($sql);

            if (@mysql_num_rows($check_employee) == 1) { // er mag er maar 1 (niet actieve) zijn
            //
                // verwijderen van data in nieuwe tabellen (sprint 12)
                DeleteFromTableForEmployee('employee_assessment', $id_e);
                DeleteFromTableForEmployee('employee_assessment_process', $id_e);
                DeleteFromTableForEmployee('employee_assessment_evaluation', $id_e);
                DeleteFromTableForEmployee('employee_assessment_final_result', $id_e);
                DeleteFromTableForEmployee('employee_assessment_question_answer', $id_e);
                DeleteFromTableForEmployee('employee_competence_score', $id_e);
                DeleteFromTableForEmployee('employee_job_profile_function', $id_e);
                DeleteFromTableForEmployee('employee_job_profile', $id_e);
                DeleteFromTableForEmployee('employee_target_data', $id_e);
                DeleteFromTableForEmployee('employee_target', $id_e);

                // als leidinggevende ook mogelijk data in tabellen
                $sql = 'DELETE
                        FROM
                            boss_assessment_process
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND boss_fid = ' . $id_e;
                BaseQueries::performDeleteQuery($sql);


                // de "oude" data
                DeleteFromTableForEmployee('employees_points', $id_e);

                // ook de taken van andere medewerkers waarvan deze medewerker de taakeigenaar is weggooien
                $sql = 'DELETE
                        FROM
                            employees_pdp_tasks
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND (   ID_PDPTO =  (   SELECT
                                                        ID_PDPTO
                                                    FROM
                                                        pdp_task_ownership
                                                    WHERE
                                                        customer_id = ' . CUSTOMER_ID . '
                                                        AND ID_E = ' . $id_e . '
                                                )
                                    OR ID_E = ' . $id_e . '
                                )';
                BaseQueries::performDeleteQuery($sql);

                DeleteFromTableForEmployee('pdp_task_ownership', $id_e);

                // TODO: controle is_level
                // TODO: tasks?
                $sql = 'DELETE
                        FROM
                            alerts
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND ID_PDPEA in (   SELECT
                                                    ID_PDPEA
                                                FROM
                                                    employees_pdp_actions
                                                WHERE
                                                    customer_id = ' . CUSTOMER_ID . '
                                                    AND ID_E = ' . $id_e . '
                                            )';
                BaseQueries::performDeleteQuery($sql);

                DeleteFromTableForEmployee('employees_pdp_actions', $id_e);

                // evaluatie periode, taakdoelen en evaluaties
                // eerst evaluaties
                $sql = 'DELETE
                        FROM
                            employees_objectives_eval
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND ID_EOBJ IN  (   SELECT
                                                    eo.ID_EOBJ
                                                FROM
                                                    employees_objectives eo
                                                    INNER JOIN employees_objective_period eop
                                                        ON eop.ID_EOP = eo.ID_EOBJP
                                                WHERE
                                                    eop.customer_id = ' . CUSTOMER_ID . '
                                                    AND eop.ID_E = ' . $id_e . '
                                            )';
                BaseQueries::performDeleteQuery($sql);

                // eerst dan de taakdoelen
                $sql = 'DELETE
                        FROM
                            employees_objectives
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND ID_EOBJP in (   SELECT
                                                    ID_EOP
                                                FROM
                                                    employees_objective_period
                                                WHERE
                                                    customer_id = ' . CUSTOMER_ID . '
                                                    AND ID_E = ' . $id_e . '
                                            )';
                BaseQueries::performDeleteQuery($sql);

                // en tenslotte de evaluatieperiode
                DeleteFromTableForEmployee('employees_objective_period', $id_e);

                // historie opruimen
                $sql = 'DELETE
                        FROM
                            employees_history_points
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND ID_EHPD IN (    SELECT
                                                    ID_EHPD
                                                FROM
                                                    employees_history_points_date
                                                WHERE
                                                    customer_id = ' . CUSTOMER_ID . '
                                                    AND ID_E = ' . $id_e . '
                                            )';
                BaseQueries::performDeleteQuery($sql);

                $sql = 'DELETE
                        FROM
                            employees_history_total_scores
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND ID_EHPD in (    SELECT
                                                    ID_EHPD
                                                FROM
                                                    employees_history_points_date
                                                WHERE
                                                    customer_id = ' . CUSTOMER_ID . '
                                                    AND ID_E = ' . $id_e . '
                                            )';
                BaseQueries::performDeleteQuery($sql);

                $sql = 'DELETE
                        FROM
                            employees_history_misc_answers
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND ID_EHPD in (    SELECT
                                                    ID_EHPD
                                                FROM
                                                    employees_history_points_date
                                                WHERE
                                                    customer_id = ' . CUSTOMER_ID . '
                                                    AND ID_E = ' . $id_e . '
                                            )';
                BaseQueries::performDeleteQuery($sql);

                DeleteFromTableForEmployee('employees_history_points_date', $id_e);

                $sql = 'SELECT
                            *
                        FROM
                            employees_documents
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND ID_E = ' . $id_e ;
                $get_ed = BaseQueries::performTransactionalSelectQuery($sql);

                if (@mysql_num_rows($get_ed) > 0) {
                    while ($ed_row = @mysql_fetch_assoc($get_ed)) {
                        EmployeeAttachmentsServiceDeprecated::DeleteAttachment($ed_row['document_pad'], $ed_row['id_contents']);
                    }
                }

                DeleteFromTableForEmployee('employees_topics', $id_e);
                DeleteFromTableForEmployee('employees_documents', $id_e);
                DeleteFromTableForEmployee('employees_additional_functions', $id_e);
                DeleteFromTableForEmployee('_employees_total_scores', $id_e);

                $sql = 'SELECT
                            ID_TSIM,
                            ID_TSIM1,
                            ID_TSIM2,
                            ID_TSIM_LOS
                        FROM
                            threesixty_invitations
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND ID_E = ' . $id_e;
                $get_tsinv = BaseQueries::performTransactionalSelectQuery($sql);

                $tsim_ids = array();
                if (@mysql_num_rows($get_tsinv) > 0) {
                    while ($tsinv_row = @mysql_fetch_assoc($get_tsinv)) {
                        $id_tsim = $tsinv_row['ID_TSIM'];
                        if (isLastInvitation($id_tsim)) {
                            $tsim_ids[] = $id_tsim;
                        }
                        $id_tsim = $tsinv_row['ID_TSIM1'];
                        if (isLastInvitation($id_tsim)) {
                            $tsim_ids[] = $id_tsim;
                        }
                        $id_tsim = $tsinv_row['ID_TSIM2'];
                        if (isLastInvitation($id_tsim)) {
                            $tsim_ids[] = $id_tsim;
                        }
                        $id_tsim = $tsinv_row['ID_TSIM_LOS'];
                        if (isLastInvitation($id_tsim)) {
                            $tsim_ids[] = $id_tsim;
                        }
                    }
                }

                DeleteFromTableForEmployee('threesixty_invitations', $id_e);

                if (count($tsim_ids) > 0) {
                    $sql = 'DELETE
                            FROM
                                threesixty_invitations_messages
                            WHERE
                                customer_id = ' . CUSTOMER_ID . '
                                AND ID_TSIM in (' . implode(',', $tsim_ids) . ')';
                    BaseQueries::performDeleteQuery($sql);
                }

                DeleteFromTableForEmployee('threesixty_evaluation', $id_e);

                $sql = 'SELECT
                            id_pd,
                            id_contents,
                            foto_thumbnail
                        FROM
                            employees
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND ID_E = ' . $id_e;
                $get_emp_ids = BaseQueries::performTransactionalSelectQuery($sql);

                $emp_ids = @mysql_fetch_assoc($get_emp_ids);
                $id_pd = $emp_ids['id_pd'];
                $id_contents = $emp_ids['id_contents'];
                $foto_thumbnail = $emp_ids['foto_thumbnail'];

                // omdat de leidinggevende verwijderd is en daar al controles op zaten of de employee verwijderd mocht worden,
                // kan hier van alle subordinates de koppeling verwijderd worden.
                // LETOP: bij het terugzetten (reactiveren) van medewerkers moet de boss_fid NULL gemaakt worden als diens leidinggevende
                // niet meer actief is.
                $sql = 'UPDATE
                            employees
                        SET
                            boss_fid = NULL
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND boss_fid = ' . $id_e;

                BaseQueries::performUpdateQuery($sql);


                DeleteFromTableForEmployee('employees', $id_e);

                // de employee is nu weg,
                if(!empty($id_pd)) {

                    $sql = 'UPDATE
                                threesixty_invitations
                            SET
                                id_pd = NULL
                            WHERE
                                customer_id = ' . CUSTOMER_ID . '
                                AND id_pd   = ' . $id_pd;
                    BaseQueries::performUpdateQuery($sql);

                    $sql = 'DELETE
                            FROM
                                person_data
                            WHERE
                                customer_id = ' . CUSTOMER_ID . '
                                AND id_pd  = ' . $id_pd;
                    BaseQueries::performDeleteQuery($sql);
                }
                if (!empty($id_contents)) {
                    $sql = 'DELETE
                            FROM
                                document_contents
                            WHERE
                                customer_id = ' . CUSTOMER_ID . '
                                AND id_contents = ' . $id_contents;
                    BaseQueries::performDeleteQuery($sql);
                }
                if (!empty($foto_thumbnail)) {
                    @unlink(CUSTOMER_PHOTO_PATH . $foto_thumbnail);
                }

                $sql = 'DELETE
                            ud
                        FROM
                            users_department AS ud,
                            users AS u
                        WHERE
                            ud.customer_id = ' . CUSTOMER_ID . '
                            AND ud.id_uid = u.user_id
                            AND u.ID_E = ' . $id_e;
                BaseQueries::performDeleteQuery($sql);

                // de gebruiker "vervangen" door admin in pdp acties waar deze de actie-eigenaar is.

                $sql = 'UPDATE
                            employees_pdp_actions
                        SET
                            ID_PDPTOID =    (   SELECT
                                                    user_id
                                                FROM
                                                    users
                                                WHERE
                                                    customer_id = ' . CUSTOMER_ID . '
                                                    AND isprimary = 1
                                            )
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND ID_PDPTOID =    (   SELECT
                                                        user_id
                                                    FROM
                                                        users
                                                    WHERE
                                                        customer_id = ' . CUSTOMER_ID . '
                                                        AND ID_E = ' . $id_e . '
                                                    LIMIT 1
                                                )';
                BaseQueries::performUpdateQuery($sql);

                // de gebruiker "vervangen" door admin in alerts

                $sql = 'UPDATE
                            alerts
                        SET
                            user_id =   (   SELECT
                                                user_id
                                            FROM
                                                users
                                            WHERE
                                                customer_id = ' . CUSTOMER_ID . '
                                                AND isprimary = 1
                                        )
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND user_id =     (   SELECT
                                                        user_id
                                                    FROM
                                                        users
                                                    WHERE
                                                        customer_id = ' . CUSTOMER_ID . '
                                                        AND ID_E = ' . $id_e . '
                                                    LIMIT 1
                                                )';
                BaseQueries::performUpdateQuery($sql);

                DeleteFromTableForEmployee('users', $id_e);

                // klaar met de transactie
                BaseQueries::finishTransaction();

                //$objResponse->alert(TXT_UCF('PROFILE_HAS_BEEN_PERMANENTLY_DELETED'));
                $objResponse->loadCommands(moduleOptions_showEmployeesArchive());
            } else {
                $objResponse->alert(TXT_UCF('EMPLOYEE_TO_DELETE_NOT_FOUND'));
            }
        } catch (TimecodeException $timecodeException) {
            PamExceptionProcessor::handleInterfaceException($objResponse, $timecodeException);
        }
    }
    return $objResponse;
}

function isLastInvitation($id_tsim)
{
    $isLast = false;
    if (!empty($id_tsim)) {
        $sql = 'SELECT
                    COUNT(*) as used_by_invitations
                FROM
                    threesixty_invitations
                WHERE
                    ID_TSIM = ' . $id_tsim . '
                    OR ID_TSIM1 = ' . $id_tsim . '
                    OR ID_TSIM2 = ' . $id_tsim . '
                    OR ID_TSIM_LOS = ' . $id_tsim;
        $query = BaseQueries::performQuery($sql);
        $used_by_invitations_count = @mysql_fetch_assoc($query);
        $isLast = ($used_by_invitations_count['used_by_invitations'] == 1);
    }
    return $isLast;
}

?>
