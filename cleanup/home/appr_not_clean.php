<?php
header("Pragma: public");
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: text/x-csv");
header("Content-Disposition: attachment;filename=\"ApprovedNotClean.csv\""); 
/*
* Include necessary files
*/
include_once 'core/init.inc.php';
$cust = new Customer($dbo);
$fxns = new Functions($dbo);
//Prepare php for a writeable output.
$output = fopen('php://output', 'w');
$sql_appr_not_clean = "SELECT m.CUSTOMERID_, m.LEGACYCUSTOMERID_, CONCAT('''',m.LEGACYSTACCOUNTNUMBER_)LEGACYSTACCOUNTNUMBER_
        -- , m.TYPE_ID 
        , (CASE m.TYPE_ID WHEN 4 THEN 'Corporate Customer' ELSE 'Individual Customer' END)TYPE_
        , m.FULLNAME_, m.FIRSTNAME_, m.MIDDLENAME_, m.LASTNAME_
        -- , m.GENDER_ID
        , (SELECT g.DESCRIPTION_ FROM GENDER_ g WHERE m.GENDER_ID=g.GENDER_ID)GENDER_
        , CONCAT('''',m.PRIMARYPHONENO_)PRIMARYPHONENO_, CONCAT('''',m.WORKPHONENUMBER_)WORKPHONENUMBER_
        , m.PRIMARYEMAILADDRESS_, m.DATEOFBIRTH_, m.ADDRESSLINE1_
        , m.ADDRESSLINE2_, m.ADDRESSCITY_
        -- , m.ADDRESSSTATE_ID
        , (SELECT NAME_ FROM GEOGRAPHICBOUNDARY_ 
                                WHERE TYPE_ID = (SELECT GEOGRAPHICBOUNDARYTYPE_ID 
                                                FROM GEOGRAPHICBOUNDARYTYPE_ WHERE NAME_ = 'State') 
                                AND GEOGRAPHICBOUNDARY_ID =m.ADDRESSSTATE_ID) STATE_
        -- , m.ADDRESSCOUNTRY_ID
        , (SELECT NAME_ FROM GEOGRAPHICBOUNDARY_ 
                                WHERE TYPE_ID = (SELECT GEOGRAPHICBOUNDARYTYPE_ID 
                                                 FROM GEOGRAPHICBOUNDARYTYPE_ 
                                                 WHERE NAME_ = 'Country') 
                                AND GEOGRAPHICBOUNDARY_ID = m.ADDRESSCOUNTRY_ID) COUNTRY_
        	, (SELECT APPROVEDBY_ 
                    FROM (SELECT PARTYROLE_ID, PARTY_ID, CUSTOMERID_, APPROVEDBY_ FROM MIGRATIONSTATUS_ WHERE STATUS_ =1
                    GROUP BY PARTYROLE_ID)t
                    WHERE m.PARTYROLE_ID=t.PARTYROLE_ID)APPROVEDBY_	
FROM MIGRATION_ m
WHERE m.PARTYROLE_ID IN (SELECT DISTINCT PARTYROLE_ID FROM MIGRATIONSTATUS_ WHERE STATUS_ =1)
AND m.CUSTOMERMIGRATIONSTATUS_ = {$_POST['data']} AND IFNULL(m.ISDUPLICATE_,0) = 0";
//echo  $sql_appr_not_clean ;exit;

$stmt = $dbo->prepare($sql_appr_not_clean);
$stmt->execute(array());
//Get col Titles
for ($i = 0; $i < $stmt->columnCount(); $i++) {
    $col = $stmt->getColumnMeta($i);
    $columns[] = $col['name'];
}
fputcsv($output, $columns);

while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    foreach ($result as $key => $value) {
        $result[$key] = str_replace(',', '\,', $result[$key]);
    }
    fputcsv($output, $result);
}
?>