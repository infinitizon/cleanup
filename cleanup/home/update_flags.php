<?php

ini_set('max_execution_time', 2000);
/*
 * Include necessary files
 */
include_once 'core/init.inc.php';
$cust = new Customer($dbo);
$fxns = new Functions($dbo);
$getAllCust = "SELECT m.PARTYROLE_ID, m.CUSTOMERID_, m.TYPE_ID, m.PARTY_ID, m.PARTYTITLE_ID
	, LEGACYSTACCOUNTNUMBER_, LEGACYCUSTOMERID_, LEGACYMMACCOUNTNUMBER_, LEGACYTBILLSACCOUNTNUMBER_
	, (SELECT GROUP_CONCAT(ACCOUNTNUMBER_) FROM ACCOUNT_
		WHERE PRODUCT_ID = '655949824' AND CUSTOMER_PORTFOLIO_ID = m.PARTYROLE_ID) ST_ACC_NOS
	, m.FIRSTNAME_, m.MIDDLENAME_, m.LASTNAME_, m.INITIALS_, m.GENDER_ID, m.MARITALSTATUSTYPE_ID
	, m.MAIDENNAME_, DATEOFBIRTH_, m.PRIMARYEMAILADDRESS_
	, m.COUNTRY_ID, m.PRIMARYPHONENO_, m.WORKPHONENUMBER_, m.KINRELATIONSHIPTYPE_ID, m.KINFIRSTNAME_, m.KINLASTNAME_
	, m.KINOTHERNAMES_, m.KINCONTACTPHONENUMBER_, m.KINADDRESS_, m.ADDRESSLINE1_, m.ADDRESSLINE2_, m.ADDRESSCITY_
	, m.ADDRESSSTATE_ID, m.ADDRESSCOUNTRY_ID, m.FULLNAME_, m.TOTALASSETVALUE_ 
FROM MIGRATION_ m 
WHERE ISDUPLICATE_ = 0
";

$updtAdrWtCHD = "UPDATE MIGRATION_ SET ISADDRESSVALID_ = 0, VERSION_=VERSION_+1, LASTUPDATEBY_='SYSTEM-B-SetCHDMAddy2False'
                WHERE (ADDRESSLINE1_ LIKE '%SAKA TINUBU%' OR ADDRESSLINE2_ LIKE '%SAKA TINUBU%') 
                    AND (LOWER(FULLNAME_) NOT LIKE '%chapel hill%') 
                    AND (LOWER(FULLNAME_) NOT LIKE '%denham%') 
                    AND (LOWER(FULLNAME_) NOT LIKE '%chdm%')";
$updtAdrWtCHD = $fxns->_execQuery($updtAdrWtCHD, false);
//echo $updtAdrWtCHD; exit;
/****
 * SELECT CONCAT('"',PRIMARYPHONENO_), PARTYROLE_ID, PARTY_ID, CUSTOMERID_, CONCAT('"',WORKPHONENUMBER_), PRIMARYEMAILADDRESS_, ERPIMACCOUNTNUMBER_
	, LEGACYSTACCOUNTNUMBER_, LEGACYMMACCOUNTNUMBER_, LEGACYTBILLSACCOUNTNUMBER_, LEGACYCUSTOMERID_
	, FULLNAME_, FIRSTNAME_, MIDDLENAME_, LASTNAME_, MAIDENNAME_, DATEOFBIRTH_
	, ADDRESSLINE1_, ADDRESSLINE2_, ADDRESSCITY_
FROM MIGRATION_
WHERE PRIMARYPHONENO_ IN (SELECT *
                        FROM (SELECT PRIMARYPHONENO_
                              FROM MIGRATION_
                              GROUP BY PRIMARYPHONENO_
                              HAVING COUNT(PRIMARYPHONENO_) > 1)
                        AS a)
ORDER BY PRIMARYPHONENO_;
 */
