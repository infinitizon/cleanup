<?php
/*
 * Include necessary files
 */
include_once 'core/init.inc.php';
$cust = new Customer($dbo);
$fxns = new Functions($dbo);

if(isset($_POST['export']) && $_POST['export']=='Go'){
    if($_POST['exportTp']=='CSV'){
        $query = trim($fxns->_decrypt(@$_POST['q'], SALT));
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=data.csv');
        $output = fopen('php://output', 'w');
        
//echo unserialize(base64_decode($_POST['q_t']));
        fputcsv($output, unserialize(base64_decode($_POST['q_t'])));

        $stmt = $dbo->prepare($query);
        $stmt->execute(array());
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            foreach ($result as $key => $value) {
                $result[$key] = str_replace(',', '\,', $result[$key]);
            }
            fputcsv($output, $result);
        }
        exit;
    }
}
if(!isset($_GET['sort'])){
    unset($_SESSION['sort_dir']);
}else{
    if(isset($_GET['allowSort'])){
        if(@$_SESSION['sort_dir']=='asc'){
            $_SESSION['sort_dir']= 'desc';
        }elseif(@$_SESSION['sort_dir']=='desc'){
            $_SESSION['sort_dir']= 'asc';
        }else{
            $_SESSION['sort_dir']= 'asc';
        }
    }
    unset($_GET['allowSort']);
}
/*
 * Set up the page title and CSS files
 */
$page_title = ":: Home &rsaquo;&rsaquo; Chapel Hill Denham ::";
$common_css_files = array('jquery-ui-1.11.min.css', 'common.css');
$page_css_files = array('main.css');
$font_awesome_files = array('font-awesome.css');
$general_js_files = array('jquery-1.7.2.min.js', 'jquery-ui-1.11.min.js', 'jquery.tablePagination.0.5.js', 'validator.js', 'common.js');
$page_js_files = array('main.js', 'pending.js');
/*
 * Include the header
 */
include_once 'assets/common/header.inc.php';
$appFilter = array('Pending','Approved','Rejected');

$tblTitle = array('sn' => "S/N", 'CUSTOMERID_' => 'Surviving Customer ID', 'TYPE_ID' => 'Customer Type'
    , 'FULLNAME_' => 'Full Name', 'DUPLICATE_IDS' => 'Duplicate Customer IDs', 'LASTUPDATEBY_' => 'Submitted By'
    , 'SUBMITDATE_' => "Submit Date" );
if(@$_GET['approveTp']==1){   
    $tblTitle['APPROVEDBY_'] = "Approved By";    
    $tblTitle['APPROVEDATE_'] = "Approve Date";    
}elseif(@$_GET['approveTp']==2){
    $tblTitle['APPROVEDBY_'] = "Rejected By";    
    $tblTitle['APPROVEDATE_'] = "Reject Date";   
    $tblTitle['REJECTREASON_'] = "Reason";        
}
//Prepare paging query.
$sqlSearchCount = "SELECT COUNT(*) count FROM MIGRATIONSTATUS_ WHERE STATUS_=".(isset($_GET['approveTp'])?$_GET['approveTp']:0);
$rowsperpage = 20;
$sqlSearchCount = $fxns->_execQuery($sqlSearchCount, true, false);
//var_dump($sqlSearchCount); exit;
$preparePaging = $fxns->_preparePaging($sqlSearchCount['count'], $rowsperpage, @$_GET['currentpage']);
$sqlPending = "SELECT ms.sn, ms.CUSTOMERID_, ".((@$_GET['approveTp']==1)?"m.FULLNAME_":"ms.FULLNAME_")
               . ", (SELECT a.NAME_ FROM PARTYROLETYPE_ a WHERE ms.TYPE_ID = a.PARTYROLETYPE_ID) TYPE_ID 
                , ms.DUPLICATE_IDS, ms.LASTUPDATEBY_, ms.SUBMITDATE_";
$sqlPending .= (@$_GET['approveTp']!=0)?", ms.APPROVEDBY_, ms.APPROVEDATE_":"";
$sqlPending .= (@$_GET['approveTp']==2)?", REJECTREASON_":"";
$sqlPending .= " FROM MIGRATIONSTATUS_ ms ";
$sqlPending .= (@$_GET['approveTp']==1)?" JOIN MIGRATION_ m ON m.PARTYROLE_ID = ms.PARTYROLE_ID ":"";
$sqlPending .= " WHERE ms.STATUS_=".(isset($_GET['approveTp'])?$_GET['approveTp']:0);
$sqlPending .= (isset($_GET['sort']))?" ORDER BY ".$_GET['sort']:"";
$sqlPending .= (isset($_POST['findCust']))?" AND FULLNAME_ LIKE '%".$_POST['findCust']."%'":"";
$sqlPending .= (isset($_SESSION['sort_dir']))?" ".$_SESSION['sort_dir']:"";
$sqlExport = $sqlPending;
$sqlPending = $sqlPending . " LIMIT {$preparePaging['offset']}, {$rowsperpage}";
//End Prepare paging query.

