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

$accMigTitle = array('PARTYROLE_ID' => 'Party Role ID.', 'AccountNo'=>'Account No', 'AccountTp'=>'Account Type'
                    , 'CUSTOMERID_' => 'ERP Customer ID', 'custTpNm' => 'Customer Type', 'FULLNAME_' => 'Customer Name'
                    , 'ACCOUNTSTATUS_' => 'Status');
$custMigTitle = array('PARTYROLE_ID' => 'Party Role ID.', 'CUSTOMERID_' => 'ERP Customer ID', 'custTpNm' => 'Customer Type', 'FULLNAME_' => 'Customer Name', 'CUSTOMERMIGRATIONSTATUS_' => 'Status');
$dataMigTitle = array('PARTYROLE_ID' => 'Party Role ID.', 'CUSTOMERID_' => 'ERP Customer ID', 'custTpNm' => 'Customer Type', 'FULLNAME_' => 'Customer Name', 'dataStatus' => 'Status');

$hiddenFields = array('PARTYROLE_ID', 'PARTY_ID');
$whatToLook = array('Not Migrated' => 0, 'Ready For Migration' => 1, 'Migrated' => 2
                    , 'Not Mapped' => " IS NULL ", 'Mapped' => " LIKE '%mapped%' ", 'Not Correct' => 0, 'Correct' => 1);

