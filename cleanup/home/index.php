<?php
/*
* Include necessary files
*/
include_once 'core/init.inc.php';
/*
* Set up the page title and CSS files
*/
$page_title = ":: Home &rsaquo;&rsaquo; Chapel Hill Denham ::";
$common_css_files = array('jquery-ui-1.11.min.css','common.css');
$page_css_files = array('main.css');
$font_awesome_files = array('font-awesome.min.css');
$general_js_files = array('jquery-1.7.2.min.js', 'jquery-ui-1.11.min.js', 'jquery.tablePagination.0.5.js', 'validator.js');
$page_js_files = array( 'main.js');
/*
* Include the header
*/
include_once 'assets/common/header.inc.php';
?>
<!-- Body content here -->
<div class="search_init initial">
	<div id="title">Search & Select Customer</div><br />
	<input type="text" class="search" name="search_term" placeholder="Enter search term and press enter to search..." /><i class="icon-search icon-2x searchSubmit"></i>
</div>
<div id="search_results"></div>
<?php
/*
* Include the footer
*/
include_once 'assets/common/footer.inc.php';
?>
<div id="dialog-confirm" title="Preview">
</div>