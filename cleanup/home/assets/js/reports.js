// JavaScript Document
$(function() {
    $("#reports").tabs({
        beforeLoad: function(event, ui) {
            ui.panel.html("<b>Fetching Data.... Please wait....</b>");
            ui.jqXHR.error(function() {
                ui.panel.html(
                    "<i class='icon-info-sign icon-large'></i> Error loading tab. \n\
                    Please contact administrator for assistance.");
            });
        }
    });
    $("select").selectmenu();
});
var zebraTable = function() {
    $("table.my_tables tr:even").addClass('alt');
    $("table.my_tables tr").mouseover(function() {
        $(this).addClass("over");
    }).mouseout(function() {
        $(this).removeClass("over");
    });
    if ($("table.my_tables").hasClass('vertColNm')) {
        $("table.my_tables").find('td:first-child').addClass('vertColNm');
    }
}
var clickRowMinusCheck = function() {
    $('table.clickable tr:gt(0) td:not(:first-child)').on('click', function() {
        showLoader('#dialog-confirm');
        openDialog("#dialog-confirm");$("#dialog-confirm").dialog({title:'Edit'});
        $.ajax({
            "type": "POST",
            "url": "assets/common/ajax.inc.php",
            "data": {clean_cust: 1, "cust_id[]": [$(this).parent('tr').find('input[type=checkbox]').val()], cust_type: $(this).parent('tr').find('input[type=checkbox]').attr('data-role-type')},
            "success": function(data) {
                $('#dialog-confirm').html(data);
                zebraTable(); openClsInputsFrmMigrate();
            }
        });
    });
};
var migrateCustOrAcc = function() {
    $('.migrateAcc, .migrateCust').on('click', function(e) {
        e.preventDefault();
        
        var $tabs = $('#reports').tabs();
        var currTab = $tabs.tabs('option', 'active');
        $('#dialog-confirm').dialog();
        var q_data = $(this).parent('div.migrate').find('input[type=checkbox]:checked').serialize()
                +'&'+$(this).parent('div.migrate').find('input[type=checkbox]:checked').siblings().serialize()
                +'&'+$(this).attr('data-role')
                +'&'+$.param({'migrateService':1});
        //$('#dialog-confirm').html(data); return;
        $.ajax({
            "type": "POST",
            "url": "assets/common/ajax.inc.php",
            "data": q_data,
            "success": function(data) {
                $('#dialog-confirm').html(data).dialog({
                    close: function(ev, ui) { 
                        showLoader("div.migrate");
                        $.ajax({
                            "type": "POST", "url": "assets/common/report.acc.inc.php", "data":q_data, "success": function(data) {
                                $("div.migrate").html(data); 
                                zebraTable(); openClsInputsFrmMigrate();clickRowMinusCheck();
                                dashboardPaging();migrateCustOrAcc();
                            }
                        });
                    }
                });
                zebraTable(); openClsInputsFrmMigrate();
                //$tabs.tabs('load',currTab);
            }
        });
    });
};
var openClsInputsFrmMigrate = function(){
    $('a.preview').on('click', function(e) {
        e.preventDefault();
        /*
         * if ($('input[type=radio]:checked').length == 0) {
            alert('You have not checked the column to preview');
            return;
        }
         */
        var valid = ($("td:not(:first-child) input[name=TYPE_ID]:not(:disabled)").val() == 4) ? validateCoporate() : validateForm();
        var cust_type= $("td:not(:first-child) input[name=TYPE_ID]:not(:disabled)").val()
        if (valid) {
            showLoader('#dialog-confirm');
            var data = $(this).parent('form').serialize() 
                  + '&' + $.param({'cust_type': cust_type, 'checkID':$("input[name=checkID]:not(:disabled)").val()});
            $.ajax({
                "type": "POST", "url": "assets/common/ajax.inc.php", "data": data, "success": function(data) {
                    $('#dialog-confirm').html(data); 
                    mergeFrmReports();
                }
            });
            openDialog("#dialog-confirm");
        }
    });
}
var mergeFrmReports = function() {
    $('a.merge').on('click', function(e) {
        e.preventDefault();
        showLoader('#dialog-confirm');
        $.ajax({
            "type": "POST", "url": "assets/common/ajax.inc.php", "data": $(this).parent('form').serialize(), "success": function(data) {
                $('#dialog-confirm').html(data);
                zebraTable();
            }
        });
    });
}
var dashboardPaging = function() {
    $('.phpPaging a.dashboard').on('click', function(e) {
        e.preventDefault();
        showLoader('.migrate');
        var data = $(this).attr('href').substring(1);
        //alert(data);
        $.ajax({
            "type": "POST", "url": "assets/common/report.acc.inc.php", "data": data, "success": function(data) {
                $('.migrate').html(data);
                zebraTable(); openClsInputsFrmMigrate();clickRowMinusCheck();
                dashboardPaging();migrateCustOrAcc();
            }
        });
    });
}
var paginate = function() {
    var options = {
        // currPage : 2 
        //ignoreRows : $('tbody tr:odd', $('table')),
        optionsForRows: [5, 10, 15],
        rowsPerPage: 15,
        firstArrow: (new Image()).src = "/cleanup/assets/images/first.gif",
        prevArrow: (new Image()).src = "/cleanup/assets/images/prev.gif",
        lastArrow: (new Image()).src = "/cleanup/assets/images/last.gif",
        nextArrow: (new Image()).src = "/cleanup/assets/images/next.gif"
                // topNav : true
    }
    $('table.my_tables').tablePagination(options);
}
