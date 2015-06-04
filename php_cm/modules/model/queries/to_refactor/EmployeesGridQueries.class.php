<?php

/**
 * Description of EmployeesGridQueries
 *
 * @author hans.prins
 */

require_once('modules/model/queries/to_refactor/DataQueries.class.php');

class EmployeesGridQueries extends DataQueries
{
    public function getEmployeesBasedOnUserLevel($a_getValues)
    {
        @$filterscount  = $a_getValues['filterscount'];
        @$sortField     = $a_getValues['sortdatafield'];
        @$sortOrder     = strtoupper($a_getValues['sortorder']);
        @$pageNum       = $a_getValues['pagenum'];
        @$pageSize      = $a_getValues['pagesize'];
        
        // conversie tabel: GRID kolomnamen naar dB kolomnamen (voor juiste selectie in de dB)
        $rowName['id'] = 'e.ID_E';
        $rowName['ln'] = 'e.lastname';
        $rowName['fn'] = 'e.firstname';
        $rowName['sn'] = 'e.SN';
        $rowName['sx'] = 'e.sex';
        $rowName['bd'] = 'e.birthdate';
        $rowName['na'] = 'e.nationality';
        $rowName['pn'] = 'e.phone_number';
        $rowName['ad'] = 'e.address';
        $rowName['pc'] = 'e.postal_code';
        $rowName['ci'] = 'e.city';
        $rowName['ea'] = 'e.email_address';
        $rowName['fp'] = 'f.function';
        $rowName['dp'] = 'de.department';
        $rowName['ib'] = 'e.is_boss';
        
        $limit = !empty($pageSize) ? $pageNum * $pageSize . ',' . $pageSize : '';

        $sort = !empty($sortField) ? $rowName[$sortField ]. ' ' . $sortOrder : 'e.lastname,e.firstname';

		if ($filterscount > 0){

			for ($i=0; $i < $filterscount; $i++) {
                
				$filtervalue = $_GET['filtervalue' . $i];
				$filtercondition = $_GET['filtercondition' . $i];
				$filterdatafield = $rowName[$_GET['filterdatafield' . $i]];

                $filter .= ' AND ';

				switch($filtercondition) {
                    
					case 'CONTAINS':
						$filter .= ' ' . $filterdatafield . ' LIKE \'%' . $filtervalue . '%\'';
						break;
					case 'DOES_NOT_CONTAIN':
						$filter .= ' ' . $filterdatafield . ' NOT LIKE \'%' . $filtervalue . '%\'';
						break;
					case 'EQUAL':
						$filter .= ' ' . $filterdatafield . ' = \'' . $filtervalue . '\'';
						break;
					case 'NOT_EQUAL':
						$filter .= ' ' . $filterdatafield . ' <> \'' . $filtervalue . '\'';
						break;
					case 'GREATER_THAN':
						$filter .= ' ' . $filterdatafield . ' > \'' . $filtervalue . '\'';
						break;
					case 'LESS_THAN':
						$filter .= ' ' . $filterdatafield . ' < \'' . $filtervalue . '\'';
						break;
					case 'GREATER_THAN_OR_EQUAL':
						$filter .= ' ' . $filterdatafield . ' >= \'' . $filtervalue . '\'';
						break;
					case 'LESS_THAN_OR_EQUAL':
						$filter .= ' ' . $filterdatafield . ' <= \'' . $filtervalue . '\'';
						break;
					case 'STARTS_WITH':
						$filter .= ' ' . $filterdatafield . ' LIKE \'' . $filtervalue . '%\'';
						break;
					case 'ENDS_WITH':
						$filter .= ' ' . $filterdatafield . ' LIKE \'%' . $filtervalue . '\'';
						break;
				}
			}
        }
        
        $query['rowsQuery'] = DataQueries::getDataBasedOnUserLevel( null,
                                                                    null,
                                                                    null,
                                                                    null,
                                                                    null,
                                                                    null,
                                                                    true,
                                                                    false,
                                                                    'e.firstname,
                                                                     e.lastname,
                                                                     e.employee,
                                                                     e.is_boss,
                                                                     e.ID_E,
                                                                     f.ID_F,
                                                                     f.function,
                                                                     de.ID_DEPT,
                                                                     de.department',
                                                                    $sort,
                                                                    $limit,
                                                                    $filter );
        
        $sql = 'SELECT FOUND_ROWS()';
        $query['totalRowsQuery'] = BaseQueries::performQuery($sql);
        
        return $query;
    }
}

?>
