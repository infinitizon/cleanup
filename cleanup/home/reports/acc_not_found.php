<?php
/*
 * Include necessary files
 */
include_once 'core/init.inc.php';
$cust = new Customer($dbo);
$fxns = new Functions($dbo);
//Array to hold titles - Titles will be used in drawing the tables
$custMigTitle = array('failure_reason'=>'Failure Reason', 'transaction_date'=>'Transaction Date'
                , 'reference_number'=>'Reference Number', 'ibroker_entry_serial'=>'Ibroker Entry Serial'
                , 'ibroker_acct_no'=>'Ibroker Acct No'
                , 'ibroker_name'=>'Ibroker Name', 'ibroker_trans_code'=>'Ibroker Trans Code', 'amount'=>'Amount'
                , 'product_code'=>'Product Code', 'ibroker_accounting_branch'=>'Ibroker Branch');
//Declare fields to be hidden in the eventual table
$hiddenFields = array();
?>
<fieldset style="position:relative">
    <legend>Accounts not found</legend>
        <?php
            $sqlGetAccNotFound = "SELECT 
	a.failure_reason, b.transaction_date, b.reference_number, b.ibroker_entry_serial, b.ibroker_acct_no
	, b.ibroker_name, b.ibroker_trans_code, b.amount, b.product_code, b.ibroker_accounting_branch
FROM int_job_processor_db.job_processor a
	JOIN int_job_processor_db.account_deposit_job_details b
		ON a.job_id=b.job_id
WHERE failure_reason IN ('Customer Account Not Found','Bank Account Not Found')
UNION ALL
SELECT 
	a.failure_reason, b.transaction_date, b.reference_number, b.ibroker_entry_serial, b.ibroker_acct_no
	, b.ibroker_name, b.ibroker_trans_code, b.amount, b.product_code, b.ibroker_accounting_branch
FROM int_job_processor_db.job_processor a
	JOIN int_job_processor_db.account_withdrawal_job_details b
		ON a.job_id=b.job_id
WHERE failure_reason IN ('Customer Account Not Found','Bank Account Not Found')
";
        $encodeQry = $fxns->_encrypt($sqlGetAccNotFound, SALT);
        $extras = array('type' => 'others', 'hiddenFields'=>$hiddenFields, 'ready'=>0
        , 'query'=>$sqlGetAccNotFound);      
        ?>
    <div class="migrate"><?php echo $cust->_drawTable($sqlGetAccNotFound, $custMigTitle, $extras);  ?></div>
</fieldset>
<script type="text/javascript">
    zebraTable();dashboardPaging();
</script>


