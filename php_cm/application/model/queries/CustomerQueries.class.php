<?php

/**
 * Description of CustomerQueries
 *
 * @author ben.dokter
 */

class CustomerQueries
{

    static function getCompanyInfo()
    {
        return self::getCompanyInfoByCustomer(CUSTOMER_ID);
    }

    static function getCompanyInfoByCustomer($i_customer_id)
    {
        $sql = 'SELECT
                    *
                FROM
                    customers
                WHERE
                    customer_id = ' . $i_customer_id . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function GetCustomerInfoByUser($s_login)
    {
        $sql = 'SELECT
                    CASE
                        WHEN
                            c.customer_id IS NULL
                        THEN 0
                        ELSE c.customer_id
                    END AS calculated_customer_id,
                    u.name,
                    u.user_level,
                    u.isprimary,
                    u.user_id,
                    u.username,
                    u.email,
                    u.ID_E,
                    u.allow_access_all_departments,
                    e.is_boss,
                    t.css_file,
                    t.ID_T,
                    c.num_employees,
                    c.company_name,
                    c.lang_id,
                    c.logo,
                    c.logo_size_width,
                    c.logo_size_height,
                    co.*,
                    cl.*
                FROM
                    users u
                    LEFT JOIN employees e
                        ON e.ID_E = u.ID_E
                    LEFT JOIN customers c
                        ON c.customer_id = u.customer_id
                    LEFT JOIN customers_options co
                        ON co.customer_id = u.customer_id
                    LEFT JOIN customers_labels cl
                    ON cl.customer_id = u.customer_id
                    LEFT JOIN themes t
                        ON t.ID_T = c.theme_id
                WHERE
                    u.username = "' . $s_login . '"
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getEmployeeCountInfo()
    {
        $sql = 'SELECT
                    COUNT(e.ID_E) as employees_count,
                    c.num_employees as max_allowed_employees
                FROM
                    customers c
                    LEFT JOIN employees e
                        ON e.customer_id = c.customer_id
                WHERE
                    c.customer_id = ' . CUSTOMER_ID . '
                GROUP BY
                    c.customer_id';

        return BaseQueries::performSelectQuery($sql);
    }

}

?>
