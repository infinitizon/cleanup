<?php
/*
 * Include necessary files
 */
include_once 'core/init.inc.php';
$cust = new Customer($dbo);
$fxns = new Functions($dbo);

$sqlClnProg = "SELECT (SELECT COUNT(*) FROM MIGRATIONSTATUS_ m)TotSubReq
	, (SELECT COUNT(*) FROM MIGRATIONSTATUS_ m WHERE m.STATUS_ = 0)TotPendReq
	, (SELECT COUNT(*) FROM MIGRATIONSTATUS_ m WHERE m.STATUS_ = 1)TotApprReq
	, (SELECT COUNT(*) FROM MIGRATIONSTATUS_ m WHERE m.STATUS_ = 2)TotRejReq
	, (SELECT COUNT(DISTINCT m.PARTYROLE_ID) FROM MIGRATIONSTATUS_ m)TotUnqCustUpd
	, (SELECT COUNT(DISTINCT ms.PARTYROLE_ID) FROM MIGRATIONSTATUS_ ms WHERE ms.STATUS_=1)totApprUnqCustUpd
        , (SELECT COUNT(*) FROM MIGRATIONSTATUS_ ms WHERE ms.STATUS_=1)totAppr
	, (SELECT COUNT(*) FROM MIGRATION_ m 
		WHERE m.PARTYROLE_ID IN (SELECT DISTINCT ms.PARTYROLE_ID FROM MIGRATIONSTATUS_ ms WHERE STATUS_=1)
		AND m.CUSTOMERMIGRATIONSTATUS_ IN (1,2) AND IFNULL(m.ISDUPLICATE_,0) = 0
		)TotClnCust
	, (SELECT COUNT(*) FROM MIGRATION_ m 
		WHERE m.PARTYROLE_ID IN (SELECT DISTINCT ms.PARTYROLE_ID FROM MIGRATIONSTATUS_ ms WHERE STATUS_=1)
		AND m.CUSTOMERMIGRATIONSTATUS_ IN (0) AND IFNULL(m.ISDUPLICATE_,0) = 0
		)totCustHlfData
        , (SELECT group_concat(APPROVEDBY_) FROM 
			(SELECT CONCAT(ms.APPROVEDBY_,': ',COUNT(*)) APPROVEDBY_ 
				FROM MIGRATIONSTATUS_ ms WHERE STATUS_=1
				GROUP BY ms.APPROVEDBY_) t
		)ApprByUsr";
$data = $fxns->_execQuery($sqlClnProg, true, false);

?>

<fieldset style="position:relative">
    <legend>Cleanup Progress</legend
    <div>
        <form id="cleanupProgressForm" name="cleanupProgressForm">
            <input type="hidden" name="getDateRange" value="1" />
            <dl>
                <dt><strong>Filter Date Range:</strong></dt>
                <dd>
                    <label>Start Date: <input type="text" name="start_date" value=""></label>
                    <label>End Date: <input type="text" name="end_date" value=""></label>
                    <label><a href="" class="button" name="getRange" style="color:#FFF;">Go</a></label>
                </dd>
            </dl>
        </form>
    </div>
    <div>
    <table border="1" rules="all">
        <tr><th>&nbsp;</th><th>Period Selected</th><th>Total</th></tr>
        <tr><td>Submitted requests</td><td><span id="TotSubReq"> - </span></td><td><?php echo $data['TotSubReq'] ?></td></tr>
        <tr><td>Unique customers submitted</td><td><span id="TotUnqCustUpd"> - </span></td><td><?php echo $data['TotUnqCustUpd'] ?></td></tr>
        <tr><td>Pending requests</td><td><span id="TotPendReq"> - </span></td><td><?php echo $data['TotPendReq'] ?></td></tr>
        <tr><td>Approved requests</td><td><span id="TotApprReq"> - </span></td><td><?php echo $data['TotApprReq'] ?></td></tr>
        <tr><td>Rejected requests</td><td><span id="TotRejReq"> - </span></td><td><?php echo $data['TotRejReq'] ?></td></tr>
        <tr><td colspan="3" style="font-weight:bold;">&nbsp;</td></tr>
        <tr><td>Total customers approved (unique or not)</td><td><span id="totAppr"> - </span></td><td><?php echo $data['totAppr'] ?></td></tr>
        <tr><td>Unique customers approved</td><td><span id="totApprUnqCustUpd"> - </span></td><td><?php echo $data['totApprUnqCustUpd'] ?></td></tr>
        <tr><td>Approved customers with complete data</td><td><span id="TotClnCust"> - </span></td><td><a href="" class="appr_data" style="color:#900;" data-role="1"><?php echo $data['TotClnCust'] ?> &#8681;</a></td></tr>
        <tr><td>Approved customers with incomplete data</td><td><span id="totCustHlfData"> - </span></td><td><a href="" class="appr_data" style="color:#900;" data-role="0"><?php echo $data['totCustHlfData'] ?> &#8681;</a><span id="wait"></span></td></tr>
        <tr><td colspan="3" style="font-weight:bold;">&nbsp;</td></tr>
        <tr><td>Approvals by User</td><td><span id="ApprByUsr"> - </span></td><td><?php echo $data['ApprByUsr'] ?></td></tr>
    </table>
    </div>
    <form id="hiddenform" method="POST" action="appr_not_clean.php">
        <input type="hidden" id="filedata" name="data" value="">
    </form>
</fieldset>
<div id="ans"></div>
<script type="text/javascript">
var startDateTextBox = $('input[name=start_date]');
var endDateTextBox = $('input[name=end_date]');
$.timepicker.dateRange(
	startDateTextBox,
	endDateTextBox,
	{
		dateFormat: 'yy-mm-dd', 
                start: {}, // start picker options
		end: {} // end picker options
	}
);

$("a[name=getRange]").on("click", function(e){
    e.preventDefault();
    var data = $(this).parents('form[name=cleanupProgressForm]').serialize();
    $('#TotSubReq,#TotPendReq,#TotApprReq,#TotRejReq,#TotUnqCustUpd\n\
        ,#totApprUnqCustUpd,#TotClnCust,#totCustHlfData,#ApprByUsr,#totAppr').html("<img src='/cleanup/assets/images/loading2.gif' />");
    $.ajax({
        "type": "POST", "url": "assets/common/report.acc.inc.php", dataType:'json', "data":data, "success": function(data) {
            for (var key in data) {
                $('#' + key).html( data[key] );
            }
        }
    });
});
$("a.appr_data").click(function(e){       // click the download link
    e.preventDefault();
    $("#wait").html("<img src='/cleanup/assets/images/loading2.gif' />");     // start indicator
    $("#filedata").val($(this).attr('data-role'));
    $("#hiddenform").submit();         // submit the form data to the download page
    $("#wait").html("");
});
</script>