?>
<div id="search_results">
    <h3 style="width:<?php echo (@$_GET['approveTp']!=0)?'95%;':'85%;'; ?>">
        <div style="float: right;">
            <form action="" method="post">
                <label>Export as: <select style="width:60px;height:10px;" name="exportTp">
                    <option>CSV</option>
                    </select></label>
                <input type="hidden" name="q" value="<?php echo $fxns->_encrypt($sqlExport, SALT); ?>" />
                <input type="hidden" name="q_t" value="<?php echo base64_encode(serialize($tblTitle)); ?>" />
                <input type="submit" name="export" value="Go" />
                &nbsp;&nbsp;&nbsp;
                <label>Filter: <select style="width:100px;height:10px;" name="approvalFilter">
                    <?php 
                    foreach($appFilter as $key => $val){
                        echo "<option value=\"".$key."\" ".((@$_GET['approveTp']==$key)?"selected=\"selected\"":"").">".$val."</option>";
                    }
                    ?>
                    </select>
                </label>
            </form>
        </div>
        <form action="" method="post" style="float:right;">
        	<input type="text" value="" placeholder="Enter a name then press enter to search" 
        		style="width:250px;" name="findCust" />
        </form>
       <?php   
             switch (@$_GET['approveTp']) {
                case 1:
                    echo 'Approved';
                    break;
                case 2:
                    echo 'Rejected ';
                    break;
                default:
                    echo 'Awaiting approval';
                    break;
            }
        ?>
    </h3>
    <?php
$parsedURL = parseQueryString(parseQueryString("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],"sort"),'allowSort');
$href = (empty($_SERVER['QUERY_STRING'])?$parsedURL:(strpos($_SERVER['REQUEST_URI'],'?sort')?$parsedURL:$parsedURL.'&'));
$href = str_replace("??","?",$href);

    $pending = $fxns->_execQuery($sqlPending, true, true);
    $resultCount = count($pending);
    $table = 'Click row to view and approve';
    $table = '<form method="post" action="" style="width:'.((@$_GET['approveTp']!=0)?'98%;':'85%;').'"><table class="my_tables display clickable">';
    array_unshift($pending, $tblTitle);
    for ($i = 0; $i < count($pending); $i++) {
        $table .= "<tr>";
        foreach ($pending[0] as $key => $values) {
            if ($i == 0){
                $table .= "<th><a href='".$href."sort=".$key."' class='sortable'><span style='float:right;'>".((@$_SESSION['sort_dir']=='asc')?'&#9662;':((@$_SESSION['sort_dir']=='desc')?'&#9652;':'')) .'</span>'.  $pending[$i][$key]."</a></th>";
            }else {
                if ($key == 'sn') {
                    $table .= '<td><input type="hidden" name="sn" value="' . $pending[$i][$key] . '" />' .((($preparePaging['offset']+1)+$i)-1) . '</td>';
                }elseif ($key == 'REJECTREASON_') {
                    $rsn = $fxns->_readMore($pending[$i][$key], 15, NULL);
                    $table .= '<td><a href="'.$pending[$i]['sn'].'" id="rjctRsn" class="err">'.$rsn.'</a></td>';
                }elseif ($key == 'DUPLICATE_IDS') {
                    $sql = "SELECT GROUP_CONCAT(CUSTOMERID_) dupes
                            FROM MIGRATION_ WHERE PARTYROLE_ID IN ('" . str_replace(',', "','", $pending[$i][$key]) . "')";
                    $table .= "<td>" . getFrmMigratn($sql, 'dupes') . "</td>";
                } else {
                    $table .= "<td>" . $pending[$i][$key] . "</td>";
                }
            }
        }
        $table .= "</tr>";
        if ($resultCount == 0) {
            $table .= "<tr><td colspan=\"" . count($tblTitle) . "\" style=\"text-align:center;\">No records found!</td></tr>";
        }
    }
    $webLink = "";
    $param = "approveTp=".(isset($_GET['approveTp'])?$_GET['approveTp']:0).(isset($_GET['sort'])?'&sort='.$_GET['sort']:'').(isset($_GET['sort_dir'])?'&sort_dir='.$_GET['sort_dir']:'');
    $table .= "<tr><td colspan=\"".count($pending[0])."\" style=\"text-align:center;\">".$fxns->_buildPagingLinks(5, $preparePaging['currentpage'], $preparePaging['totalpages'], array('div' => 'phpPaging', 'link' => 'success','param'=>$param),$webLink)."</td></tr>";        
    $table .= '</table></form>';
    echo $table;
    ?>
</div>
<?php
/*
 * Include the footer
 */
include_once 'assets/common/footer.inc.php';

function getFrmMigratn($sql, $col) {
    global $dbo, $fxns;
    $getResult = $fxns->_execQuery($sql, true, false);
    return $getResult[$col];
}
function parseQueryString($url,$remove) {
    $infos=parse_url($url);
    if(@$infos["query"]){
        $str=$infos["query"];
        $op = array();
        $pairs = explode("&", $str);
        foreach ($pairs as $pair) {
           list($k, $v) = array_map("urldecode", explode("=", $pair));
            $op[$k] = $v;
        }
        if(isset($op[$remove])){
            unset($op[$remove]);
        }

        return str_replace($str,http_build_query($op),$url);
    }else{
        return $url.'?';
    }

} 
?>
<div id="dialog-pending" title="Preview"></div>
<div id="dialog-confirm" title="Preview"></div>
<script type="text/javascript">
$('a.sortable').on('click',function(e){
    e.preventDefault();
    window.location = $(this).attr('href')+'&allowSort=1';
});
</script>