$getAllCust = $dbo->query($getAllCust);
while ($currentCust = $getAllCust->fetch(PDO::FETCH_ASSOC)) {
    extract($currentCust);
    /* 1.   Check if Name is valid *********** */
    if ($TYPE_ID == 5 && (strlen($FIRSTNAME_) >= 3 && strlen($LASTNAME_) >= 3)) {
        $cleanNm = " ISNAMEVALID_ = 1, ";
    } elseif ($TYPE_ID == 4 && !empty ($FULLNAME_)) {
        $cleanNm = " ISNAMEVALID_ = 1, ";
    } else {
        $cleanNm = " ISNAMEVALID_ = 0, ";
    }
    /* 2.   Check if Email is valid *********** */
    if (filter_var($PRIMARYEMAILADDRESS_, FILTER_VALIDATE_EMAIL)) {
        $cleanEml = " ISEMAILVALID_ = 1, ";
    } else {
        $cleanEml = " ISEMAILVALID_ = 0, ";
    }
    //$cleanEml = isset($cleanEml) ? $cleanEml : '';
    /* 3.   Check if Phone is valid *********** */
    $phnValid = '';
    if (strpos($PRIMARYPHONENO_, '-') !== FALSE) {
        $cleanPhn = $fxns->_multiexplode($PRIMARYPHONENO_, $delimiters = array("-"));
        $cleanPhn = substr($cleanPhn[0], 1);
        if (!empty($cleanPhn)) {
            $sqlcleanPhn = $dbo->query("SELECT COUNT(*) AS count FROM GEOGRAPHICBOUNDARY_ WHERE COUNTRYCALLINGCODE_ = '$cleanPhn'");
            $resultCleanPhn = $sqlcleanPhn->fetch(PDO::FETCH_ASSOC);
            if ($resultCleanPhn['count'] == 1) {
                $phnValid = " ISPHONENOVALID_ = 1, ";
            }
        }
    } else {
        $phnValid = " ISPHONENOVALID_ = 0, ";
    }
    //$phnValid = isset($phnValid) ? $phnValid : '';
    /* 4.   Check if Address is valid *********** */
    if (!empty($ADDRESSLINE1_) && !empty($ADDRESSCITY_) && !empty($ADDRESSSTATE_ID) && !empty($ADDRESSCOUNTRY_ID)) {
        $validAdr = " ISADDRESSVALID_ = 1, ";
    } else {
        $validAdr = " ISADDRESSVALID_ = 0, ";
    }
    //$validAdr = isset($validAdr) ? $validAdr : '';
    /* 5.   Check if customer is mapped *********** */
    if (!empty($LEGACYCUSTOMERID_)) {
        $custMapped = " ISCUSTOMERMAPPED_ = 1, ";
    } else {
        $custMapped = " ISCUSTOMERMAPPED_ = 0, ";
    }
    $custMapped = isset($custMapped) ? $custMapped : '';
    /* 6.   Check if ST Acc is mapped *********** */
    if (!empty($LEGACYSTACCOUNTNUMBER_)) {
        $stAccMapped = " STACCOUNTMIGRATIONSTATUS_ = 1, ";
    } else {
        $stAccMapped = " STACCOUNTMIGRATIONSTATUS_ = 0, ";
    }
    $stAccMapped = isset($stAccMapped) ? $stAccMapped : '';
    /* 7.   Check if MM Acc is mapped *********** */
    if (!empty($LEGACYMMACCOUNTNUMBER_)) {
        $mmAccMapped = " MMACCOUNTMIGRATIONSTATUS_ = 1, ";
    } else {
        $mmAccMapped = " MMACCOUNTMIGRATIONSTATUS_ = 0, ";
    }
    $mmAccMapped = isset($mmAccMapped) ? $mmAccMapped : '';
    /* 7.   Check if MM Acc is mapped *********** */
    if (!empty($LEGACYTBILLSACCOUNTNUMBER_)) {
        $tbillsAccMapped = " TBILLSACCOUNTMIGRATIONSTATUS_ = 1, ";
    } else {
        $tbillsAccMapped = " TBILLSACCOUNTMIGRATIONSTATUS_ = 0, ";
    }
    $tbillsAccMapped = isset($tbillsAccMapped) ? $tbillsAccMapped : '';


    $updCust = "UPDATE MIGRATION_ SET
				 {$cleanNm}{$cleanEml}{$phnValid}{$validAdr}{$custMapped}{$stAccMapped}{$mmAccMapped}{$tbillsAccMapped}";
    $updCust .= " LASTUPDATEBY_='SYSTEM-B-updtFlgs', VERSION_=VERSION_+1 WHERE PARTYROLE_ID = {$PARTYROLE_ID}";
    echo $updCust."<br />";
    $res = $fxns->_execQuery($updCust, false);
    echo var_dump($res)."<br />";
}
//exit;
/* Mark those that as ready for migration as such */
$markReady4Mig = "UPDATE MIGRATION_ SET CUSTOMERMIGRATIONSTATUS_ = 1, LASTUPDATEBY_='SYSTEM-B-CustMigStat'
		WHERE ISNAMEVALID_=1 AND ISEMAILVALID_=1 AND ISPHONENOVALID_=1 AND ISADDRESSVALID_=1 AND ISCUSTOMERMAPPED_=1
		AND ISDUPLICATE_=0 AND CUSTOMERMIGRATIONSTATUS_=0";
//echo $markReady4Mig."<br />";
$fxns->_execQuery($markReady4Mig, false);
?>