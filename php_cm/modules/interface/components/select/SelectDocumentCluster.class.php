<?php
/**
 * Het SelectDocumentCluster object.
 *
 * @author ben.dokter
 *
 */

require_once('SelectComponent.class.php');
require_once('gino/MysqlUtils.class.php');

class SelectDocumentCluster extends SelectComponent {

    protected $mysqlQuery = "";
    protected $validQuery = false;

    // edit
    protected $cluster_id;

    // results
    protected $selected_document_cluster;

    // verwachte form values
    private $select_field_cluster = 'doc_cluster';

    // instellen voor edit
    public function setSelectedClusterId($cluster_id) {
        $this->cluster_id = $cluster_id;
    }

    public function fillComponent(&$smarty_tpl)
    {
        $sql = 'SELECT
                    *
                FROM
                    document_clusters
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                ORDER BY
                    document_cluster';
        $get_doc_clusters = BaseQueries::performQuery($sql);

        $clusters = MysqlUtils::result2Array2D($get_doc_clusters);
        $smarty_tpl->assign('selected_cluster_id', $this->cluster_id);
        $smarty_tpl->assign('select_field_cluster', $this->select_field_cluster);
        $smarty_tpl->assign('clusters', $clusters);
    }

    // verwachte form values (zie definities bovenin):
    // - doc_cluster
    public function validateFormInput($FORM_array)
    {
        $this->errorTxt = '';
        // We kunnen hier alle clusters checken, maar dat is niet echt nodig...
        $this->selected_document_cluster = $FORM_array[$this->select_field_cluster];

        return true;
    }

    // fields:
    // - selected_cluster
    public function processResults($FORM_array)
    {
        if ($this->validateFormInput($FORM_array)) {
            $results = $this->getResults();
        } else {
            $results = array();
        }
        return $results;
    }

    // fields:
    // - selected_cluster
    public function getResults()
    {
        $results = array('selected_cluster' => $this->selected_document_cluster);

        return $results;
    }

}

?>
