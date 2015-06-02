<?php
/*
 * Include necessary files
 */
include_once 'core/init.inc.php';
$cust = new Customer($dbo);
$fxns = new Functions($dbo);
//Array to hold titles - Titles will be used in drawing the tables
$custMigTitle = array('PARTYROLE_ID' => 'Party Role ID.', 'CUSTOMERID_' => 'ERP Customer ID', 'custTpNm' => 'Customer Type', 'FULLNAME_' => 'Customer Name', 'CUSTOMERMIGRATIONSTATUS_' => 'Status');
//Declare fields to be hidden in the eventual table
$hiddenFields = array('PARTYROLE_ID', 'PARTY_ID');
?>
<fieldset style="position:relative">
    <legend>Customer Migration Dashboard</legend>
    <div id="custMigPie" class="chart">
        <?php
        $data = "SELECT ERPCUSTOMERMIGRATEDCOUNT_ migrated_, (SELECT COUNT(*) FROM MIGRATION_ WHERE ISDUPLICATE_ = 0 AND CUSTOMERMIGRATIONSTATUS_=1) ready_
			, (ERPCUSTOMERCOUNT_ - ERPCUSTOMERMIGRATEDCOUNT_) 'Not Migrated'
                        FROM MIGRATIONREPORT_ 
                        WHERE CREATED_=(SELECT MAX(CREATED_) FROM MIGRATIONREPORT_)";
        $data = $fxns->_execQuery($data, true, false);
        $custMigPie = "callJqPlotPieChat('custMigPie'
										, ''
										,[
											['Migrated: &nbsp;&nbsp;{$data['migrated_']}',{$data['migrated_']}]
											, ['Not Migrated: &nbsp;&nbsp;{$data['Not Migrated']}',{$data['Not Migrated']}]
                                                                                        , ['Ready For Migration: &nbsp;&nbsp;{$data['ready_']}',{$data['ready_']}]											
										 ]
									)";
        ?>
    </div>
    <div id="custMigLine" style="float:left; margin-left:150px; width:600px;">
        <?php
        $migrated = "SELECT IFNULL(CREATED_, NOW())CREATED_, IFNULL(ERPCUSTOMERMIGRATEDCOUNT_, 0)ERPMIGRATEDCOUNT_
                        FROM MIGRATIONREPORT_";
        $migrated = $fxns->_execQuery($migrated, true);
        $migratedLine = $fxns->_buildChartLine($migrated);
        $readyMigratn = "SELECT IFNULL(CREATED_, NOW())CREATED_, IFNULL(ERPCUSTOMERREADYFORMIGRATION_,0)READYFORMIGRATION_
                        FROM MIGRATIONREPORT_";
        $readyMigratn = $fxns->_execQuery($readyMigratn, true);
        $readyMigratnLine = $fxns->_buildChartLine($readyMigratn);

        $custMigLine = "callJqPlotlineChat('custMigLine'
										, ''
										, [$migratedLine,$readyMigratnLine]
										, ['{$migrated[0]['CREATED_']}', '1 month']
										, [{label:'Migrated'},{label:'Ready for Migration'}]
									)";
        ?>
    </div>
    <div id="report_results" style="clear:both; width:85%; margin:auto; top:30px; border:1px solid #CCC;"><!-- Report results -->
        <div class="migrate" style="width:95%; margin:auto;">
            <?php
        $sqlQuery = "SELECT m.PARTYROLE_ID, m.CUSTOMERID_, m.TYPE_ID";
        $sqlQuery .= ", (SELECT a.NAME_ FROM PARTYROLETYPE_ a WHERE m.TYPE_ID = a.PARTYROLETYPE_ID) custTpNm";
        $sqlQuery .= ", m.PARTY_ID, m.ADDRESSSTATE_ID, m.ADDRESSCOUNTRY_ID, m.FULLNAME_";
        $sqlQuery .= ", (SELECT p.TOTALASSETVALUE_ FROM PARTYROLE_ p WHERE p.PARTYROLE_ID = m.PARTYROLE_ID) TOTALASSETVALUE_";
        $sqlQuery .= ", CUSTOMERMIGRATIONSTATUS_, STACCOUNTMIGRATIONSTATUS_, MMACCOUNTMIGRATIONSTATUS_";
        $sqlQuery .= ", TBILLSACCOUNTMIGRATIONSTATUS_";
        $sqlQuery .= " FROM MIGRATION_ m ";
        $sqlQuery .= " WHERE m.CUSTOMERMIGRATIONSTATUS_ =1 AND ISDUPLICATE_ = 0";
        
        $extras = array('type' => 'cust', 'hiddenFields'=>$hiddenFields
                , 'button'=>array('class'=>'migrateCust', 'value'=>'Migrate'));

        echo $cust->_drawTable($sqlQuery, $custMigTitle, $extras);
            ?>
            <div style="clear:both;">&nbsp;</div>
        </div>
    </div><!-- End Report results -->
    <div style="clear:both;">&nbsp;</div>
    <div class="overlay">Loading<span id="dots"></span></div>
</fieldset>
<script type="text/javascript">
    <?php
    echo $custMigPie . ";" . $custMigLine . ';';
    ?>
    zebraTable();dashboardPaging();
    clickRowMinusCheck();migrateCustOrAcc();
</script>


