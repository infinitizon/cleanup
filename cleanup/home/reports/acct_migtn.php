<?php
/*
 * Include necessary files
 */
include_once 'core/init.inc.php';
$cust = new Customer($dbo);
$fxns = new Functions($dbo);
/*
 * Include the header
 */
$accMigTitle = array('PARTYROLE_ID' => 'Party Role ID.', 'AccountNo'=>'Account No', 'AccountTp'=>'Account Type'
                    , 'CUSTOMERID_' => 'ERP Customer ID', 'custTpNm' => 'Customer Type', 'FULLNAME_' => 'Customer Name'
                    , 'ACCOUNTSTATUS_' => 'Status');
$hiddenFields = array('PARTYROLE_ID', 'PARTY_ID');
?>
<div style="float:right;">
    <form id="accMigPieForm">
        Choose Account Type:
        <label><input type="checkbox" name="accType[]" value="ST" checked="checked">Securities Trading</label>
        <label><input type="checkbox" name="accType[]" value="TBILLS">Treasury Bill Accounts</label>
        <label><input type="checkbox" name="accType[]" value="MM">Money Market Accounts</label>
    </form>
</div>
<div style="clear:both;">&nbsp;</div>
<fieldset style="position:relative">
    <legend>Account Migration Dashboard</legend>
    <div class="dbResult">
        <div id="accMigPie" class="chart">
            <?php
            $data = "SELECT STACCOUNTMIGRATEDCOUNT_ migrated_, STACCOUNTREADYFORMIGRATION_ ready_
					, ((SELECT COUNT(*) FROM MIGRATION_ WHERE ISDUPLICATE_ = 0 AND ERPST_ACC_NOS IS NOT NULL) - STACCOUNTMIGRATEDCOUNT_) 'Not Migrated'
				FROM MIGRATIONREPORT_ 
				WHERE CREATED_=(SELECT MAX(CREATED_) FROM MIGRATIONREPORT_);
				";
            $data = $fxns->_execQuery($data, true, false);
            $accMigPie = "callJqPlotPieChat('accMigPie'
                                , ''
                                ,[
                                    ['Migrated: &nbsp;&nbsp;{$data['migrated_']}',{$data['migrated_']}]
                                    , ['Not Migrated: &nbsp;&nbsp;{$data['Not Migrated']}',{$data['Not Migrated']}]
                                    , ['Ready For Migration: &nbsp;&nbsp;{$data['ready_']}',{$data['ready_']}]
                                 ]
                            )";
            ?>
        </div>
        <div id="accMigLine" style="float:left; margin-left:150px; width:600px;">
            <?php
            $migrated = "SELECT IFNULL(CREATED_, NOW())CREATED_, IFNULL(STACCOUNTMIGRATEDCOUNT_, 0) AccMigrated_
              FROM MIGRATIONREPORT_";
            $migrated = $fxns->_execQuery($migrated, true);
            $migratedLine = $fxns->_buildChartLine($migrated);
            $readyMigratn = "SELECT IFNULL(CREATED_, NOW())CREATED_
						, IFNULL(STACCOUNTREADYFORMIGRATION_,0)accReady
              FROM MIGRATIONREPORT_";
            $readyMigratn = $fxns->_execQuery($readyMigratn, true);
            $readyMigratnLine = $fxns->_buildChartLine($readyMigratn);

            $accMigLine = "callJqPlotlineChat('accMigLine'
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
                $sqlAcc = "SELECT m.PARTYROLE_ID, m.ERPST_ACC_NOS AccountNo, m.CUSTOMERID_,m.TYPE_ID, 'ST Account' AccountTp"
                        . ", (SELECT a.NAME_ FROM PARTYROLETYPE_ a WHERE m.TYPE_ID = a.PARTYROLETYPE_ID) custTpNm"
                        . ",m.FULLNAME_,m.STACCOUNTMIGRATIONSTATUS_ ACCOUNTSTATUS_ FROM MIGRATION_ m WHERE ISDUPLICATE_ = 0 AND STACCOUNTMIGRATIONSTATUS_=1";
                
        $extras = array('type' => 'acc', 'hiddenFields'=>$hiddenFields, 'typeVals' => array('ST')
                , 'button'=>array('class'=>'migrateAcc', 'value'=>'Migrate'));

        echo $cust->_drawTable($sqlAcc, $accMigTitle, $extras);
                ?>
                <div style="clear:both;">&nbsp;</div>
            </div>
        </div><!-- End Report results -->
        <div style="clear:both;">&nbsp;</div>
        <div class="overlay"><div>Loading<span id="dots"></span></div></div>
    </div>
</fieldset>

<script type="text/javascript">
<?php
echo $accMigPie . ";" . $accMigLine . ";";
?>
    zebraTable();dashboardPaging();clickRowMinusCheck();migrateCustOrAcc();
    $(':checkbox[name^=accType]').on('click', function() {
        if ($(':checkbox[name^=accType]:checked').length < 1) {
            alert('At least one account must be checked');
            return false;
        }
        $('fieldset .overlay').show();
        var data = $(this).parents('form').serialize();
        //alert(data);return;
        $.ajax({
            "type": "POST", "url": "assets/common/report.acc.inc.php", "data":data, "success": function(data) {
                $('.dbResult').html(data);
                $('fieldset .overlay').hide();
                zebraTable(); clickRowMinusCheck();
                dashboardPaging();migrateCustOrAcc();
                //countChecked(5);  doMerge(); 
            }
        });
    });
</script>