<?php

/*
 * Include necessary files
 */
include_once 'core/init.inc.php';
require_once('FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance(true);
$firephp->setEnabled(true);

$cust = new Customer($dbo);
$fxns = new Functions($dbo);
if (isset($_REQUEST['term'])) {
    $results = $cust->_doCustSearch($_REQUEST['term'], 8);
    echo json_encode($results);
}
//Array to hold column titles
if (isset($_POST['getStateCtyID'])) {
    $sql_getStateOptLOV = "SELECT GEOGRAPHICBOUNDARY_ID, NAME_ FROM GEOGRAPHICBOUNDARY_
WHERE TYPE_ID = (SELECT GEOGRAPHICBOUNDARYTYPE_ID FROM GEOGRAPHICBOUNDARYTYPE_ WHERE NAME_ = 'State') AND COUNTRY_STATES_ID = " . $_POST['getStateCtyID'];
    $states = $fxns->_getStateOptLOV($sql_getStateOptLOV, "GEOGRAPHICBOUNDARY_ID", "NAME_", "--Select State--", NULL);
    echo $states;
}
$tblTitle = array('PARTYROLE_ID' => 'Party Role ID.', 'PARTY_ID' => 'Party ID.', 'PARTYTITLE_ID' => 'Title', 'CUSTOMERID_' => 'ERP Customer ID'
            , 'LEGACYSTCUSTOMERID_' => 'iBroker ST Customer ID', 'LEGACYIMCUSTOMERID_' => 'iBroker IM Customer ID', 'ERPST_ACC_NOS' => 'ST Account No.'
            , 'LEGACYSTACCOUNTNUMBER_' => 'iBroker ST Account #', 'LEGACYMMACCOUNTNUMBER_' => 'iBroker MM Account #', 'LEGACYTBILLSACCOUNTNUMBER_' => 'iBroker TBills Account #'
            , 'TOTALASSETVALUE_' => 'Total Asset Value (NGN)', 'TYPE_ID' => 'Type ID.', 'FIRSTNAME_' => 'First Name', 'MIDDLENAME_' => 'Middle Name'
            , 'LASTNAME_' => 'Last Name', 'INITIALS_' => 'Initials', 'GENDER_ID' => 'Gender', 'MARITALSTATUSTYPE_ID' => 'Marital Status'
            , 'MAIDENNAME_' => 'Maiden Name', 'DATEOFBIRTH_' => 'Date Of Birth', 'PRIMARYPHONENO_' => 'Phone No. (Mobile)'
            , 'WORKPHONENUMBER_' => 'Phone No. (Other)', 'PRIMARYEMAILADDRESS_' => 'Email Address', 'ADDRESSLINE1_' => 'Address Line 1'
            , 'ADDRESSLINE2_' => 'Address Line 2', 'ADDRESSCITY_' => 'City', 'ADDRESSCOUNTRY_ID' => 'Country', 'ADDRESSSTATE_ID' => 'State'
            , 'COUNTRY_ID' => 'Nationality', 'KINRELATIONSHIPTYPE_ID' => 'Next Of Kin Type', 'KINFIRSTNAME_' => 'Kin First Name'
            , 'KINLASTNAME_' => 'Kin Last Name', 'KINOTHERNAMES_' => 'Kin Other Names', 'KINCONTACTPHONENUMBER_' => 'Kin Contact Phone No.'
            , 'KINADDRESS_' => 'Kin Address', 'FULLNAME_' => 'Full Name');
//Array to hold column titles
$classNm = array('PARTYROLE_ID' => '', 'PARTY_ID' => '', 'PARTYTITLE_ID' => '', 'CUSTOMERID_' => '', 'LEGACYSTCUSTOMERID_' => 'combobox'
    , 'LEGACYIMCUSTOMERID_' => 'combobox'
    , 'LEGACYSTACCOUNTNUMBER_' => 'combobox', 'LEGACYMMACCOUNTNUMBER_' => 'combobox', 'LEGACYTBILLSACCOUNTNUMBER_' => 'combobox'
    , 'TOTALASSETVALUE_' => '', 'ERPST_ACC_NOS' => '', 'TYPE_ID' => '', 'FIRSTNAME_' => 'combobox', 'MIDDLENAME_' => 'combobox'
    , 'LASTNAME_' => 'combobox', 'INITIALS_' => '', 'GENDER_ID' => '', 'MARITALSTATUSTYPE_ID' => '', 'MAIDENNAME_' => 'combobox'
    , 'DATEOFBIRTH_' => 'combobox date', 'PRIMARYPHONENO_' => 'combobox phone', 'WORKPHONENUMBER_' => 'combobox phone'
    , 'PRIMARYEMAILADDRESS_' => 'combobox', 'ADDRESSLINE1_' => 'combobox', 'ADDRESSLINE2_' => 'combobox', 'ADDRESSCITY_' => 'combobox'
    , 'ADDRESSSTATE_ID' => '', 'ADDRESSCOUNTRY_ID' => '', 'COUNTRY_ID' => '', 'KINRELATIONSHIPTYPE_ID' => '', 'KINFIRSTNAME_' => 'combobox'
    , 'KINLASTNAME_' => 'combobox', 'KINOTHERNAMES_' => 'combobox', 'KINCONTACTPHONENUMBER_' => 'combobox phone', 'KINADDRESS_' => 'combobox'
    , 'FULLNAME_' => 'combobox');
$hiddenFields = array('PARTYROLE_ID', 'TYPE_ID', 'INITIALS_', 'FULLNAME_', 'PARTY_ID');
$planeTxt = array('CUSTOMERID_', 'TOTALASSETVALUE_', 'ERPST_ACC_NOS');
//For customer type individual, restructure the arrays
if (@$_POST['cust_type'] == '4') {
    $tblTitle = array('PARTYROLE_ID' => 'Party Role ID.', 'PARTY_ID' => 'Party ID.', 'PARTYTITLE_ID' => 'Title', 'CUSTOMERID_' => 'ERP Customer ID'
        , 'LEGACYSTCUSTOMERID_' => 'iBroker ST Customer ID', 'LEGACYIMCUSTOMERID_' => 'iBroker IM Customer ID', 'ERPST_ACC_NOS' => 'ST Account No.'
        , 'LEGACYSTACCOUNTNUMBER_' => 'iBroker ST Account #', 'LEGACYMMACCOUNTNUMBER_' => 'iBroker MM Account #', 'LEGACYTBILLSACCOUNTNUMBER_' => 'iBroker TBills Account #'
        , 'TOTALASSETVALUE_' => 'Total Asset Value (NGN)', 'TYPE_ID' => 'Type ID.', 'FULLNAME_' => 'Name', 'PRIMARYPHONENO_' => 'Contact Phone Number'
        , 'WORKPHONENUMBER_' => 'Phone No. (Other)', 'PRIMARYEMAILADDRESS_' => 'Email Address', 'ADDRESSLINE1_' => 'Address Line 1'
        , 'ADDRESSLINE2_' => 'Address Line 2', 'ADDRESSCITY_' => 'City', 'ADDRESSCOUNTRY_ID' => 'Country', 'ADDRESSSTATE_ID' => 'State');
    if (($key = array_search('FULLNAME_', $hiddenFields)) !== false) {
        unset($hiddenFields[$key]);
    }
}
//This is where where display the Autocomplete search.
if (isset($_POST['search_term'])) {
    $msc=microtime(true);
    $results = $cust->_doCustSearch($_POST['search_term'], NULL);
    $count = count($results);
    $msc=microtime(true)-$msc;
    if ($count) {
        $custs = $count > 30 ? '<div style="color:#999;">About ' : '';
        $custs .= $count . ' results (' . round($msc, 3) . ' seconds)</div>';
        $custs .= '<form method="post" action="" style="width:70%;"><table class="my_tables display clickable">';
        $custs .= '<thead><tr><th></th><th>Customer Name</th><th>Customer ID</th><th>Customer Type</th><th>Total Portfolio Value (NGN)</th></tr></thead>';
        $custs .= '<input type="hidden" name="clean_cust" value="1" />';
        $custs .= '<tbody>';
        foreach ($results as $customer) {
            $custs .= '<tr>
                            <td><input type="checkbox" name="cust_id[]" value="' . $customer["PARTYROLE_ID"] . '" data-role-type="' . $customer["TYPE_ID"] . '" /></td>
                            <td>' . $customer["FULLNAME_"] . '</td>
                            <td>' . $customer["CUSTOMERID_"] . '</td>
                            <td>' . $customer["custTpNm"] . '</td>
                            <td style="text-align:right;">' . $fxns->_formatMoney($customer["TOTALASSETVALUE_"], true) . '</td>
                    </tr>';
        }
        $custs .= '</tbody></table><a href="" class="button clean_cust" style="float:right;margin-top:.5%;" >Merge Customers</a></form>';
    } else {
        $custs = '<div style="font-size:1.2em;">';
        $custs .= 'Your search - <strong>' . $_POST['search_term'] . '</strong> - did not match any customer.<br /><br />';
        $custs .= 'Suggestions:';
        $custs .= '<ul>
						<li>Make sure that all words are spelled correctly.</li>
						<li>Try different keywords.</li>
						<li>Try more general keywords.</li>
						<li>Try fewer keywords.</li>
					</ul></div>';
    }
    echo $custs;
}
//This builds the tables columns for the selected customers
if (isset($_POST['clean_cust'])) {
    if (!@$_POST['cust_id'])
        echo "You have not selected any action to perform.<br />Please select an action and try again";
    else {
        //var_dump( $_POST['cust_id'] );
        //exit();
        $selected = implode('\',\'', $_POST['cust_id']);
        $selected = "'" . $selected . "'";
        $selectedCustomers = $cust->_getCusts($selected);
        //var_dump($selectedCustomers);exit;
        array_unshift($selectedCustomers, $tblTitle);
        $table = '<form method="post" action="">';
        $table .= '<table  class="my_tables vertColNm"><tr><td></td>';
        for ($i = 1; $i < count($selectedCustomers); $i++) {
            if (!isset($_POST['plain'])) {
                $table .= '<td><input type="radio" name="checkID" value="' . $selectedCustomers[$i]['PARTYROLE_ID'] . '" /></td>';
                $table .= '<input type="hidden" name="checkIDs[]" value="' . $selectedCustomers[$i]['PARTYROLE_ID'] . '" />';
            }
        }
        $table .= "</tr>";
        foreach ($selectedCustomers[0] as $key => $values) {
            $table .= "<tr>";
            $sql_getCombo = "SELECT ";
            if ($key == 'DATEOFBIRTH_') {
                $sql_getCombo .= " DATE_FORMAT(DATEOFBIRTH_, '%b-%d-%Y') AS DATEOFBIRTH_ ";
            } elseif (strpos($key, 'PHONE') !== false) {
                $sql_getCombo .= " SUBSTRING_INDEX({$key}, '-', -1) {$key} ";
            } else {
                $sql_getCombo .= " {$key} ";
            }
            $sql_getCombo .= " FROM MIGRATION_ WHERE PARTYROLE_ID IN ({$selected})";
            for ($i = 0; $i < count($selectedCustomers); $i++) {
                if (in_array($key, $hiddenFields)) {
                    $table .=!empty($_POST['plain']) ? '' : '<td><input type="hidden" name="' . $key . '" value="' . $selectedCustomers[$i][$key] . '" /></td>';
                } else {
                    if ($i == 0) {
                        $table .= '<td>' . $selectedCustomers[$i][$key] . '</td>';
                    } else {
                        if (isset($_POST['plain'])) {
                            if ($key == 'PARTYTITLE_ID') {
                                $sql = "SELECT DESCRIPTION_ FROM PARTYTITLE_ WHERE PARTYTITLE_ID = '{$selectedCustomers[$i][$key]}'";
                                $table .= "<td>" . $fxns->_getLOVDsc($sql, 'DESCRIPTION_') . '</td>';
                            } elseif ($key == 'GENDER_ID') {
                                $sql = "SELECT DESCRIPTION_ FROM GENDER_ WHERE GENDER_ID = '{$selectedCustomers[$i][$key]}'";
                                $table .= "<td>" . $fxns->_getLOVDsc($sql, 'DESCRIPTION_') . '</td>';
                            } elseif ($key == 'MARITALSTATUSTYPE_ID') {
                                $sql = "SELECT DESCRIPTION_ FROM MARITALSTATUSTYPE_ WHERE MARITALSTATUSTYPE_ID = '{$selectedCustomers[$i][$key]}'";
                                $table .= "<td>" . $fxns->_getLOVDsc($sql, 'DESCRIPTION_') . '</td>';
                            } elseif ($key == 'TOTALASSETVALUE_') {
                                $table .= '<td>' . $fxns->_formatMoney($selectedCustomers[$i][$key], true) . '</td>';
                            } elseif ($key == 'ADDRESSCOUNTRY_ID') {
                                $sql = "SELECT NAME_ FROM GEOGRAPHICBOUNDARY_ WHERE TYPE_ID = (SELECT GEOGRAPHICBOUNDARYTYPE_ID FROM GEOGRAPHICBOUNDARYTYPE_ WHERE NAME_ = 'Country') AND GEOGRAPHICBOUNDARY_ID = '{$selectedCustomers[$i][$key]}'";
                                $table .= "<td>" . $fxns->_getLOVDsc($sql, 'NAME_') . '</td>';
                            } elseif ($key == 'ADDRESSSTATE_ID') {
                                $sql = "SELECT NAME_ FROM GEOGRAPHICBOUNDARY_ WHERE TYPE_ID = (SELECT GEOGRAPHICBOUNDARYTYPE_ID FROM GEOGRAPHICBOUNDARYTYPE_ WHERE NAME_ = 'State') AND GEOGRAPHICBOUNDARY_ID = '{$selectedCustomers[$i][$key]}'";
                                $table .= "<td>" . (empty($selectedCustomers[$i][$key]) ? '' : $fxns->_getLOVDsc($sql, 'NAME_')) . '</td>';
                            } elseif ($key == 'COUNTRY_ID') {
                                $sql = "SELECT NATIONALITY_ FROM GEOGRAPHICBOUNDARY_ WHERE TYPE_ID = (SELECT GEOGRAPHICBOUNDARYTYPE_ID FROM GEOGRAPHICBOUNDARYTYPE_ WHERE NAME_ = 'Country') AND GEOGRAPHICBOUNDARY_ID = '{$selectedCustomers[$i][$key]}'";
                                $table .= "<td>" . $fxns->_getLOVDsc($sql, 'NATIONALITY_') . '</td>';
                            } elseif ($key == 'KINRELATIONSHIPTYPE_ID') {
                                $sql_kin = "SELECT NAME_ FROM FAMILYRELATIONSHIPTYPE_ WHERE FAMILYRELATIONSHIPTYPE_ID = '{$selectedCustomers[$i][$key]}'";
                                $ans = (empty($selectedCustomers[$i][$key])) ? '' : $fxns->_getLOVDsc($sql_kin, 'NAME_');
                                $table .= '<td>' . $ans . '</td>';
                            } else {
                                $table .= '<td>' . $selectedCustomers[$i][$key] . '</td>';
                            }
                        } else {
                            if ($key == 'PARTYTITLE_ID') {
                                $sql_getTitle = "SELECT PARTYTITLE_ID, DESCRIPTION_ FROM PARTYTITLE_";
                                $table .= "<td>" . $fxns->_getLOVs($sql_getTitle, $key, "DESCRIPTION_", $key, $classNm[$key], "--Select Title--", $selectedCustomers[$i][$key]) . "</td>";
                            } elseif ($key == 'GENDER_ID') {
                                $sql_getGender = "SELECT GENDER_ID, DESCRIPTION_ FROM GENDER_";
                                $table .= "<td>" . $fxns->_getLOVs($sql_getGender, $key, "DESCRIPTION_", $key, $classNm[$key], "--Select Gender--", $selectedCustomers[$i][$key]) . "</td>";
                            } elseif ($key == 'MARITALSTATUSTYPE_ID') {
                                $sql_getMaritalStat = "SELECT MARITALSTATUSTYPE_ID, DESCRIPTION_ FROM MARITALSTATUSTYPE_";
                                $table .= "<td>" . $fxns->_getLOVs($sql_getMaritalStat, $key, "DESCRIPTION_", $key, $classNm[$key], "--Select Marital Status--", $selectedCustomers[$i][$key]) . "</td>";
                            } elseif ($key == 'ADDRESSCOUNTRY_ID') {
                                $sql_getCountry = "SELECT GEOGRAPHICBOUNDARY_ID, NAME_ FROM GEOGRAPHICBOUNDARY_
	WHERE TYPE_ID = (SELECT GEOGRAPHICBOUNDARYTYPE_ID FROM GEOGRAPHICBOUNDARYTYPE_ WHERE NAME_ = 'Country') ORDER BY NAME_";
                                $table .= "<td>" . $fxns->_getLOVs($sql_getCountry, "GEOGRAPHICBOUNDARY_ID", "NAME_", $key, $classNm[$key], "--Select Country--", $selectedCustomers[$i][$key]) . "</td>";
                            } elseif ($key == 'ADDRESSSTATE_ID') {
                                $chosenState = isset($selectedCustomers[$i][$key]) ? $selectedCustomers[$i][$key] : '0';
                                $sql_getStates = "SELECT GEOGRAPHICBOUNDARY_ID, NAME_ FROM GEOGRAPHICBOUNDARY_
	WHERE TYPE_ID = (SELECT GEOGRAPHICBOUNDARYTYPE_ID FROM GEOGRAPHICBOUNDARYTYPE_ WHERE NAME_ = 'State') AND COUNTRY_STATES_ID =" . $selectedCustomers[$i]['ADDRESSCOUNTRY_ID'];
                                $table .= "<td>" . $fxns->_getLOVs($sql_getStates, "GEOGRAPHICBOUNDARY_ID", "NAME_", $key, $classNm[$key], "--Select State--", $selectedCustomers[$i][$key]) . "</td>";
                            } elseif ($key == 'COUNTRY_ID') {
                                $sql_getNationality = "SELECT GEOGRAPHICBOUNDARY_ID, NATIONALITY_ FROM GEOGRAPHICBOUNDARY_
	WHERE TYPE_ID = (SELECT GEOGRAPHICBOUNDARYTYPE_ID FROM GEOGRAPHICBOUNDARYTYPE_ WHERE NAME_ = 'Country') ORDER BY NATIONALITY_";
                                $table .= "<td>" . $fxns->_getLOVs($sql_getNationality, "GEOGRAPHICBOUNDARY_ID", "NATIONALITY_", $key, $classNm[$key], "--Select Nationality--", $selectedCustomers[$i][$key]) . "</td>";
                            } elseif ($key == 'KINRELATIONSHIPTYPE_ID') {
                                $sql_getKinType = "SELECT FAMILYRELATIONSHIPTYPE_ID, NAME_ FROM FAMILYRELATIONSHIPTYPE_";
                                $table .= "<td>" . $fxns->_getLOVs($sql_getKinType, "FAMILYRELATIONSHIPTYPE_ID", "NAME_", $key, $classNm[$key], "--Select Relationship--", $selectedCustomers[$i][$key]) . "</td>";
                            } elseif (strpos($key, 'PHONE') !== false) {
                                $phone = explode("-", $selectedCustomers[$i][$key]);
                                $sql_callingCode = "SELECT DISTINCT CONCAT('+',COUNTRYCALLINGCODE_) CODE, CONCAT(NAME_,' +',COUNTRYCALLINGCODE_) NAMES_ FROM GEOGRAPHICBOUNDARY_
	WHERE TYPE_ID = (SELECT GEOGRAPHICBOUNDARYTYPE_ID FROM GEOGRAPHICBOUNDARYTYPE_ WHERE NAME_ = 'Country') ORDER BY NAME_";
                                $table .= "<td>"
                                        . $fxns->_getLOVs($sql_callingCode, "CODE", "NAMES_", $key . 'CODE', "", "--Select Calling Code--", $phone[0])
                                        . "-"
                                        . $fxns->_getLOVs($sql_getCombo, $key, $key, $key, $classNm[$key], NULL, @$phone[1])
                                        . "</td>";
                            } elseif (in_array($key, $planeTxt)) {
                                if ($key == 'TOTALASSETVALUE_')
                                    $table .= '<td><div style="width:200px; text-align:right;">' . $fxns->_formatMoney($selectedCustomers[$i][$key], true) . '</div></td>';
                                else
                                    $table .= "<td>" . $selectedCustomers[$i][$key] . '<input type="hidden" name="' . $key . '" value="' . $selectedCustomers[$i][$key] . '" /></td>';
                            }else {
                                $table .= "<td>" . $fxns->_getLOVs($sql_getCombo, $key, $key, $key, $classNm[$key], NULL, $selectedCustomers[$i][$key]) . "</td>";
                            }
                        }
                    }
                }
            }
            $table .= "</tr>";
        }
        $table .= '</table>';
        $table .= isset($_POST['plain']) ? '' : '<a href="" class="button preview" style="float:right;margin-top:-10px;color:#FFF;" >Preview >></a>';
        $table .= '</form>';
        echo $table;
    }
}
if (isset($_POST['checkID'])) {
    if (isset($_POST['rejectRsn'])) {
        unset($_POST['rejectRsn']);
    }
    if (isset($_POST['sn'])) {
        unset($_POST['sn']);
    }
    //var_dump($_POST);exit;
    $result = array($_POST);
    array_unshift($result, $tblTitle);
    $table = '<form method="post" action=""><table  class="my_tables vertColNm">';
    $table .= "<tr><td></td>";
    foreach ($result[1] as $key => $values) {
        $table .= "<tr>";
        for ($i = 0; $i < count($result); $i++) {
            if (in_array($key, $hiddenFields)) {
                if ($i == 0) {
                    $table .= ($key == 'FULLNAME_') ? '<td>Full Name</td>' : '<td></td>';
                } elseif ($result[$i]['cust_type'] == '5') { // If customer is individual customer
                    $fullNm = ucwords(strtolower($result[$i]['LASTNAME_']))
                            . ' ' . ucwords(strtolower($result[$i]['FIRSTNAME_']))
                            . ' ' . ucwords(strtolower($result[$i]['MIDDLENAME_']));
                    $table .= ($key == 'FULLNAME_') ? '<td>' . $fullNm . '<input type="hidden" name="' . $key . '" value="' . $fullNm . '" /></td>' : '<td><input type="hidden" name="' . $key . '" value="' . $result[$i][$key] . '" /></td>';
                } elseif ($result[$i]['cust_type'] == '4') { // If customer is individual customer
                    $table .= '<td><input type="hidden" name="' . $key . '" value="' . $result[$i][$key] . '" /></td>';
                }
            } else {
                if ($i == 0 && $key != 'checkIDs' && $key != 'checkID' && $key != 'cust_type') {
                    $table .= (strpos($key, '_CODE') !== false) ? '' : '<td>' . $result[$i][$key] . '</td>';
                } else {
                    if ($key == 'checkIDs') {
                        foreach ($result[1][$key] as $checkIDs) {
                            $table .= '<td><input type="hidden" name="checkIDs[]" value="' . $checkIDs . '" /></td>';
                        }
                    } elseif ($key == 'checkID') {
                        $table .= '';
                    } elseif ($key == 'cust_type') {
                        $table .= '<td><input type="hidden" name="' . $key . '" value="' . @$_POST['cust_type'] . '" /></td>';
                    } elseif (strpos($key, 'PHONE') !== false && strpos($key, '_CODE') === false) {
                        $code = $key . 'CODE';
                        $phone = (!empty($result[$i][$code]) && !empty($result[$i][$key])) ? $result[$i][$code] . '-' . $result[$i][$key] : "";
                        $table .= "<td>" . $phone . '<input type="hidden" name="' . $key . '" value="' . $phone . '" /></td>';
                    } elseif (strpos($key, '_CODE') !== false) {
                        $table .= "";
                    } elseif ($key == 'PARTYTITLE_ID') {
                        $sql = "SELECT DESCRIPTION_ FROM PARTYTITLE_ WHERE PARTYTITLE_ID = '{$result[$i][$key]}'";
                        $table .= "<td>" . $fxns->_getLOVDsc($sql, 'DESCRIPTION_') . '<input type="hidden" name="' . $key . '" value="' . $result[$i][$key] . '" /></td>';
                    } elseif ($key == 'GENDER_ID') {
                        $sql = "SELECT DESCRIPTION_ FROM GENDER_ WHERE GENDER_ID = '{$result[$i][$key]}'";
                        $table .= "<td>" . $fxns->_getLOVDsc($sql, 'DESCRIPTION_') . '<input type="hidden" name="' . $key . '" value="' . $result[$i][$key] . '" /></td>';
                    } elseif ($key == 'MARITALSTATUSTYPE_ID') {
                        $sql = "SELECT DESCRIPTION_ FROM MARITALSTATUSTYPE_ WHERE MARITALSTATUSTYPE_ID = '{$result[$i][$key]}'";
                        $table .= "<td>" . $fxns->_getLOVDsc($sql, 'DESCRIPTION_') . '<input type="hidden" name="' . $key . '" value="' . $result[$i][$key] . '" /></td>';
                    } elseif ($key == 'ADDRESSCOUNTRY_ID') {
                        $sql = "SELECT NAME_ FROM GEOGRAPHICBOUNDARY_ WHERE TYPE_ID = (SELECT GEOGRAPHICBOUNDARYTYPE_ID FROM GEOGRAPHICBOUNDARYTYPE_ WHERE NAME_ = 'Country') AND GEOGRAPHICBOUNDARY_ID = '{$result[$i][$key]}'";
                        $table .= "<td>" . $fxns->_getLOVDsc($sql, 'NAME_') . '<input type="hidden" name="' . $key . '" value="' . $result[$i][$key] . '" /></td>';
                    } elseif ($key == 'ADDRESSSTATE_ID') {
                        $sql = "SELECT NAME_ FROM GEOGRAPHICBOUNDARY_ WHERE TYPE_ID = (SELECT GEOGRAPHICBOUNDARYTYPE_ID FROM GEOGRAPHICBOUNDARYTYPE_ WHERE NAME_ = 'State') AND GEOGRAPHICBOUNDARY_ID = '{$result[$i][$key]}'";
                        $table .= "<td>" . (empty($result[$i][$key]) ? '' : $fxns->_getLOVDsc($sql, 'NAME_')) . '<input type="hidden" name="' . $key . '" value="' . $result[$i][$key] . '" /></td>';
                    } elseif ($key == 'COUNTRY_ID') {
                        $sql = "SELECT NATIONALITY_ FROM GEOGRAPHICBOUNDARY_ WHERE TYPE_ID = (SELECT GEOGRAPHICBOUNDARYTYPE_ID FROM GEOGRAPHICBOUNDARYTYPE_ WHERE NAME_ = 'Country') AND GEOGRAPHICBOUNDARY_ID = '{$result[$i][$key]}'";
                        $table .= "<td>" . $fxns->_getLOVDsc($sql, 'NATIONALITY_') . '<input type="hidden" name="' . $key . '" value="' . $result[$i][$key] . '" /></td>';
                    } elseif ($key == 'KINRELATIONSHIPTYPE_ID') {
                        $sql = "SELECT NAME_ FROM FAMILYRELATIONSHIPTYPE_ WHERE FAMILYRELATIONSHIPTYPE_ID = '{$result[$i][$key]}'";
                        $table .= "<td>" . (empty($result[$i][$key]) ? '' : $fxns->_getLOVDsc($sql, 'NAME_')) . '<input type="hidden" name="' . $key . '" value="' . $result[$i][$key] . '" /></td>';
                    } else {
                        $table .= '<td>' . $result[$i][$key] . '<input type="hidden" name="' . $key . '" value="' . $result[$i][$key] . '" /></td>';
                    }
                }
            }
        }
        $table .= "</tr>";
    }
    $table .= '</table><input type="hidden" name="mergeNow" value="1"/><a href="" class="button merge" style="float:right;color:#FFF;" >Clean Customers</a></form>';
    echo $table;
}
if (isset($_POST['mergeNow'])) {
    
    if (!isset($_SESSION['user'])) {
        echo '<div style="font-size:1.5em; color:#600; margin-top:2em;">You have arrived here illegally and cannot perform this action.</div>';
        exit();
    }
    $toBMergedArr = array_unique($_POST['checkIDs']);
    if (in_array($_POST['PARTYROLE_ID'], $toBMergedArr)) {
        unset($toBMergedArr[array_search($_POST['PARTYROLE_ID'], $toBMergedArr)]);
    }
    $toBMergedVals = implode(',', $toBMergedArr);

    ##########	Check if record already exists
    $sql_recExist = "SELECT COUNT(*) count FROM MIGRATIONSTATUS_ 
		WHERE PARTYROLE_ID = {$_POST['PARTYROLE_ID']} AND DUPLICATE_IDS='{$toBMergedVals}'";
    $sql_recExist = $fxns->_execQuery($sql_recExist, true, false);
    $sql_submitApprove = NULL;
    if ($sql_recExist['count'] > 0) {
        $sql_submitApprove .= "UPDATE MIGRATIONSTATUS_ SET ";
        foreach ($_POST as $key => $value) {
            if ($key != 'checkIDs' && $key != 'mergeNow' && $key != 'cust_type') {
                $sql_submitApprove .= ($key == 'DATEOFBIRTH_') ? " $key=" . (empty($value) ? "NULL," : "'" . date("Y-m-d H:i:s", strtotime($value)) . "',") : (($key == 'ERPST_ACC_NOS') ? "ERPST_ACC_NOS='$value', " : " $key = '$value', ");
            }
        }
        $sql_submitApprove .= "STATUS_=0 WHERE PARTYROLE_ID = {$_POST['PARTYROLE_ID']}";
    } else {
        $sql_submitApprove .= "INSERT INTO MIGRATIONSTATUS_ ";
        $cols = "(";
        $vals = "(";
        foreach ($_POST as $key => $value) {
            if ($key != 'checkIDs' && $key != 'mergeNow' && $key != 'cust_type') {
                $cols .= ($key == 'ERPST_ACC_NOS') ? "ERPST_ACC_NOS, " : $key . ", ";
                $vals .= ($key == 'DATEOFBIRTH_') ? (empty($value) ? "NULL," : "'" . date("Y-m-d H:i:s", strtotime($value)) . "',") : "'$value', ";
            }
        }
        $cols .= "STATUS_, DUPLICATE_IDS, LASTUPDATEBY_, SUBMITDATE_ )";
        $vals .= "0, '{$toBMergedVals}', '{$_SESSION['user']}', NOW() )";
        $sql_submitApprove .= $cols . " VALUES " . $vals;
    }

    $insertAppr = $fxns->_execQuery($sql_submitApprove, false, false);
    $message = NULL;
    if (is_array($insertAppr)) {
        $message .= $insertAppr['msg'];
    } else {
        $message .= "Customer(s) update submitted for approval ";
    }
    echo "<div style=\"position:absolute;width:192px;margin:5% 10%;text-align:center;\">" . $message . "</div>";
}
if(isset($_POST['migrateService'])){
    $_POST['extras'] = unserialize(base64_decode($_POST['extras']));
    $_POST['extras']['currentpage'] = @$_POST['currentpage'];
    foreach($_POST['extras'] as $key => $val){
        $_POST[$key] = $val; unset($_POST['extras'][$key]);
    }
    $tot_autrole = count($_SESSION['user_dets']['authrole']);
    $rand_autrole = rand(0, $tot_autrole-1);
    $idRef = ($_POST['type']=='cust')?'1':'2';
    $xml_migrate = '<?xml version="1.0" encoding="UTF-8"?>
                    <TRANSACTION currentLocale="' . $_SESSION['user_dets']['locale'][0] . '" currentRole="' . $_SESSION['user_dets']['authrole'][$rand_autrole] . '">';
    $headers = unserialize (WEBSERVICE_AUTH);
    if($idRef == '2'){
        foreach ($_POST['acc_tp'] as $key => $value){
            $accProd = ($value=='ST Account')? '655949824':'655949832';
            @$sql_getAccId .= "SELECT ACCOUNT_ID FROM ACCOUNT_ WHERE CUSTOMER_PORTFOLIO_ID='".$_POST['cust_id'][$key]."' AND PRODUCT_ID='".$accProd."' UNION ALL ";
        }
        $sql_getAccId = substr($sql_getAccId, 0, strrpos($sql_getAccId, "UNION ALL"));
        $getAccId = $fxns->_execQuery($sql_getAccId, TRUE, TRUE);
        foreach ($getAccId as $key => $value){
            foreach ($value as $value2){
                $accId[] = $value2;
            }
        }
        $accId = array_unique($accId);
        foreach ($accId as $key => $value) {
            $xml_migrate .= '<UPDATE entity="OnlineMigration" id="new:-1155484576" parentProperty="">
                                <PROPERTY bidirectional="false" composite="false" path="status" type="OnlineMigrationStatus">
                                    <ENTITY idref="2" />
                                </PROPERTY>
                                <PROPERTY bidirectional="false" composite="false" path="type" type="OnlineMigrationType">
                                    <ENTITY idref="'.$idRef.'" />
                                </PROPERTY>
                                <PROPERTY path="entryDate" type="Date" value="' . date('m/d/Y') . '" />
                                <PROPERTY path="migrationSourceId" type="String" value="'.$value.'" />
                                <PROPERTY path="locale" type="String" value="' . $_SESSION['user_dets']['locale'][0] . '" />
                            </UPDATE>';            
        }
    }else{
        foreach ($_POST['cust_id'] as $key => $value) {
            $xml_migrate .= '<UPDATE entity="OnlineMigration" id="new:-1155484576" parentProperty="">
                                <PROPERTY bidirectional="false" composite="false" path="status" type="OnlineMigrationStatus">
                                    <ENTITY idref="2" />
                                </PROPERTY>
                                <PROPERTY bidirectional="false" composite="false" path="type" type="OnlineMigrationType">
                                    <ENTITY idref="'.$idRef.'" />
                                </PROPERTY>
                                <PROPERTY path="entryDate" type="Date" value="' . date('m/d/Y') . '" />
                                <PROPERTY path="migrationSourceId" type="String" value="'.$value.'" />
                                <PROPERTY path="locale" type="String" value="' . $_SESSION['user_dets']['locale'][0] . '" />
                            </UPDATE>';            
        }
    }
    $xml_migrate .= '
                        <ENTITYSPEC name="OnlineMigration">
                            <PROPERTY path="id" />
                        </ENTITYSPEC>
                    </TRANSACTION>';

    $output = $fxns->_consumeService(WEB_SERVICE_URL, $xml_migrate, $headers);
    $query_response = simplexml_load_string($output);

    $errors = NULL; $success = NULL;
    if (@$query_response->RESULTS) {
        $result = $query_response->xpath('//ERRORS');
         
        if(is_array($result) && !empty($result)){
            $errors += 1;
        }elseif(is_array($result) && empty($result)){
            $sql_migratd = "UPDATE MIGRATION_ SET ";
            if($idRef == '2'){
                foreach ($_POST['acc_tp'] as $key => $value){
                    $accUpd = ($value=='ST Account')? 'STACCOUNTMIGRATIONSTATUS_=2':'MMACCOUNTMIGRATIONSTATUS_=2,TBILLSACCOUNTMIGRATIONSTATUS_=2';
                    $sql_migratd .= $accUpd." WHERE PARTYROLE_ID='".$_POST['cust_id'][$key]."' UNION ALL ";
                }
                $sql_migratd = substr($sql_migratd, 0, strrpos($sql_migratd, "UNION ALL"));
            }else{
                $cust_ids = "'".implode("','", $_POST['cust_id'])."'";
                $sql_migratd .= "CUSTOMERMIGRATIONSTATUS_=2 WHERE PARTYROLE_ID IN ({$cust_ids})";
            }
            $ans = $fxns->_execQuery($sql_migratd, FALSE);
            $success += 1;
        }
        if($errors > 0){
            echo "Unable to complete the migration";
        }elseif($success > 0){
            echo "Migration completed successfully";
        }
    }elseif (@$query_response->ERRORS) {
        echo $query_response->ERRORS->ERROR['message'];
    } else { // Didnt get a response
        echo "Server may be unavailable";
    }
}
?>