<?php

/**
 * Manages Customer
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to the MIT License, available at http://www.opensource.org/licenses/mit-license.html
 *
 * @author Abimbola Hassan <ahassan@infinitizon.com>
 * @copyright 2012 infinitizon Design
 * @license http://www.opensource.org/licenses/mit-license.html
 */
class Customer extends DB_Connect {

    /**
     * The eventual customer
     * @var string Stores any returned value
     */
    private $the_customer;
    private $fxns;

    /**
     * Creates a database object and stores relevant data
     *
     * Upon instantiation, this class accepts a database object that, if not null, is stored in the object's private $_db
     * property. If null, a new PDO object is created and stored instead.
     *
     * @param object $dbo a database object
     * @return void
     */
    public function __construct($dbo = NULL) {
        /*
         * Call the parent constructor to check for a database object
         */
        parent::__construct($dbo);
        $this->fxns = new Functions($dbo);
    }

    /**
     * Returns an array of customer info. If $limit, then useful for search
     *
     * @return Array
     */
    public function _doCustSearch($text, $limit = 4) {
        $search_term = $this->fxns->_multiexplode($text);
        $search_term = $this->fxns->_strCombs($search_term, array(), "m.FULLNAME_");

        $sql_getCusts = "SELECT m.PARTYROLE_ID, m.CUSTOMERID_, m.TYPE_ID, m.FULLNAME_";
        $sql_getCusts .= ", (SELECT p.TOTALASSETVALUE_ FROM PARTYROLE_ p WHERE p.PARTYROLE_ID = m.PARTYROLE_ID) TOTALASSETVALUE_";
        $sql_getCusts .= ", (SELECT a.NAME_ FROM PARTYROLETYPE_ a WHERE m.TYPE_ID = a.PARTYROLETYPE_ID) custTpNm ";
        $sql_getCusts .= "FROM MIGRATION_ m";
        $sql_getCusts .= " WHERE (m.FULLNAME_ LIKE " . $search_term;
        $sql_getCusts = $this->fxns->_subStrAtDel($sql_getCusts, "'", $fromRear = true); //Truncate unnecesary part of string
        $sql_getCusts .= ") AND m.TYPE_ID IN (4,5) AND IFNULL(m.ISDUPLICATE_,0) = 0 ";
        $sql_getCusts .= "AND m.LOCALE_ = 'NG' ";
        $sql_getCusts .= "OR m.PARTYROLE_ID=(SELECT a.CUSTOMER_PORTFOLIO_ID FROM ACCOUNT_ a
		WHERE a.BROKERAGENUMBER_ ='{$text}' OR a.MONEYMARKETNUMBER_='{$text}' 
			OR a.TREASURYBILLNUMBER_='{$text}' OR ACCOUNTNUMBER_ = '{$text}') ";
        $sql_getCusts .= "ORDER BY m.FULLNAME_ ";
        $sql_getCusts .= ($limit) ? " LIMIT $limit" : "";
        $results = array();
        try {
            $stmt = $this->dbo->prepare($sql_getCusts);
            $stmt->execute();
            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $results[] = ($limit) ? array('label' => $result['FULLNAME_']) : $result;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return $results;
    }

