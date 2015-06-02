<?php
/*
 * Include necessary files
 */
include_once 'core/init.inc.php';
$fxns = new Functions($dbo);
/*
 * Set up the page title and CSS files
 */
$page_title = ":: Reports &rsaquo;&rsaquo; Chapel Hill Denham ::";
$common_css_files = array('jquery-ui-1.11.min.css', 'common.css', 'jquery-ui-timepicker-addon.css');
$page_css_files = array('main.css', 'report.css', 'jqPlot/jquery.jqplot.min.css');
$font_awesome_files = array('font-awesome.css');
$ie_js_files = array('excanvas.min.js');
$general_js_files = array('jquery-1.7.2.min.js', 'jquery-ui-1.11.min.js', 'jquery-ui-timepicker-addon.js', 'validator.js');
$page_js_files = array('main.js', 'reports.js', 'jqPlot/jquery.jqplot.min.js', 'jqPlot/plugins/jqplot.pieRenderer.min.js', 'jqPlot/plugins/jqplot.donutRenderer.min.js', 'jqPlot/plugins/jqplot.dateAxisRenderer.min.js', 'jqPlot/plugins/jqplot.canvasTextRenderer.min.js', 'jqPlot/plugins/jqplot.CanvasAxisTickRenderer.min.js');
/*
 * Include the header
 */