if (isset($_POST['getDateRange'])) {
    $sqlClnProg = "SELECT (SELECT COUNT(*) FROM MIGRATIONSTATUS_ m WHERE SUBMITDATE_ BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}')TotSubReq
        , (SELECT COUNT(*) FROM MIGRATIONSTATUS_ m WHERE m.STATUS_ = 0 AND SUBMITDATE_ BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}')TotPendReq
	, (SELECT COUNT(*) FROM MIGRATIONSTATUS_ m WHERE m.STATUS_ = 1 AND SUBMITDATE_ BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}')TotApprReq
	, (SELECT COUNT(*) FROM MIGRATIONSTATUS_ m WHERE m.STATUS_ = 2 AND SUBMITDATE_ BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}')TotRejReq
	, (SELECT COUNT(DISTINCT m.PARTYROLE_ID) FROM MIGRATIONSTATUS_ m WHERE SUBMITDATE_ BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}')TotUnqCustUpd
	, (SELECT COUNT(DISTINCT ms.PARTYROLE_ID) FROM MIGRATIONSTATUS_ ms WHERE ms.STATUS_=1 AND APPROVEDATE_ BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}')totApprUnqCustUpd
        , (SELECT COUNT(*) FROM MIGRATIONSTATUS_ ms WHERE ms.STATUS_=1 AND APPROVEDATE_ BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}')totAppr
	, (SELECT COUNT(*) FROM MIGRATION_ m 
		WHERE m.PARTYROLE_ID IN (SELECT DISTINCT ms.PARTYROLE_ID FROM MIGRATIONSTATUS_ ms WHERE STATUS_=1 AND APPROVEDATE_ BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}')
		AND m.CUSTOMERMIGRATIONSTATUS_ IN (1,2)
		)TotClnCust
	, (SELECT COUNT(*) FROM MIGRATION_ m 
		WHERE m.PARTYROLE_ID IN (SELECT DISTINCT ms.PARTYROLE_ID FROM MIGRATIONSTATUS_ ms WHERE STATUS_=1 AND APPROVEDATE_ BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}')
		AND m.CUSTOMERMIGRATIONSTATUS_ IN (0)
		)totCustHlfData
        , (SELECT group_concat(APPROVEDBY_) FROM 
			(SELECT CONCAT(ms.APPROVEDBY_,': ',COUNT(*)) APPROVEDBY_ 
				FROM MIGRATIONSTATUS_ ms WHERE STATUS_=1 AND APPROVEDATE_ BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}'
				GROUP BY ms.APPROVEDBY_) t
		)ApprByUsr";
    $data = $fxns->_execQuery($sqlClnProg, true, false);
    echo json_encode($data);
}elseif (isset($_POST['accType']) && !isset($_POST['chartTp'])) {
    foreach ($_POST['accType'] as $val) {
        @$migrated .= $val . 'ACCOUNTMIGRATEDCOUNT_ + ';
        @$ready .= $val . 'ACCOUNTREADYFORMIGRATION_ + ';
        @$legacy .= 'iBROKER' . $val . 'ACCOUNTCOUNT_ + ';
        @$sqlAcc .= "SELECT m.PARTYROLE_ID, m.LEGACY{$val}ACCOUNTNUMBER_ AccountNo, m.CUSTOMERID_,m.TYPE_ID, '{$val} Account' AccountTp"
                  . ", (SELECT a.NAME_ FROM PARTYROLETYPE_ a WHERE m.TYPE_ID = a.PARTYROLETYPE_ID) custTpNm"
                  . ",m.FULLNAME_,m.{$val}ACCOUNTMIGRATIONSTATUS_ ACCOUNTSTATUS_ FROM MIGRATION_ m WHERE ISDUPLICATE_ = 0 AND m.{$val}ACCOUNTMIGRATIONSTATUS_=1 UNION ALL ";
    }
    $sqlAcc = substr($sqlAcc, 0, strrpos($sqlAcc, "UNION ALL"));
    $migrated = '(' . substr($migrated, 0, strrpos($migrated, "+")) . ')';
    $ready = '(' . substr($ready, 0, strrpos($ready, "+")) . ')';
    $legacy = '(' . substr($legacy, 0, strrpos($legacy, "+")) . ')';
    $pieData = "SELECT $migrated migrated_, $ready ready_ , ($legacy - $migrated) 'Not Migrated'
				FROM MIGRATIONREPORT_ 
				WHERE CREATED_=(SELECT MAX(CREATED_) FROM MIGRATIONREPORT_)";
    $data = $fxns->_execQuery($pieData, true, false);
    ############  Build Chart lines   ####################
    $migratedSql = "SELECT IFNULL(CREATED_, NOW())CREATED_, IFNULL($migrated, 0) AccMigrated_
				FROM MIGRATIONREPORT_";
    $migratedSql = $fxns->_execQuery($migratedSql, true);
    $migratedLine = $fxns->_buildChartLine($migratedSql);
    $readyMigratn = "SELECT IFNULL(CREATED_, NOW())CREATED_, IFNULL($ready,0)accReady
		  FROM MIGRATIONREPORT_";
    $readyMigratn = $fxns->_execQuery($readyMigratn, true);
    $readyMigratnLine = $fxns->_buildChartLine($readyMigratn);
    $accMigLine = "callJqPlotlineChat('accMigLine'
					  , ''
					  , [$migratedLine,$readyMigratnLine]
					  , ['{$migratedSql[0]['CREATED_']}', '1 month']
					  , [{label:'Migrated'},{label:'Ready for Migrated'}]
				  )";

    ############  :End Build Chart lines   ####################

    $accMigPie = "callJqPlotPieChat('accMigPie'
							, ''
							,[
								['Migrated: &nbsp;&nbsp;{$data['migrated_']}',{$data['migrated_']}]
								, ['Not Migrated: &nbsp;&nbsp;{$data['Not Migrated']}',{$data['Not Migrated']}]
								, ['Ready For Migration: &nbsp;&nbsp;{$data['ready_']}',{$data['ready_']}]
							 ]
						)";
    echo "<div id=\"accMigPie\" class=\"chart\"></div>
			<div id=\"accMigLine\" style=\"float:left; margin-left:150px; width:600px;\"></div>
			<div id=\"report_results\" style=\"clear:both; width:85%; margin:auto; top:30px; border:1px solid #CCC;\">
				<div class=\"migrate\" style=\"width:95%; margin:auto;\">";

    $extras = array('type' => 'acc', 'hiddenFields'=>$hiddenFields, 'typeVals' => $_POST['accType']
                , 'button'=>array('class'=>'migrateAcc', 'value'=>'Migrate'));
    echo $cust->_drawTable($sqlAcc, $accMigTitle, $extras);
    echo "<div style=\"clear:both;\">&nbsp;</div>
        </div>
	</div>
	<div style=\"clear:both;\">&nbsp;</div>
        <div class=\"overlay\"><div>overlay<span id=\"dots\"></span></div></div>
	<script type=\"text/javascript\">" . $accMigPie . ';' . $accMigLine . ';' . '</script>';
    
}elseif (isset($_POST['dataQuality']) && !isset($_POST['chartTp'])) {
    //var_dump($_POST); exit;
    $sqlQuery = "SELECT m.PARTYROLE_ID, m.CUSTOMERID_, m.TYPE_ID";
    $sqlQuery .= ", (SELECT a.NAME_ FROM PARTYROLETYPE_ a WHERE m.TYPE_ID = a.PARTYROLETYPE_ID) custTpNm";
    $sqlQuery .= ", m.PARTY_ID, m.ADDRESSSTATE_ID, m.ADDRESSCOUNTRY_ID, m.FULLNAME_";
    $sqlQuery .= ", (SELECT p.TOTALASSETVALUE_ FROM PARTYROLE_ p WHERE p.PARTYROLE_ID = m.PARTYROLE_ID) TOTALASSETVALUE_";
    $sqlQuery .= ", 1 dataStatus";
    $sqlQuery .= " FROM MIGRATION_ m WHERE ISDUPLICATE_ = 0 AND ";
    foreach ($_POST['dataQuality'] as $val) {
        @$correct .= 'IS'.$val . 'VALID_ =1 AND ';
        @$least .= 'ERPCLEAN'.$val .'COUNT_ ,'; 
        @$howMany +=1;
    }
    $correct = substr($correct, 0, strrpos($correct, "AND"));
    $sqlQuery .= $correct;
    
    $least = ($howMany>1?'LEAST(':'') . substr($least, 0, strrpos($least, ",")) . ($howMany>1?')':'');
    $pieData = "SELECT (select COUNT(*) FROM MIGRATION_ WHERE ISDUPLICATE_ = 0 AND $correct) Correct
                    , ((select COUNT(*) FROM MIGRATION_ WHERE ISDUPLICATE_ = 0) - (select COUNT(*) FROM MIGRATION_ WHERE ISDUPLICATE_ = 0 AND $correct)) 'Not Correct'";
    
    $data = $fxns->_execQuery($pieData, true, false);

    $clean = "SELECT IFNULL(CREATED_, NOW())CREATED_, IFNULL({$least}, 0) 'Clean Names'
        FROM MIGRATIONREPORT_";
    
    //print_r($sqlQuery); exit;
    $clean = $fxns->_execQuery($clean, true);
    $cleanLine = $fxns->_buildChartLine($clean);
    $dirty = "SELECT IFNULL(CREATED_, NOW())CREATED_, IFNULL((ERPCUSTOMERCOUNT_ - {$least}),0) 'Dirty Names'
        FROM MIGRATIONREPORT_";
    $dirty = $fxns->_execQuery($dirty, true);
    $dirtyLine = $fxns->_buildChartLine($dirty);

    $dataQualityLine = "callJqPlotlineChat('dataQualityLine'
                        , ''
                        , [$cleanLine,$dirtyLine]
                        //, ['{$clean[0]['CREATED_']}', '1 month']
                        , ['2014-10-01 14:20:44', '1 month']
                        , [{label:'Correct'},{label:'Not Correct'}]
                    )";

    ############  :End Build Chart lines   ####################

    $dataQualityPie = "callJqPlotPieChat('dataQualityPie'
                                                    , 'Customer Names',[['Correct: &nbsp;&nbsp;{$data['Correct']}',{$data['Correct']}]
                                                    , ['Not Correct: &nbsp;&nbsp;{$data['Not Correct']}',{$data['Not Correct']}]]
                                            );";
      echo "<div id=\"dataQualityPie\" class=\"chart\"></div>
			<div id=\"dataQualityLine\" style=\"float:left; margin-left:150px; width:600px;\"></div>
			<div id=\"report_results\" style=\"clear:both; width:85%; margin:auto; top:30px; border:1px solid #CCC;\">
				<div class=\"migrate\" style=\"width:95%; margin:auto;\">";
    
    $extras = array('type' => 'data', 'hiddenFields'=>$hiddenFields, 'typeVals' => $_POST['dataQuality']
                , 'button'=>array('class'=>'migrateCust', 'value'=>'Migrate'));
    echo $cust->_drawTable($sqlQuery, $dataMigTitle, $extras);
    echo "<div style=\"clear:both;\">&nbsp;</div>
        </div>
	</div>
	<div style=\"clear:both;\">&nbsp;</div>
        <div class=\"overlay\"><div>overlay<span id=\"dots\"></span></div></div>
	<script type=\"text/javascript\">" . $dataQualityPie . ';' . $dataQualityLine . ';' . '</script>';
    
}elseif(isset($_POST['currentpage']) || isset($_POST['migrateService'])) {
    $_POST['extras'] = unserialize(base64_decode($_POST['extras']));
    $_POST['extras']['currentpage'] = @$_POST['currentpage'];
    foreach($_POST['extras'] as $key => $val){
        $_POST[$key] = $val; unset($_POST['extras'][$key]);
    }
    //var_dump($_POST);exit;
    $type = $_POST['typeVals'];
    if($_POST['type']=='acc'){
        foreach ($type as $val){
            @$sqlQuery .= "SELECT m.PARTYROLE_ID, m.LEGACY{$val}ACCOUNTNUMBER_ AccountNo, m.CUSTOMERID_,m.TYPE_ID"
                    . ", '{$val} Account' AccountTp"
                    . ", (SELECT a.NAME_ FROM PARTYROLETYPE_ a WHERE m.TYPE_ID = a.PARTYROLETYPE_ID) custTpNm"
                    . ",m.FULLNAME_,m.{$val}ACCOUNTMIGRATIONSTATUS_ ACCOUNTSTATUS_ "
                    . "FROM MIGRATION_ m WHERE m.ISDUPLICATE_ = 0 AND m.{$val}ACCOUNTMIGRATIONSTATUS_=".(!empty($_POST['chrtTp'][1])?$whatToLook[$_POST['chrtTp'][1]]:1)." UNION ALL ";            
        }
        $sqlQuery = substr($sqlQuery, 0, strrpos($sqlQuery, "UNION ALL"));
        $migTitle =$accMigTitle;
    }elseif($_POST['type']=='cust'){
        $sqlQuery = "SELECT m.PARTYROLE_ID, m.CUSTOMERID_, m.TYPE_ID";
        $sqlQuery .= ", (SELECT a.NAME_ FROM PARTYROLETYPE_ a WHERE m.TYPE_ID = a.PARTYROLETYPE_ID) custTpNm";
        $sqlQuery .= ", m.PARTY_ID, m.ADDRESSSTATE_ID, m.ADDRESSCOUNTRY_ID, m.FULLNAME_";
        $sqlQuery .= ", (SELECT p.TOTALASSETVALUE_ FROM PARTYROLE_ p WHERE p.PARTYROLE_ID = m.PARTYROLE_ID) TOTALASSETVALUE_";
        $sqlQuery .= ", CUSTOMERMIGRATIONSTATUS_, STACCOUNTMIGRATIONSTATUS_, MMACCOUNTMIGRATIONSTATUS_";
        $sqlQuery .= ", TBILLSACCOUNTMIGRATIONSTATUS_";  
        $sqlQuery .= " FROM MIGRATION_ m ";
        $sqlQuery .= " WHERE ISDUPLICATE_ = 0 AND m.CUSTOMERMIGRATIONSTATUS_ = ".(!empty($_POST['chrtTp'][1])?$whatToLook[$_POST['chrtTp'][1]]:1);
        
        $migTitle = $custMigTitle;
    }elseif($_POST['type']=='data'){
        $lookFor = !empty($_POST['chrtTp'][1])?$_POST['chrtTp'][1]:'Correct';
        //echo $lookFor;
        $whatToLook = array('Not Correct' => 0, 'Correct' => 1);
        $sqlQuery = "SELECT m.PARTYROLE_ID, m.CUSTOMERID_, m.TYPE_ID";
        $sqlQuery .= ", (SELECT a.NAME_ FROM PARTYROLETYPE_ a WHERE m.TYPE_ID = a.PARTYROLETYPE_ID) custTpNm";
        $sqlQuery .= ", m.PARTY_ID, m.ADDRESSSTATE_ID, m.ADDRESSCOUNTRY_ID, m.FULLNAME_";
        $sqlQuery .= ", (SELECT p.TOTALASSETVALUE_ FROM PARTYROLE_ p WHERE p.PARTYROLE_ID = m.PARTYROLE_ID) TOTALASSETVALUE_";
        $sqlQuery .= ",".$whatToLook[$lookFor]. " dataStatus";
        $sqlQuery .= " FROM MIGRATION_ m WHERE ISDUPLICATE_ = 0 AND ";
        $type = empty($type)?array('NAME'):$type;
        foreach ($type as $val) {
            @$correct .= 'IS'.$val . "VALID_ =".$whatToLook[$lookFor];
            @$correct .= ($whatToLook[$lookFor]==0)?' OR ':' AND ';
        }
        $correct = ($whatToLook[$lookFor]==0)? substr($correct, 0, strrpos($correct, "OR")):substr($correct, 0, strrpos($correct, "AND"));   
  
        $sqlQuery .= $correct;     
        $migTitle = $dataMigTitle;
    }elseif($_POST['type']=='others'){
        $sqlQuery = $_POST['query'];
        $migTitle = array('failure_reason'=>'Failure Reason', 'transaction_date'=>'Transaction Date'
                , 'reference_number'=>'Reference Number', 'ibroker_entry_serial'=>'Ibroker Entry Serial'
                , 'ibroker_acct_no'=>'Ibroker Acct No', 'ibroker_account_id'=>'Ibroker Acct Id'
                , 'ibroker_name'=>'Ibroker Name', 'ibroker_trans_code'=>'Ibroker Trans Code', 'amount'=>'Amount'
                , 'product_code'=>'Product Code', 'ibroker_accounting_branch'=>'Ibroker Branch');
    }
    $extras = $_POST;
    
    //print_r($sqlQuery);
    //var_dump($extras);exit;
    echo $cust->_drawTable($sqlQuery, $migTitle, $extras);
}else{
    if(isset($_GET['chartTp'])){
        $chartTp = $fxns->_multiexplode($_GET['chartTp'], array("-", ":"));        
    }else{
        $chartTp = $fxns->_multiexplode($_POST['chartTp'], array("-", ":"));
    }
    //var_dump($_POST);var_dump($chartTp); exit;
    if (isset($_POST['accType'])) {
        foreach ($_POST['accType'] as $val) {
            @$sqlQuery .= "SELECT m.PARTYROLE_ID, m.LEGACY{$val}ACCOUNTNUMBER_ AccountNo, m.CUSTOMERID_,m.TYPE_ID"
                    . ", '{$val} Account' AccountTp"
                    . ", (SELECT a.NAME_ FROM PARTYROLETYPE_ a WHERE m.TYPE_ID = a.PARTYROLETYPE_ID) custTpNm"
                    . ",m.FULLNAME_,m.{$val}ACCOUNTMIGRATIONSTATUS_ ACCOUNTSTATUS_ FROM MIGRATION_ m WHERE ISDUPLICATE_ = 0 AND m.{$val}ACCOUNTMIGRATIONSTATUS_=".$whatToLook[$chartTp[1]]." UNION ALL ";
        }        
        $sqlQuery = substr($sqlQuery, 0, strrpos($sqlQuery, "UNION ALL"));
        
        $extras = array('type' => 'acc', 'hiddenFields'=>$hiddenFields, 'typeVals' => $_POST['accType']
                , 'chrtTp'=>$chartTp, 'button'=>array('class'=>'migrateAcc', 'value'=>'Migrate'));

        //$extras = array('typeVals'=>$_POST['accType'], 'chrtTp'=>$chartTp, 'hiddenFields'=>$hiddenFields);
        $migTitle = $accMigTitle;
    } elseif (isset($_POST['dataQuality'])) {
        $whatToLook = array('Not Correct' => 0, 'Correct' => 1);
        $sqlQuery = "SELECT m.PARTYROLE_ID, m.CUSTOMERID_, m.TYPE_ID";
        $sqlQuery .= ", (SELECT a.NAME_ FROM PARTYROLETYPE_ a WHERE m.TYPE_ID = a.PARTYROLETYPE_ID) custTpNm";
        $sqlQuery .= ", m.PARTY_ID, m.ADDRESSSTATE_ID, m.ADDRESSCOUNTRY_ID, m.FULLNAME_";
        $sqlQuery .= ", (SELECT p.TOTALASSETVALUE_ FROM PARTYROLE_ p WHERE p.PARTYROLE_ID = m.PARTYROLE_ID) TOTALASSETVALUE_";
        $sqlQuery .= ",".$whatToLook[$chartTp[1]]. " dataStatus";
        $sqlQuery .= " FROM MIGRATION_ m WHERE ISDUPLICATE_ = 0 AND ";
        foreach ($_POST['dataQuality'] as $val) {
            @$correct .= 'IS'.$val . 'VALID_ ='.$whatToLook[$chartTp[1]].(($whatToLook[$chartTp[1]]==0)?' OR ':' AND ' );
        }
        $correct = ($whatToLook[$chartTp[1]]==0)? substr($correct, 0, strrpos($correct, "OR")):substr($correct, 0, strrpos($correct, "AND"));   
        $sqlQuery .= $correct;
        
        $migTitle = $dataMigTitle;
        $extras = array('type' => 'data', 'hiddenFields'=>$hiddenFields, 'typeVals' => $_POST['dataQuality']
                        , 'chrtTp'=>$chartTp, 'button'=>array('class'=>'migrateCust', 'value'=>'Migrate'));
    
    } elseif(strpos($chartTp[0], 'AccMapping') !== false) {
        
        $filename = $chartTp[0].'.csv';
        $fp = fopen('php://output', 'w');
        $accTp = str_replace("AccMapping","", $chartTp[0]);
        $sqlQuery = "SELECT * FROM 
                        (
                            SELECT *, (SELECT GROUP_CONCAT('mapped') FROM ACCOUNT_ a
                                        WHERE CASE WHEN iat.AcctSeg2Val ='2102' THEN a.BROKERAGENUMBER_ = iat.AccountNo
                                                WHEN iat.AcctSeg1Val ='2101' THEN a.MONEYMARKETNUMBER_ = iat.AccountNo
                                                WHEN iat.AcctSeg1Val ='2103' THEN a.TREASURYBILLNUMBER_ = iat.AccountNo
                                              END
                                        AND DUPLICATE_=0) 'mapped' 
                            FROM ibrokerAccTbl iat
                            WHERE (iat.AcctSeg2Val IN ('2102') OR iat.AcctSeg1Val IN ('2101','2103') ) AND iat.LastMovementDate >= '2012-05-01 00:00:00'
                        ) t";
        switch (strtolower($accTp)) {
            case 'st':
                $sqlQuery .= " WHERE AcctSeg2Val='2102' AND mapped {$whatToLook[$chartTp[1]]}";
                break;
            case 'tbills':
                $sqlQuery .= " WHERE AcctSeg1Val='2103' AND mapped {$whatToLook[$chartTp[1]]}";
                break;
            case 'mm':
                $sqlQuery .= " WHERE AcctSeg1Val='2101' AND mapped {$whatToLook[$chartTp[1]]}";
                break;
            default:
                break;
        }
        $stmt_erp = $dbo->prepare($sqlQuery);
        $stmt_erp->execute();
        foreach(range(0, $stmt_erp->columnCount() - 1) as $column_index){
            $col = $stmt_erp->getColumnMeta($column_index);
            $columns[] = $col['name'];
        }
        
        //download file
        header('Content-Type: application/csv; charset=utf-8');
        @header('Content-Disposition: attachment; filename="'.$filename.'"');
        
        fputcsv($fp,$columns);
        while( $row_erp = $stmt_erp->fetch(PDO::FETCH_ASSOC) ){
            foreach ($row_erp as $key => $value) {
                $row_erp[$key] = "'".$value;
            }
            fputcsv($fp,$row_erp);
        }
        exit;
    } elseif(strpos($chartTp[0], 'custMapping') !== false) {
        
        $filename = $chartTp[0].'.csv';
        $fp = fopen('php://output', 'w');
        $dataTp = str_replace("custMapping","", $chartTp[0]);
        
        $sqlQuery = "SELECT m.PARTYROLE_ID, m.CUSTOMERID_";
        $sqlQuery .= ", (SELECT a.NAME_ FROM PARTYROLETYPE_ a WHERE m.TYPE_ID = a.PARTYROLETYPE_ID) custTpNm";
        $sqlQuery .= ", m.PARTY_ID, m.ADDRESSSTATE_ID, m.ADDRESSCOUNTRY_ID, m.FULLNAME_";
        $sqlQuery .= ", (SELECT p.TOTALASSETVALUE_ FROM PARTYROLE_ p WHERE p.PARTYROLE_ID = m.PARTYROLE_ID) TOTALASSETVALUE_";
        $sqlQuery .= " FROM MIGRATION_ m WHERE ISDUPLICATE_ = 0 AND ";
        if(strtolower($dataTp) =='mapped'){
            $sqlQuery .= "ISCUSTOMERMAPPED_ = ".($chartTp[1]=='Not Mapped' ? "0" :'1');
        }else{
            $sqlQuery .= 'IS'.$dataTp . "VALID_ ={$whatToLook[$chartTp[1]]} ";
        }
        //var_dump($chartTp);
        //echo $sqlQuery; exit;
        $stmt_erp = $dbo->prepare($sqlQuery);
        $stmt_erp->execute();
        foreach(range(0, $stmt_erp->columnCount() - 1) as $column_index){
            $col = $stmt_erp->getColumnMeta($column_index);
            $columns[] = $col['name'];
        }
        
        //download file
        header('Content-Type: application/csv; charset=utf-8');
        @header('Content-Disposition: attachment; filename="'.$filename.'"');
        
        fputcsv($fp,$columns);
        while( $row_erp = $stmt_erp->fetch(PDO::FETCH_ASSOC) ){
            foreach ($row_erp as $key => $value) {
                $row_erp[$key] = "'".$value;
            }
            fputcsv($fp,$row_erp);
        }
        exit;
    }else{
        $sqlQuery = "SELECT m.PARTYROLE_ID, m.CUSTOMERID_, m.TYPE_ID";
        $sqlQuery .= ", (SELECT a.NAME_ FROM PARTYROLETYPE_ a WHERE m.TYPE_ID = a.PARTYROLETYPE_ID) custTpNm";
        $sqlQuery .= ", m.PARTY_ID, m.ADDRESSSTATE_ID, m.ADDRESSCOUNTRY_ID, m.FULLNAME_";
        $sqlQuery .= ", (SELECT p.TOTALASSETVALUE_ FROM PARTYROLE_ p WHERE p.PARTYROLE_ID = m.PARTYROLE_ID) TOTALASSETVALUE_";
        $sqlQuery .= ", CUSTOMERMIGRATIONSTATUS_, STACCOUNTMIGRATIONSTATUS_, MMACCOUNTMIGRATIONSTATUS_";
        $sqlQuery .= ", TBILLSACCOUNTMIGRATIONSTATUS_";
        $sqlQuery .= " FROM MIGRATION_ m ";
        $sqlQuery .= " WHERE ISDUPLICATE_ = 0 AND m.CUSTOMERMIGRATIONSTATUS_ IN ({$whatToLook[$chartTp[1]]}) ";
        
        $extras = array('type' => 'cust', 'chrtTp'=>$chartTp, 'hiddenFields'=>$hiddenFields
                        , 'button'=>array('class'=>'migrateCust', 'value'=>'Migrate'));
        $migTitle = $custMigTitle;
    }
    //echo $sqlQuery;exit;
    echo $cust->_drawTable($sqlQuery, $migTitle, $extras);
}
