<?php
if(!isset($_SESSION['user'])){
	$this_url = "http".(!empty($_SERVER['HTTPS'])?"s":"")."://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	
	// Redirect to login page passing current URL
	header('Location: '.WEB_ROOT.'/?return_url=' . urlencode($this_url));
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link href='/cleanup/assets/images/logo.png' rel='SHORTCUT ICON' />

<title><?php echo $page_title; ?></title>

<meta name="title" content="Leave management system for the Ministry of science and computer, Lagos State, Nigeria.">
<meta name="keywords" content="Leave Management System, Leave, Ministry of science, Ministry of computer, Lagos State, Nigeria.">
<meta name="description" content="A governmental application for managing leave applications in the Lagos State Ministry of Science and Tech">
<meta name="author" content="Abimbola Hassan">

<?php foreach ( $common_css_files as $css ): ?>
	<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo WEB_ROOT; ?>/assets/css/<?php echo $css; ?>" />
<?php endforeach; ?>
<?php foreach ( $font_awesome_files as $font_awesome ): ?>
  <link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo WEB_ROOT; ?>/assets/fontawesome/css/<?php echo $font_awesome; ?>" />
<?php endforeach; ?>
<?php foreach ( $page_css_files as $page_css ): ?>
  <link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo WEB_ROOT; ?>/home/assets/css/<?php echo $page_css; ?>" />
<?php endforeach; ?>
  <style>
.ui-selectmenu-menu,.ui-selectmenu-button {font-size: 75%;}
</style>
</head>
<body>
<?php
$fxns = new Functions($dbo);
$sqlGetBadge = "SELECT COUNT(*) badge FROM MIGRATIONSTATUS_ WHERE STATUS_ = 0";
$badge = $fxns->_execQuery($sqlGetBadge, true, false);
?>
    <div id="onsearch" style="background:#F1F1F1; margin-top:-9px">
        
    	<div style="float:left; margin:20px;">
            <ul class="top-menu">
                <li><a href="<?php echo WEB_ROOT; ?>home/" style="background:#333; color:#FFF;" class="icon-home goodBtn" title="Go to search screen"> Customer Cleanup</a></li>
            </ul>
        </div>
     	<div style="float:right; margin:20px;">
            <ul class="top-menu">
                <li>
                    <?php
                    if ((WEB_SERVICE_URL == "http://192.168.2.17:8082/jbi" || $C['DB_HOST']=='192.168.2.17')
                            && $C['DB_NAME'] = 'chapelhill') {
                        echo '<span class="err" style="font-size:1.3em;">Production Environment</span>';
                    } else {
                        echo '<span class="success" style="font-size:1.3em;">Development Environment</span>';
                    }
                    ?>
                </li>
                <li><a href="<?php echo WEB_ROOT; ?>home/pending.php" style="background:#333; color:#FFF;"
                       class="icon-check goodBtn badge" <?php if ($badge['badge'] > 0) echo "data-badge=\"{$badge['badge']}\""; ?>>
                           <?php
                        if (in_array("MIGRATION_OFFICER", $_SESSION['user_dets']['authrole'])) {
                           echo "Pending";
                       } else {
                           echo "Pending approval";
                       }
                       ?></a>
                </li>
                <li><a href="<?php echo WEB_ROOT; ?>home/report.php" style="background:#333; color:#FFF;" class="icon-bar-chart goodBtn"> Dashboard</a></li>
                <li style="position:relative">
                    <a href="" class="user_dets"><i class="icon-user icon-large"></i><a>
                            <div id="user_dets">
                                <div style="padding:10px;">
                                    <strong><?php echo @$_SESSION['user_dets']['user_nm']['firstName'] . ' ' . @$_SESSION['user_dets']['user_nm']['lastName']; ?></strong>
                                    <br /><span style="color:#666; font-size:smaller">
                                            Role(s): <?php 
                                                        echo "<select style='width:100%;font-size:1.5em;' name='role'>";
                                                        foreach($_SESSION['user_dets']['authrole'] as $value){
                                                            echo "<option>".$value."</option>"; 
                                                        } 
                                                        echo "</select>";
                                                     ?>
                                        </span>
                                </div>
                                <div style="padding:10px; background:#F5F5F5; border-top:1px solid #C4C4C4;">
                                    <a href="?logout=yes" style="background:#900; color:#FFF; float:right;" class="icon-power-off failBtn"> Logout</a>
                                    <div style="clear:both;"></div>
                                </div>
                            </div>
                            </li>
                            </ul>
        </div>
        <div style="clear:both;"></div>
	</div>
	<div id="gen_container">