include_once 'assets/common/header.inc.php';
?>
<div id="reports">
    <ul>
        <li><a href="#migratn_summary">Migration Summary</a></li>
        <li><a href="reports/cust_migtn.php">Customer Migration Dashboard</a></li>
        <li><a href="reports/acct_migtn.php">Account Migration Dashboard</a></li>
        <li><a href="reports/data_quality_migtn.php">Data Quality Dashboard</a></li>
        <li><a href="reports/cleanup_progress.php">Cleanup Progress</a></li>
        <li><a href="reports/acc_not_found.php">Accounts not found</a></li>
    </ul>
    <div id="migratn_summary">
        <fieldset>
            <legend>ERP VS. iBroker Mapping</legend>
            <div id="custMappingMapped" class="chart">
                <?php
                $data = "SELECT (select COUNT(*) FROM MIGRATION_ 
                                    WHERE ISDUPLICATE_ = 0 AND ISCUSTOMERMAPPED_ = 1
                                        AND PARTYROLE_ID IN (SELECT PARTYROLE_ID FROM PARTYROLE_ WHERE TYPE_ID IN (4,5) AND LASTACTIVITYDATE_ >='2012-05-01')
                                ) Mapped
                                , ((select COUNT(*) FROM MIGRATION_ 
                                    WHERE ISDUPLICATE_ = 0
                                        AND PARTYROLE_ID IN (SELECT PARTYROLE_ID FROM PARTYROLE_ WHERE TYPE_ID IN (4,5) AND LASTACTIVITYDATE_ >='2012-05-01')) - 
                                   (select COUNT(*) FROM MIGRATION_ 
                                    WHERE ISDUPLICATE_ = 0 AND ISCUSTOMERMAPPED_ = 1
                                        AND PARTYROLE_ID IN (SELECT PARTYROLE_ID FROM PARTYROLE_ WHERE TYPE_ID IN (4,5) AND LASTACTIVITYDATE_ >='2012-05-01'))
                                   ) 'Not Mapped'";
                $data = $fxns->_execQuery($data, true, false);
                $custMappingMapped = "callJqPlotPieChat('custMappingMapped'
							, 'Customer Mapping',[['Mapped: &nbsp;&nbsp;{$data['Mapped']}',{$data['Mapped']}]
							, ['Not Mapped: &nbsp;&nbsp;{$data['Not Mapped']}',{$data['Not Mapped']}]]
						);";
                ?>
            </div>
            <div id="stAccMapping" class="chart">
                <?php
                $data = "SELECT LEGACYSTACCOUNTCOUNT_ Mapped, (iBROKERSTACCOUNTCOUNT_ - LEGACYSTACCOUNTCOUNT_) 'Not Mapped'
                        FROM MIGRATIONREPORT_ 
                        WHERE CREATED_=(SELECT MAX(CREATED_) FROM MIGRATIONREPORT_)";
                $data = $fxns->_execQuery($data, true, false);
                $stAccMapping = "callJqPlotPieChat('stAccMapping'
										, 'ST Account Mapping',[['Mapped: &nbsp;&nbsp;{$data['Mapped']}</a>',{$data['Mapped']}]
										, ['Not Mapped: &nbsp;&nbsp;{$data['Not Mapped']}',{$data['Not Mapped']}]]
								);";
                ?>
            </div>
            <div id="tBillsAccMapping" class="chart">
                <?php
                $data = "SELECT LEGACYTBILLSACCOUNTCOUNT_ Mapped, (iBROKERTBILLSACCOUNTCOUNT_ - LEGACYTBILLSACCOUNTCOUNT_) 'Not Mapped'
                        FROM MIGRATIONREPORT_ 
                        WHERE CREATED_=(SELECT MAX(CREATED_) FROM MIGRATIONREPORT_)";
                $data = $fxns->_execQuery($data, true, false);
                $tBillsAccMapping = "callJqPlotPieChat('tBillsAccMapping'
										, 'TBills Account Mapping',[['Mapped: &nbsp;&nbsp;{$data['Mapped']}</a>',{$data['Mapped']}]
										, ['Not Mapped: &nbsp;&nbsp;{$data['Not Mapped']}',{$data['Not Mapped']}]]
								);";
                ?>
            </div>
            <div id="mmAccMapping" class="chart">
                <?php
                $data = "SELECT LEGACYMMACCOUNTCOUNT_ Mapped, (iBROKERMMACCOUNTCOUNT_ - LEGACYMMACCOUNTCOUNT_) 'Not Mapped'
                        FROM MIGRATIONREPORT_ 
                        WHERE CREATED_=(SELECT MAX(CREATED_) FROM MIGRATIONREPORT_)";
                $data = $fxns->_execQuery($data, true, false);
                $mmAccMapping = "callJqPlotPieChat('mmAccMapping'
										, 'MM Account Mapping',[['Mapped: &nbsp;&nbsp;{$data['Mapped']}</a>',{$data['Mapped']}]
										, ['Not Mapped: &nbsp;&nbsp;{$data['Not Mapped']}',{$data['Not Mapped']}]]
								);";
                ?>
            </div>
        </fieldset>
        <fieldset>
            <legend>Data Quality</legend>
            <div id="custMappingNAME" class="chart">
                <?php
                $data = "SELECT (SELECT COUNT(*) FROM MIGRATION_ 
                                    WHERE ISDUPLICATE_ = 0 AND ISNAMEVALID_ = 1
                                    AND PARTYROLE_ID IN (SELECT PARTYROLE_ID FROM PARTYROLE_ WHERE TYPE_ID IN (4,5) AND LASTACTIVITYDATE_ >='2012-05-01')
                                 ) Correct
				, (
                                    (SELECT COUNT(*) FROM MIGRATION_ 
                                        WHERE ISDUPLICATE_ = 0
                                        AND PARTYROLE_ID IN (SELECT PARTYROLE_ID FROM PARTYROLE_ WHERE TYPE_ID IN (4,5) AND LASTACTIVITYDATE_ >='2012-05-01')
                                    ) 
                                        - 
                                    (SELECT COUNT(*) FROM MIGRATION_ 
                                        WHERE ISDUPLICATE_ = 0 AND ISNAMEVALID_ = 1
                                        AND PARTYROLE_ID IN (SELECT PARTYROLE_ID FROM PARTYROLE_ WHERE TYPE_ID IN (4,5) AND LASTACTIVITYDATE_ >='2012-05-01')
                                    )
                                  ) 'Not Correct'";
                $data = $fxns->_execQuery($data, true, false);
                $custMappingNAME = "callJqPlotPieChat('custMappingNAME'
										, 'Customer Names',[['Correct: &nbsp;&nbsp;{$data['Correct']}',{$data['Correct']}]
										, ['Not Correct: &nbsp;&nbsp;{$data['Not Correct']}',{$data['Not Correct']}]]
									);";
                ?>
            </div>
            <div id="custMappingADDRESS" class="chart">
                <?php
                $data = "SELECT (SELECT COUNT(*) FROM MIGRATION_ 
                                    WHERE ISDUPLICATE_ = 0 AND ISADDRESSVALID_ = 1
                                    AND PARTYROLE_ID IN (SELECT PARTYROLE_ID FROM PARTYROLE_ WHERE TYPE_ID IN (4,5) AND LASTACTIVITYDATE_ >='2012-05-01')
                                ) Correct
                                , (
                                    (SELECT COUNT(*) FROM MIGRATION_ 
                                        WHERE ISDUPLICATE_ = 0
                                        AND PARTYROLE_ID IN (SELECT PARTYROLE_ID FROM PARTYROLE_ WHERE TYPE_ID IN (4,5) AND LASTACTIVITYDATE_ >='2012-05-01')
                                    ) 
                                    - 
                                    (SELECT COUNT(*) FROM MIGRATION_ 
                                        WHERE ISDUPLICATE_ = 0 AND ISADDRESSVALID_ = 1
                                        AND PARTYROLE_ID IN (SELECT PARTYROLE_ID FROM PARTYROLE_ WHERE TYPE_ID IN (4,5) AND LASTACTIVITYDATE_ >='2012-05-01')
                                    )
                                  ) 'Not Correct'";
                $data = $fxns->_execQuery($data, true, false);
                $custMappingADDRESS = "callJqPlotPieChat('custMappingADDRESS'
                                                , 'Customer Addresses',[['Correct: &nbsp;&nbsp;{$data['Correct']}',{$data['Correct']}]
                                                , ['Not Correct: &nbsp;&nbsp;{$data['Not Correct']}',{$data['Not Correct']}]]
                                            );";
                ?>
            </div>
            <div id="custMappingPHONENO" class="chart">
                <?php
                $data = "SELECT (SELECT COUNT(*) FROM MIGRATION_ 
                                    WHERE ISDUPLICATE_ = 0 AND ISPHONENOVALID_ = 1
                                    AND PARTYROLE_ID IN (SELECT PARTYROLE_ID FROM PARTYROLE_ WHERE TYPE_ID IN (4,5) AND LASTACTIVITYDATE_ >='2012-05-01')
                                ) Correct
				, (
                                    (SELECT COUNT(*) FROM MIGRATION_ 
                                        WHERE ISDUPLICATE_ = 0
                                        AND PARTYROLE_ID IN (SELECT PARTYROLE_ID FROM PARTYROLE_ WHERE TYPE_ID IN (4,5) AND LASTACTIVITYDATE_ >='2012-05-01')
                                    ) 
                                    - 
                                    (SELECT COUNT(*) FROM MIGRATION_ 
                                        WHERE ISDUPLICATE_ = 0 AND ISPHONENOVALID_ = 1
                                        AND PARTYROLE_ID IN (SELECT PARTYROLE_ID FROM PARTYROLE_ WHERE TYPE_ID IN (4,5) AND LASTACTIVITYDATE_ >='2012-05-01')
                                    )
                                ) 'Not Correct'";
                $data = $fxns->_execQuery($data, true, false);
                $custMappingPHONENO = "callJqPlotPieChat('custMappingPHONENO'
										, 'Customer Mobile Numbers',[['Correct: &nbsp;&nbsp;{$data['Correct']}',{$data['Correct']}]
										, ['Not Correct: &nbsp;&nbsp;{$data['Not Correct']}',{$data['Not Correct']}]]
									);";
                ?>
            </div>
            <div id="custMappingEMAIL" class="chart">
                <?php
                $data = "SELECT (select COUNT(*) FROM MIGRATION_ 
                                    WHERE ISDUPLICATE_ = 0 AND ISEMAILVALID_ = 1
                                    AND PARTYROLE_ID IN (SELECT PARTYROLE_ID FROM PARTYROLE_ WHERE TYPE_ID IN (4,5) AND LASTACTIVITYDATE_ >='2012-05-01')
                                ) Correct
                                , (
                                    (select COUNT(*) FROM MIGRATION_ 
                                        WHERE ISDUPLICATE_ = 0
                                        AND PARTYROLE_ID IN (SELECT PARTYROLE_ID FROM PARTYROLE_ WHERE TYPE_ID IN (4,5) AND LASTACTIVITYDATE_ >='2012-05-01')
                                    )
                                    -
                                    (select COUNT(*) FROM MIGRATION_ 
                                        WHERE ISDUPLICATE_ = 0 AND ISEMAILVALID_ = 1
                                        AND PARTYROLE_ID IN (SELECT PARTYROLE_ID FROM PARTYROLE_ WHERE TYPE_ID IN (4,5) AND LASTACTIVITYDATE_ >='2012-05-01')
                                    )
                                ) 'Not Correct'";
                $data = $fxns->_execQuery($data, true, false);
                $custMappingEMAIL = "callJqPlotPieChat('custMappingEMAIL'
										, 'Customer Email Addresses',[['Correct: &nbsp;&nbsp;{$data['Correct']}',{$data['Correct']}]
										, ['Not Correct: &nbsp;&nbsp;{$data['Not Correct']}',{$data['Not Correct']}]]
									);";
                ?>
            </div>
        </fieldset>
    </div>