    /**
     * Returns an individual customer detail. If $limit, then useful for search
     *
     * @return Array
     */
    public function _getCusts($partyRoleId) {
        $sql_getCust = "SELECT m.PARTYROLE_ID, m.CUSTOMERID_, m.TYPE_ID, m.PARTY_ID, m.PARTYTITLE_ID";
        $sql_getCust .= ", LEGACYSTACCOUNTNUMBER_, LEGACYSTCUSTOMERID_, LEGACYIMCUSTOMERID_, LEGACYMMACCOUNTNUMBER_, LEGACYTBILLSACCOUNTNUMBER_";
        $sql_getCust .= ", (SELECT GROUP_CONCAT(ACCOUNTNUMBER_) FROM ACCOUNT_
WHERE PRODUCT_ID = '655949824' AND CUSTOMER_PORTFOLIO_ID = m.PARTYROLE_ID) ERPST_ACC_NOS";
        $sql_getCust .= ", m.FIRSTNAME_, m.MIDDLENAME_, m.LASTNAME_, m.INITIALS_, m.GENDER_ID, m.MARITALSTATUSTYPE_ID";
        $sql_getCust .= ", m.MAIDENNAME_, DATE_FORMAT(m.DATEOFBIRTH_, '%b-%d-%Y') AS DATEOFBIRTH_, m.PRIMARYEMAILADDRESS_";
        $sql_getCust .= ", m.COUNTRY_ID, m.PRIMARYPHONENO_, m.WORKPHONENUMBER_, m.KINRELATIONSHIPTYPE_ID, m.KINFIRSTNAME_, m.KINLASTNAME_";
        $sql_getCust .= ", m.KINOTHERNAMES_, m.KINCONTACTPHONENUMBER_, m.KINADDRESS_, m.ADDRESSLINE1_, m.ADDRESSLINE2_, m.ADDRESSCITY_";
        $sql_getCust .= ", m.ADDRESSSTATE_ID, m.ADDRESSCOUNTRY_ID, m.FULLNAME_";
        $sql_getCust .= ", (SELECT p.TOTALASSETVALUE_ FROM PARTYROLE_ p WHERE p.PARTYROLE_ID = m.PARTYROLE_ID) TOTALASSETVALUE_";
        $sql_getCust .= " FROM MIGRATION_ m ";
        $sql_getCust .= "WHERE m.PARTYROLE_ID IN ($partyRoleId)";
        $sql_getCust .= " AND LOCALE_ = 'NG' ";
        //return $sql_getCust;
        return $this->fxns->_execQuery($sql_getCust, true);
    }

    /**
     * Returns customers detail by status type.
     *
     * @return Array
     */
    public function _getCustsByStatus($statusType = 'CUSTOMERMIGRATIONSTATUS_', $value = 1, $moreClause = '') {
        $sql_getCust = "SELECT m.PARTYROLE_ID, m.CUSTOMERID_, m.TYPE_ID";
        $sql_getCust .= ", (SELECT a.NAME_ FROM PARTYROLETYPE_ a WHERE m.TYPE_ID = a.PARTYROLETYPE_ID) custTpNm";
        $sql_getCust .= ", m.PARTY_ID, m.PARTYTITLE_ID";
        $sql_getCust .= ", ERPST_ACC_NOS, LEGACYSTACCOUNTNUMBER_, LEGACYSTCUSTOMERID_, LEGACYIMCUSTOMERID_, LEGACYMMACCOUNTNUMBER_, LEGACYTBILLSACCOUNTNUMBER_";
        $sql_getCust .= ", m.FIRSTNAME_, m.MIDDLENAME_, m.LASTNAME_, m.INITIALS_, m.GENDER_ID, m.MARITALSTATUSTYPE_ID";
        $sql_getCust .= ", m.MAIDENNAME_, DATE_FORMAT(m.DATEOFBIRTH_, '%b-%d-%Y') AS DATEOFBIRTH_, m.PRIMARYEMAILADDRESS_";
        $sql_getCust .= ", m.COUNTRY_ID, m.PRIMARYPHONENO_, m.WORKPHONENUMBER_, m.KINRELATIONSHIPTYPE_ID, m.KINFIRSTNAME_, m.KINLASTNAME_";
        $sql_getCust .= ", m.KINOTHERNAMES_, m.KINCONTACTPHONENUMBER_, m.KINADDRESS_, m.ADDRESSLINE1_, m.ADDRESSLINE2_, m.ADDRESSCITY_";
        $sql_getCust .= ", m.ADDRESSSTATE_ID, m.ADDRESSCOUNTRY_ID, m.FULLNAME_";
        $sql_getCust .= ", (SELECT p.TOTALASSETVALUE_ FROM PARTYROLE_ p WHERE p.PARTYROLE_ID = m.PARTYROLE_ID) TOTALASSETVALUE_";
        $sql_getCust .= ", ISNAMEVALID_, ISEMAILVALID_, ISPHONENOVALID_, ISADDRESSVALID_, ISCUSTOMERMAPPED_, ISDUPLICATE_, DUPLICATE_ID";
        $sql_getCust .= ", DATEMARKEDDUPLICATE_, CUSTOMERMIGRATIONSTATUS_, STACCOUNTMIGRATIONSTATUS_, MMACCOUNTMIGRATIONSTATUS_";
        $sql_getCust .= ", TBILLSACCOUNTMIGRATIONSTATUS_";
        $sql_getCust .= " FROM MIGRATION_ m ";
        $sql_getCust .= " WHERE m.$statusType IN ($value) ";
        $sql_getCust .= $moreClause;
        return $this->fxns->_execQuery($sql_getCust, true);
    }

    /**
     * Returns account details for a set of customers
     *
     * @return Array
     */
    public function _getCustsAccs($accORID, $isMultiple = true) {
        $sql_accORID = "SELECT * ";
        $sql_accORID .= "FROM ACCOUNT_ a ";
        $sql_accORID .= "WHERE a.ACCOUNTNUMBER_ IN ($accORID) ";
        $sql_accORID .= "OR a.ACCOUNT_ID IN ($accORID)";
        return $this->fxns->_execQuery($sql_accORID, true, $isMultiple);
    }

    /**
     * Public function drawTable - Builds a table with paging abilities based on the cleanup process
     *
     * @return builtTable
     */
    public function _drawTable($query, $MigTitle, $extras = array()) {
        ### $extraVals options:
        ### type: Type you want to call
        ### chrtTp: array- 
        ### currentpage: the current page when paging the result query
        ### rowsperpage: Rows per page for the paging
        ### hiddenFields: The columns to hide
        ### button: array - class -for the classname of the button; value - What to show as label
        //var_dump($extras);exit;
        $extraVals = array('type' => 'acc', 'typeVals' => array(), 'chrtTp' => array()
                            , 'currentpage' => 1, 'rowsperpage'=>15, 'hiddenFields' => array(), 'ready'=>1
                            , 'button'=>array('class'=>'migrate', 'value'=>'Migrate')
                        );
        $extras = array_merge($extraVals, $extras);
        $hiddenFields = $extras['hiddenFields'];
        $ready = $extras['ready'];
        
        
        
        $sqlSearchCount = "SELECT COUNT(*) count FROM ({$query}) x";
        $rowsperpage = $extras['rowsperpage'];
        //print_r($sqlSearchCount);exit;
        $sqlSearchCount = $this->fxns->_execQuery($sqlSearchCount, true, false);
        $preparePaging = $this->fxns->_preparePaging($sqlSearchCount['count'], $rowsperpage, $extras['currentpage']);
        $query = $query . " LIMIT {$preparePaging['offset']}, {$rowsperpage}";

        $migrationStatus = $this->fxns->_execQuery($query, true);
        $numRows = count($migrationStatus);
        array_unshift($migrationStatus, $MigTitle);
        //var_dump($migrationStatus); exit;
        $numCols = count($migrationStatus[0]);
        $table = '<form method="post" action="">';
        $table = '<table  class="my_tables clickable">';
        for ($i = 0; $i < count($migrationStatus); $i++) {
            $table .= (($i == 0)?"<thead>":""). "<tr>";
            foreach ($migrationStatus[0] as $key => $values) {
                if ($i == 0) {
                    $table .=in_array($key, $hiddenFields) ? "<th>&nbsp;</th>" : "<th>" . $migrationStatus[$i][$key] . "</th>";
                } else {
                    if ($key == 'PARTYROLE_ID') {
                        $table .= '<td>'
                                . '<input type="checkbox" name="cust_id['.$i.']" '
                                . 'value="' . $migrationStatus[$i][$key] . '" '
                                . 'data-role-type="' . @$migrationStatus[$i]["TYPE_ID"] . '" />'
                                . (($extras['type']=='acc')?'<input type="hidden" name="acc_tp['.$i.']" value="'.@$migrationStatus[$i]["AccountTp"].'" />':"")
                                . '</td>';
                    } elseif ($key == 'ACCOUNTSTATUS_' || $key == 'CUSTOMERMIGRATIONSTATUS_') {
                        $statTp = ($key == 'ACCOUNTSTATUS_') ? 'ACCOUNTSTATUS_' : 'CUSTOMERMIGRATIONSTATUS_';
                        switch ($migrationStatus[$i][$statTp]) {
                            case 1:
                                $table .='<td>Ready For Migration</td>';
                                @$ready = 1;
                                break;
                            case 2: $table .='<td>Migrated</td>';
                                @$ready = 0;
                                break;
                            default: $table .='<td>Not Migrated</td>';
                                @$ready = 0;
                                break;
                        }
                    } elseif ($key == 'dataStatus') {
                        switch ($migrationStatus[$i]['dataStatus']) {
                            case 1: $table .='<td>Correct</td>';
                                break;
                            default: $table .='<td>Not Correct</td>';
                                break;
                        }
                    } elseif ($key == 'TOTALASSETVALUE_') {
                        //$prId = $migrationStatus[$i]["PARTYROLE_ID"];
                        //$cust_det = $this->_getCustDetails(array($prId), $migrationStatus[$i]["TYPE_ID"]);
                        //$table .="<td>" . $this->fxns->_formatMoney($cust_det[$prId]["totalValue"], true) . "</td>";
                        $table .="<td style=\"text-align:right;\">" . $this->fxns->_formatMoney($migrationStatus[$i][$key], true) . "</td>";
                    } else {
                        $table .="<td>" . $migrationStatus[$i][$key] . "</td>";
                    }
                }
            }
            $table .= "</tr>".(($i == 0)?"</thead>":"");
        }
        if ($numRows == 0) {
            $table .= "<tr><td colspan=\"$numCols\" style=\"background:#CCC; text-align:center\">No records found</td></tr>";
        }
        //$param = "type={$extras['type']}&typeVals=" . implode(",", $extras['typeVals']);
        //$param .= "&chrtTp=" . @$extras['chrtTp'][0] . "&chrtTpVals=" . @$extras['chrtTp'][1];
        $param = "extras=".base64_encode(serialize($extras));
        $table .= "<tr><td colspan=" . (count($migrationStatus[0])) . " style=\"text-align:center;\">" . $this->fxns->_buildPagingLinks($range = 5, $preparePaging['currentpage'], $preparePaging['totalpages'], array('div' => 'phpPaging', 'link' => 'success dashboard', 'param' => $param), @$webLink) . "</td></tr>";
    
        $table .= '</table>';
        $table .= ($ready == 1) ? '<a href="" class="button '.$extras['button']['class'].'" style="float:right;color:#FFF;" data-role="'.$param.'" >'.$extras['button']['value'].'</a>' : '';
        $table .= '</form>';
        return $table;
    }

    /**
     * Returns an individual customer detail. If $limit, then useful for search
     *
     * @return Array
     */
    public function _buildCustEdit($customer) {
        return $this->the_customer;
    }
    /**
     * Returns an individual customer detail... Currently limited to customerId and TotalAssetValue (totalValue)
     *
     * @param array $custId : PartyRoleId of the Customer to be created
     * @param Integer $custTp : CustomerType of the Customer to search. 5=Individual, 4=Corporate
     * 
     * @return Array: Customer details - Currently limited to customerId and TotalAssetValue (totalValue)
     */
    public function _getCustDetails($partyRoleId, $custTp=5){
        $tot_autrole = count($_SESSION['user_dets']['authrole']);
        $rand_autrole = rand(0, $tot_autrole - 1);
        $headers = unserialize (WEBSERVICE_AUTH);
        
        $custTp = ($custTp==5)?'IndividualCustomer':'CorporateCustomer';

        $xml = '<QUERY currentLocale="NG" currentRole="SALES_OFFICER" entity="'.$custTp.'" firstresult="0">
                <CRITERIA><OREXPRESSION>';
                foreach($partyRoleId as $custs){
                    $xml .= '<EQUALEXPRESSION label="Customer Name" type="contains"> <PATH>id</PATH><VALUE type="Long">'.$custs.'</VALUE> </EQUALEXPRESSION>';
                }
        $xml .= '</OREXPRESSION></CRITERIA>
                <ENTITYSPECS>
                  <ENTITYSPEC name="'.$custTp.'">
                      <PROPERTY align="center" label="Customer ID" no_update="readOnly" path="customerId"/>
                      <PROPERTY label="Last Name" path="party.fullName"/>
                      <PROPERTY label="Total Asset Value" path="totalValue"/>
                  </ENTITYSPEC>
                </ENTITYSPECS>
              </QUERY>';
        $output = $this->fxns->_consumeService(WEB_SERVICE_URL, $xml, $headers);
        $query_response = simplexml_load_string($output);
        if (@$query_response->ENTITY) {
            foreach($query_response->ENTITY as $key => $val){
                foreach ($val as $key2 => $property) {
                    if(in_array($property['path'], array('customerId','totalValue'))){
                        $customer[(String)$val['id']][(String)$property['path']] = (String) $property['value'];
                    }
                }
            }
            return $customer;
        }elseif (@$query_response->ERRORS) {
            return $query_response->ERRORS->ERROR['message'];
        } else { // Didnt get a response
            return "Server may be unavailable";
        }
    }

    /**
     * Creates a customer account type for that which is specified
     *
     * @param string $custId : Customer Id of the Customer to be created
     * @param string $accountProduct : Product code of the account to be created
     * 
     * @return Array: Key1 - Code(0=Failure, 1=Success). Key2 - String representing the message
     */
    public function _createCustAcc($custId, $accountProduct) {
        $tot_autrole = count($_SESSION['user_dets']['authrole']);
        $rand_autrole = rand(0, $tot_autrole - 1);
        $headers = unserialize (WEBSERVICE_AUTH);
        $sqlGetProdNm = "SELECT NAME_ FROM ACCOUNTPRODUCT_ WHERE ACCOUNTPRODUCT_ID = $accountProduct AND ACTIVE_=1";
        $ProdNm = $this->fxns->_execQuery($sqlGetProdNm, TRUE, FALSE);
        $newAccStart = '<?xml version="1.0" encoding="UTF-8"?>'
                . '<TRANSACTION currentLocale="' . $_SESSION['user_dets']['locale'][0] . '" currentRole="' . $_SESSION['user_dets']['authrole'][$rand_autrole] . '">'
                . '<CREATE entity="FinancialAccount"/>'
                . '<ENTITYSPEC checkNode="' . $ProdNm['NAME_'] . '" name="FinancialAccount">'
                . '<PROPERTY path="owner" type="Customer"/>'
                . '<PROPERTY path="productType"/>'
                . '<PROPERTY path="product" type="AccountProduct" value="' . $accountProduct . '"/>'
                . '<PROPERTY path="financeType"/>'
                . '</ENTITYSPEC>'
                . '</TRANSACTION>';
        $outputStart = $this->fxns->_consumeService(WEB_SERVICE_URL, $newAccStart, $headers);
        $query_response = simplexml_load_string($outputStart);
        if (@$query_response->ENTITY['id']) {
            $newAccFinish = '<?xml version="1.0" encoding="UTF-8"?>'
                    . '<TRANSACTION currentLocale="' . $_SESSION['user_dets']['locale'][0] . '" currentRole="' . $_SESSION['user_dets']['authrole'][$rand_autrole] . '">'
                    . '<UPDATE entity="FinancialAccount" name="' . $ProdNm['NAME_'] . '" id="' . $query_response->ENTITY['id'] . '">'
                    . '<PROPERTY type="Boolean" path="createAccount" value="false"/>'
                    . '<PROPERTY type="AccountProduct" path="product"><ENTITY entityspec="AccountProduct" idref="' . $accountProduct . '"/></PROPERTY>'
                    . '<PROPERTY type="Customer" path="owner"><ENTITY entityspec="Customer" idref="' . $custId . '"/></PROPERTY>'
                    . '</UPDATE>'
                    . '<ENTITYSPEC label="Financial Account Information" name="FinancialAccount">'
                    . '<PROPERTY align="center" label="Account No" no_update="readOnly" path="accountNumber"/>'
                    . '<PROPERTY align="center" label="Active" no_update="readOnly" path="isActive"/>'
                    . '<PROPERTY displayexpression="name" label="Account Type" path="product"/>'
                    . '</ENTITYSPEC>'
                    . '</TRANSACTION>';
            $outputFinish = $this->fxns->_consumeService(WEB_SERVICE_URL, $newAccFinish, $headers);
            $query_response = simplexml_load_string($outputFinish);
            if (@$query_response->ENTITY['id']) {
                @$success = $query_response->ENTITY['id'];
            } elseif (@$query_response->ERRORS) {
                @$error[] .= $query_response->ERRORS->ERROR['message'];
            } else { // Didnt get a response
                @$error[] .= "Server may be unavailable";
            }
        } elseif (@$query_response->ERRORS) {
            @$error[] .= $query_response->ERRORS->ERROR['message'];
        } else { // Didnt get a response
            @$error[] .= "Server may be unavailable";
        }
        if (isset($success)) {
            return array('code'=>1,'msg'=> $success);
        } else {
            //echo "MM Account initially did not exist and an attempt to create it failed because<ul>";
            return array('code'=>0,'msg'=> $error);
        }
    }

}

?>