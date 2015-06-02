// ==ClosureCompiler==
// @output_file_name default.js
// @compilation_level SIMPLE_OPTIMIZATIONS
// ==/ClosureCompiler==

// JavaScript Document

$(function() {
    $("input.search").on("keyup", function(e) {
        if ($(this).val() != '') {
            $(this).parents('.search_init').removeClass('initial').addClass('onsearch');
            $('#title').hide()
        }
        if (e.keyCode == 13) {
            showLoader('#search_results');
            $.ajax({
                "type": "POST", "url": "assets/common/ajax.inc.php", "data": $(this).serialize(), "success": function(data) {
                    $('#search_results').html(data);
                    countChecked(5);
                    doMerge();
                    paginate();
                    zebraTable();
                }
            });
            $(this).autocomplete('close');
            return false;
        }
        if ($('.searchSubmit').data('clicked')) {
            alert('yes');
        }
    }).autocomplete({source: "assets/common/ajax.inc.php"});
    //Simulate a click once the search button is clicked
    $(".searchSubmit").click(function() {
        var e = $.Event("keyup", {keyCode: 13});// Create a new jQuery.Event object with specified event properties.
        $("input.search").trigger(e);// trigger an artificial keydown event with keyCode 13
    });
    $('.icon-user').on('click', function(e) {
        e.preventDefault();
        $('div#user_dets').toggle();
    });
    $('.icon-power-off').on('click', function(e) {
        $('div#user_dets').hide();
    });
    $(document).mouseup(function(e) {
        var container = $("div#user_dets");
        if (!container.is(e.target) && container.has(e.target).length === 0) { // if the target of the click isn't the container nor a descendant of the container
            container.hide();
        }
    });
    $('select[name=role]').selectmenu({ 
//        change: function( event, data ) {
//            var oldURL = window.location.href;
//            index = oldURL.indexOf('?')
//            newURL = oldURL.substring(0, index);
//            redirectTo = newURL+"?approveTp="+data.item.value;
//            window.location.href = redirectTo;
//        }
    });
});
var doMerge = function() {
    $('a.clean_cust').on('click', function(e) {
        var cust_type = $(':checkbox[name^=cust_id]:checked:first').attr('data-role-type');
        e.preventDefault();
        showLoader('#search_results');
        var data = $(this).parent('form').serialize() + '&' + $.param({'cust_type': cust_type});
        $.ajax({
            "type": "POST", "url": "assets/common/ajax.inc.php", "data": data, "success": function(data) {
                $('#search_results').html(data);
                zebraTable();
                comboBox();
                openClsInputs();
                validate();
            }
        });
    });
}
var countChecked = function(dmax) {
    $(':checkbox[name^=cust_id]').on('click', function() {
        var curRole = $(':checkbox[name^=cust_id]:checked:first').attr('data-role-type');
        if (this.checked) {
            if ($(':checkbox[name^=cust_id]:checked').length == 1) {
                $('a.clean_cust').text('Edit Customer');
            } else {
                $('a.clean_cust').text('Merge Customers');
            }
            $(":checkbox[name^=cust_id]:not(:checked)[data-role-type!=" + curRole + "]").attr('disabled', true)
            if ($(':checkbox[name^=cust_id]:checked[data-role-type=' + curRole + ']').length == dmax) {
                $(":checkbox[name^=cust_id]:not(:checked)").attr('disabled', true);
            }
        } else {
            if ($(':checkbox[name^=cust_id]:checked').length == 1) {
                $('a.clean_cust').text('Edit Customer');
            } else {
                $('a.clean_cust').text('Merge Customers');
            }
            if ($(':checkbox[name^=cust_id]:checked').length == 0) {
                $(":checkbox[name^=cust_id]:not(:checked)").attr('disabled', false);
            }
            if ($(':checkbox[name^=cust_id]:checked[data-role-type=' + curRole + ']').length < dmax) {
                $(':checkbox[name^=cust_id]:not(:checked)[data-role-type=' + curRole + ']').attr('disabled', false);
            }
        }
    });
    $('table.clickable tr:gt(0) td:not(:first-child)').on('click', function() {
        showLoader('#dialog-confirm');
        openDialog("#dialog-confirm");
        $.ajax({
            "type": "POST",
            "url": "assets/common/ajax.inc.php",
            "data": {clean_cust: 1, "cust_id[]": [$(this).parent('tr').find('input[type=checkbox]').val()], plain: 1, cust_type: $(this).parent('tr').find('input[type=checkbox]').attr('data-role-type')},
            "success": function(data) {
                $('#dialog-confirm').html(data);
            }
        });
    });

};
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
var comboBox = function() {
    $("select.combobox").change(function() {
        $(this).next('input.combo_in').val($(this).val())
    }).trigger('change');
    $("select.date").next('input.combo_in').datepicker({changeMonth: true, changeYear: true, dateFormat: 'M-dd-yy', yearRange: '-100:+0'});
    $("select[name=ADDRESSCOUNTRY_ID]:not(:disabled)").change(function() {
        $("select[name=ADDRESSSTATE_ID]:not(:disabled)").html('<option>Loading...</option>');
        $.ajax({
            "type": "POST", "url": "assets/common/ajax.inc.php", "data": {getStateCtyID: $(this).val()}, "success": function(data) {
                $("select[name=ADDRESSSTATE_ID]:not(:disabled)").html(data);
            }
        });
    });
}
//
var openClsInputs = function() {
    $('tr:not(:first-child) td').find(':input').prop("disabled", true);		//Initially disable all form elements
    var preIndex = $('input[type=radio]:checked').index('input[type=radio]') + 2;	//Try to get the prechecked radio (if any)
    $('td:nth-child(' + preIndex + ')').find(':input').prop("disabled", false);

    $('input[type=radio]').click(function() {
        var index = $('input[type=radio]:checked').index('input[type=radio]') + 2;
        if ($('td:nth-child(' + index + ')').find('input[name=ST_ACC_NOS]').val() == '' && $('input[type=radio]').length > 1) {
            alert('The surviving customer must be one with an ST account number');
            return false;
        } else {
            $('td:nth-child(' + index + ')').find(':input').prop("disabled", false);
            $('tr:not(:first-child) td:not(:nth-child(' + index + '))').find(':input').prop("disabled", true);
        }
    })
    $('a.preview').on('click', function(e) {
        e.preventDefault();
        if ($('input[type=radio]:checked').length == 0) {
            alert('You have not checked the column to preview');
            return;
        }
        var valid = ($("input[name=TYPE_ID]:not(:disabled)").val() == 4) ? validateCoporate() : validateForm();
        if (valid) {
            showLoader('#dialog-confirm');
            var data = $(this).parent('form').serialize() + '&' + $.param({'cust_type': $("input[name=TYPE_ID]:not(:disabled)").val()});
            $.ajax({
                "type": "POST", "url": "assets/common/ajax.inc.php", "data": data, "success": function(data) {
                    $('#dialog-confirm').html(data);
                    var lastUrlPart = location.pathname.split("/").pop()
                    
                    if (lastUrlPart == 'pending.php') merge2();
                    else merge();
                }
            });
            openDialog("#dialog-confirm");
        }
    });
}
var merge = function() {
    $('a.merge').on('click', function(e) {
        e.preventDefault();
        $("#dialog-confirm").dialog('close');
        if (confirm('Action is irreversible with single customers edit or customers with only one surviving customer account.\n\nProceed now?')) {
            showLoader('#search_results');
            $.ajax({
                "type": "POST", "url": "assets/common/ajax.inc.php", "data": $(this).parent('form').serialize(), "success": function(data) {
                    $('#search_results').html(data);
                    zebraTable();
                    mergeAccounts();
                }
            });
        }
    });
}
var mergeAccounts = function() {
    $('a.mergeCustAcc').on('click', function(e) {
        e.preventDefault();
        if ($('input[type=checkbox]:checked').length == 0) {
            alert('You have not selected the account(s) for merging.');
            return;
        }
        showLoader('#dialog-pending');
        $.ajax({
            "type": "POST", "url": "assets/common/ajax2.inc.php", "data": $(this).parent('form').serialize(), "success": function(data) {
                $('#dialog-pending').html(data);
            }
        });
    });
}
var showLoader = function(where, value) {
    $(where).html('<div style="position:absolutive;width:192px;margin:5% 10%;text-align:center;"><img src="/cleanup/assets/images/loading.gif" /><br />Loading...</div>');
}
var padLeadZero = function(n) {
    return (n < 10) ? ('0' + n) : n;
}
var closeNotification = function() {
    if ($('div#notification').css('display') == 'block')
        $('div#notification').slideUp('slow');
}
var validate = function() {
    $("input[name=PRIMARYPHONENO_]").change(function() {
        isPhone($("input[name=PRIMARYPHONENO_]:not(:disabled)"), 'PRIMARYPHONENO_', "Primary Phone invalid, pls check input", true)
    });
    $("input[name=WORKPHONENUMBER_]").change(function() {
        isPhone($("input[name=WORKPHONENUMBER_]:not(:disabled)"), 'WORKPHONENUMBER_', "Work Phone invalid, pls check input", true)
    });
    $("input[name=PRIMARYEMAILADDRESS_]").change(function() {
        isEmailValid($("input[name=PRIMARYEMAILADDRESS_]:not(:disabled)"), 'PRIMARYEMAILADDRESS_', "Primary email address invalid, pls check input", true)
    });
}
function validateForm() {
    if (notEmpty($("input[name=FIRSTNAME_]:not(:disabled)"), 'FIRSTNAME_', "The firstname you entered seems incorrect")) {
        if (validName($("input[name=FIRSTNAME_]:not(:disabled)"), 'FIRSTNAME_', "The firstname you entered seems incorrect")) {
            if (validName($("input[name=MIDDLENAME_]:not(:disabled)"), 'MIDDLENAME_', "Your middle name seems incorrect", true, 1)) {
                if (notEmpty($("input[name=LASTNAME_]:not(:disabled)"), 'LASTNAME_', "The last name you entered seems incorrect")) {
                    if (validName($("input[name=LASTNAME_]:not(:disabled)"), 'FIRSTNAME_', "The firstname you entered seems incorrect")) {
                        if (checkDate($("input[name=DATEOFBIRTH_]:not(:disabled)"), 'DATEOFBIRTH_', "Your date is invalid", true)) {
                            if (isPhone($("input[name=PRIMARYPHONENO_]:not(:disabled)"), 'PRIMARYPHONENO_', "Primary Phone invalid, pls check input", true)) {
                                if (isPhone($("input[name=WORKPHONENUMBER_]:not(:disabled)"), 'WORKPHONENUMBER_', "Work Phone invalid, pls check input", true)) {
                                    if (isEmailValid($("input[name=PRIMARYEMAILADDRESS_]:not(:disabled)"), 'PRIMARYEMAILADDRESS_', "Primary email address invalid, pls check input", true)) {
                                        if (isPhoneCode($("select[name*='_CODE']:not(:disabled)"))) {
                                            return true;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    return false;
}
function validateCoporate() {
    if (fullName($("input[name=FULLNAME_]:not(:disabled)"), 'FIRSTNAME_', "Customer name you entered is incorrect, pls check input")) {
        if (isPhone($("input[name=PRIMARYPHONENO_]:not(:disabled)"), 'PRIMARYPHONENO_', "Contact Phone Number invalid, pls check input", true)) {
            if (isEmailValid($("input[name=PRIMARYEMAILADDRESS_]:not(:disabled)"), 'PRIMARYEMAILADDRESS_', "Primary email address invalid, pls check input", true)) {
                if (isPhoneCode($("select[name*='_CODE']:not(:disabled)"))) {
                    return true;
                }
            }
        }
    }
    return false;
}

$('tr:not(:first-child) td').find(':input').prop("disabled", true);
var openDialog = function(theBox, options) {
    $(theBox).dialog({
        resizable: false
        , height: 500
        , width: 500
        , modal: true
        , closeOnEscape: false
    });
}