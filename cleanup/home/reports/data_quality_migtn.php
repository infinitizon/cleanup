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
$custMigTitle = array('PARTYROLE_ID' => 'Party Role ID.', 'CUSTOMERID_' => 'ERP Customer ID', 'custTpNm' => 'Customer Type', 'FULLNAME_' => 'Customer Name', 'dataStatus' => 'Status');
$hiddenFields = array('PARTYROLE_ID', 'PARTY_ID');
?>
<div style="float:right;">
    <form id="dataQualityPieForm">
        Choose Data Quality Type:
        <label><input type="checkbox" name="dataQuality[]" value="NAME" checked="checked">Customer Names</label>
        <label><input type="checkbox" name="dataQuality[]" value="ADDRESS">Customer Addresses</label>
        <label><input type="checkbox" name="dataQuality[]" value="EMAIL">Customer Email Addresses</label>
        <label><input type="checkbox" name="dataQuality[]" value="PHONENO">Customer Mobile Number</label>
    </form>
</div>
<div style="clear:both;">&nbsp;</div>
<fieldset style="position:relative">
    <legend>Customer Migration Dashboard</legend>
    <div id="dataResult">
        <div id="dataQualityPie" class="chart">
            <?php
            $data = "SELECT (select COUNT(*) FROM MIGRATION_ WHERE ISNAMEVALID_ = 1 AND ISDUPLICATE_ = 0) Correct
                    , ((select COUNT(*) FROM MIGRATION_ WHERE ISDUPLICATE_ = 0) - (select COUNT(*) FROM MIGRATION_ WHERE ISNAMEVALID_ = 1 AND ISDUPLICATE_ = 0)) 'Not Correct'";
            $data = $fxns->_execQuery($data, true, false);
            $dataQualityPie = "callJqPlotPieChat('dataQualityPie'
								, 'Customer Names',[['Correct: &nbsp;&nbsp;{$data['Correct']}',{$data['Correct']}]
								, ['Not Correct: &nbsp;&nbsp;{$data['Not Correct']}',{$data['Not Correct']}]]
							);";
            ?>
        </div>
        <div id="dataQualityLine" style="float:left; margin-left:150px; width:600px;">
            <?php
            $clean = "SELECT IFNULL(CREATED_, NOW())CREATED_, IFNULL(ERPCLEANNAMECOUNT_, 0) 'Clean Names'
                FROM MIGRATIONREPORT_";
            $clean = $fxns->_execQuery($clean, true);
            $cleanLine = $fxns->_buildChartLine($clean);
            $dirty = "SELECT IFNULL(CREATED_, NOW())CREATED_, IFNULL((ERPCUSTOMERCOUNT_ - ERPCLEANNAMECOUNT_),0) 'Dirty Names'
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
            ?>
        </div>
        <div id="report_results" style="clear:both; width:85%; margin:auto; top:30px; border:1px solid #CCC;"><!-- Report results -->
            <div class="migrate" style="width:95%; margin:auto; position:relative;">
                <?php
        $sqlQuery = "SELECT m.PARTYROLE_ID, m.CUSTOMERID_, m.TYPE_ID";
        $sqlQuery .= ", (SELECT a.NAME_ FROM PARTYROLETYPE_ a WHERE m.TYPE_ID = a.PARTYROLETYPE_ID) custTpNm";
        $sqlQuery .= ", m.PARTY_ID, m.ADDRESSSTATE_ID, m.ADDRESSCOUNTRY_ID, m.FULLNAME_, m.TOTALASSETVALUE_";
	$sqlQuery .= ", 1 dataStatus";
        $sqlQuery .= " FROM MIGRATION_ m ";
        $sqlQuery .= " WHERE m.ISNAMEVALID_ =1 AND ISDUPLICATE_ = 0";
        
        $extras = array('type' => 'data', 'hiddenFields'=>$hiddenFields, 'typeVals' => array('NAME'), 'ready'=>0
                , 'button'=>array('class'=>'migrateCust', 'value'=>'Migrate'));
        echo $cust->_drawTable($sqlQuery, $custMigTitle, $extras);
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
echo $dataQualityPie . ";" . $dataQualityLine . ';';
?>
    zebraTable();dashboardPaging();clickRowMinusCheck();migrateCustOrAcc();
    $(':checkbox[name^=dataQuality]').on('click', function() {
        if ($(':checkbox[name^=dataQuality]:checked').length < 1) {
            alert('At least one account must be checked');
            return false;
        }
        $('fieldset .overlay').show();
        var data = $(this).parents('form').serialize();
        //alert(data);return;
        $.ajax({
            "type": "POST", "url": "assets/common/report.acc.inc.php", "data":data, "success": function(data) {
                $('#dataResult').html(data);   $('fieldset .overlay').hide();                
                zebraTable();dashboardPaging();clickRowMinusCheck();migrateCustOrAcc();
                //countChecked(5); doMerge(); zebraTable();
            }
        });
    });
</script>