</div>
<?php
/*
 * Include the footer
 */
include_once 'assets/common/footer.inc.php';
?>
<style type="text/css">
.jqplot-data-label {
  color: #FFF;
}
iframe { position: absolute; left: -9999px; }
</style>
<script type="text/javascript">
    function prev_friday(dateAndTime) {
        var t = dateAndTime.split(/[- :]/);
        var today = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]), friday, day, closest;

        if(today.getDay() == 5){
            return today.getFullYear() + "/" + (today.getMonth() + 1) + "/" + today.getDate() + " " + t[3] + ":" + t[4]+ ":" +t[5];
        }else{
            day = today.getDay();
            lastweekFrmToday = (today.getDate()-7);
            friday = lastweekFrmToday - day + (day === 0 ? -6 : 5);
        }
        closest = new Date(today.setDate(friday)); 

        return closest.getFullYear() + "/" + (closest.getMonth() + 1) + "/" + closest.getDate()+ " " + t[3] + ":" + t[4]+ ":" +t[5];
    }
    $(document).bind('click', function(ev) {
  		if ( !$(ev.target).is("canvas")) {
        	$("ul.contextMenu").css({display:'none'});
    	}
  	});
    
    $.jqplot.config.enablePlugins = true;
    var callJqPlotPieChat = function(which, dTitle, data) {
        var pieCharts = jQuery.jqplot(which, [data], {
            title: dTitle,
            seriesColors: [ "#090", "#F00", "#FFA500"],
            captureRightClick: true,
            seriesDefaults: {
                // Make this a pie chart.
                renderer: jQuery.jqplot.PieRenderer,
                rendererOptions: {
                    // Put data labels on the pie slices.
                    // By default, labels show the percentage of the slice.
                    showDataLabels: true,
                    
                    //This will highlight a slice on mouse down instead of on move over
                    //highlightMouseDown: true 
                }
            },
            legend: {show: true, location: 's'}
        });
        $('#' + which).bind('jqplotDataClick', function(ev, seriesIndex, pointIndex, data) {
        	if (!$(ev.target).is(".contextMenu")) {
        		$("ul.contextMenu").css({display:'none'});
    		}
            var data = $('#' + which + 'Form').serialize() + '&' + $.param({chartTp: which + '-' + data});
            $.ajax({
                "type": "POST", "url": "assets/common/report.acc.inc.php", "data": data, "success": function(data) {
                    $('.migrate').html(data);$('fieldset .overlay').hide();
                    zebraTable();
                    dashboardPaging();
                    clickRowMinusCheck();
                }
                , beforeSend: function() {
                    $('.migrate').html('<div style="font-weight:bolder;margin:5% 10%;text-align:center;"><img src="/cleanup/assets/images/loading.gif" /><br />Loading...</div>');
                }
            });
        });
        $('#' + which).bind('jqplotRightClick', function (ev, seriesIndex, pointIndex, data) {        
            $("ul.contextMenu").css({display:'none'});
            if (data !== null) {
            	var data = $.param({chartTp: which + '-' + data.data});
                $link = '<ul class="contextMenu">'
                        + '<li class="edit"><a href="#download" data-role="'+data+'">Download</li>'
                        + '<li class="separator"><a href="#saveImg" data-role="'+data+'">Save Image</a></li>'
                        + '</ul>';
            	$($link)
            	.appendTo("body")
            	.css({display:'block', top: ev.pageY + "px", left: ev.pageX + "px"});
            }
        });
    }
    var callJqPlotlineChat = function(which, dTitle, data, minDate, seriesLabel) {
        var plot3 = $.jqplot(which
                , data
                , {
                    title: dTitle
                    , stackSeries: true
                    , showMarker: false
                    , seriesDefaults: {
                        fill: true
                    }
                    //, seriesColors: [ "#090", "#FFA500", "#F00"]
                    , axesDefaults: {
                        tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                        tickOptions: {
                            angle: -30
                        }
                    }
                    , axes: {
                        yaxis: {min:0}
                        , xaxis: {
                            renderer: $.jqplot.DateAxisRenderer,
                            tickOptions: {
                                formatString: '%b %#d, %#I %p'
                                , showGridline: false
                            },
                            // min: prev_friday(minDate[0]),
                            min: minDate[0]
                            , tickInterval: minDate[1]
                            , pad: 0
                            , padMin : minDate[0]
                        }
                    }
                    //, series: [{lineWidth: 4, markerOptions: {style: 'square'}}]
                    , legend: {show: true, location: 'e'}
                    , series: seriesLabel
                });
    }
<?php echo $custMappingMapped . $stAccMapping . $tBillsAccMapping . $mmAccMapping; ?>
<?php echo $custMappingNAME . $custMappingADDRESS . $custMappingPHONENO . $custMappingEMAIL; ?>
    var dots = 0;
    var startDots = setInterval (type, 300);
    function type(){
        if(dots < 3)    {
            $('.overlay #dots').append('.');
            dots++;
        }else{
            $('.overlay #dots').html('');
            dots = 0;
        }
    }
    $(document).on('click', 'ul.contextMenu a', function(){
        data = $(this).attr('data-role');
        $("iframe").attr('src', "assets/common/report.acc.inc.php?"+data);
//        $.ajax({
//            "type": "POST", "url": "assets/common/report.acc.inc.php", "data": data
//            , "success": function(data) {
//                $('.migrate').html(data);$('fieldset .overlay').hide();
//            }
//            , beforeSend: function() {
//                $('.migrate').html('<div style="font-weight:bolder;margin:5% 10%;text-align:center;"><img src="/cleanup/assets/images/loading.gif" /><br />Loading...</div>');
//            }
//        });
    })
</script>
<div id="dialog-pending" title="Preview"></div>
<div id="dialog-confirm" title="Preview">
</div>
<iframe></iframe>