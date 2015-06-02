$(function() {
    var winHeight = $(window).height() * 0.95;
    var winWidth = $(window).width() * 0.95;
    zebraTable();
    $('table.clickable tr:gt(0)').not(':last').on('click', function(e) {
        if($('select[name=approvalFilter]').val()==2 && (e.target.cellIndex == $(this).children(':last').index())){
            
            return;
        }
        data = $.param({get_merger: 1, "id": $(this).find('input[type=hidden]').val(),'approveTp': $('select[name=approvalFilter]').val()});
        $.ajax({
            "type": "POST",
            "url": "assets/common/ajax2.inc.php",
            "data": data,
            "success": function(data) {
                $('#dialog-pending').html(data);
                
                var formHeight = $("form#rejectForm").height() * 1.5;
                var formWidth = $("form#rejectForm").width();
                returnCnt = $("form#rejectForm").find('input[type=radio]').length;
                formHeight = (winHeight>formHeight) ? formHeight : winHeight;
                formWidth = (winWidth>formWidth) ? ((returnCnt ==1)? 600:((returnCnt>2)? winWidth:formWidth)) : winWidth;
                
                $('#dialog-pending').dialog({height:formHeight,width: formWidth});
                
                zebraTable();
                openClsInputs();
                comboBox();
                reject();
                rejected();
            }
            , beforeSend: function() {
                showLoader('#dialog-pending');
                $("#dialog-pending").dialog({
                    resizable: false, height: winHeight, width: 1000, modal: true, closeOnEscape: false
                    , close: function(ev, ui) {
                        window.location.reload();
                        $("#dialog-confirm").dialog('close');
                    }
                });
            }
        });
    });
    $('select[name=exportTp]').selectmenu();
    $('a#rjctRsn').on('click', function(e) {        
        e.preventDefault();
        showLoader('#dialog-confirm');
        e.stopImmediatePropagation();
        $('#dialog-confirm').dialog({buttons:{}});
        data = $.param({'rjtRsnId':$(this).attr('href')});
        $.ajax({
            "type": "POST", "url": "assets/common/ajax2.inc.php", "data": data, "success": function(data) {
                $('#dialog-confirm').html(data).dialog({
                    buttons : {
                        Ok: function() {
                            id:"jqueryokid"
                            , $(this).dialog("close"); //closing on Ok click
                        }
                    }
                });
            }
        });
    });
    $('select[name=approvalFilter]').selectmenu({ 
        change: function( event, data ) {
            var oldURL = window.location.href;
            index = oldURL.indexOf('?')
            newURL = oldURL.substring(0, index);
            redirectTo = newURL+"?approveTp="+data.item.value;
            window.location.href = redirectTo;
        }
    })
});
var reject = function() {
    $('a.reject').on('click', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to reject this merge?.\n Note: You can simply edit to make corrections')) {
            $("#rejectRsn").dialog({resizable: false, height: 300, width: 500, modal: true});
            ;
            return;
        }
    });
}
var rejected = function() {
    $('a.rejected').on('click', function(e) {
        e.preventDefault();
        if ($('#rsn').val() == '') {
            alert('You have to input a reason for rejecting!');
            return false;
        }
        var data = $(this).parents('body').find('form#rejectForm').serialize() + '&' + $.param({'rsn': $('#rsn').val()});
        console.log(data);
        showLoader('#dialog-pending');
        $("#rejectRsn").dialog('close');
        $.ajax({
            "type": "POST", "url": "assets/common/ajax2.inc.php", "data": data, "success": function(data) {
                $('#dialog-pending').html(data);
                zebraTable();
                mergeAccounts();
            }
        });
    });
    $("#dialog-pending").dialog({
        close: function(ev, ui) {
            window.location.reload()
        }
    });
}
var merge2 = function() {
    var winHeight = $(window).height() * 0.95;
    var winWidth = $(window).width() * 0.95;
                   
    $('a.merge').on('click', function(e) {
        e.preventDefault();
        $("#dialog-confirm").dialog('close');
        if (confirm('Action is irreversible with single customers edit or customers with only one surviving customer account.\n\nProceed now?')) {
            showLoader('#dialog-pending');
            $.ajax({
                "type": "POST", "url": "assets/common/ajax2.inc.php", "data": $(this).parent('form').serialize(), "success": function(data) {
                    $('#dialog-pending').html(data);
                    $reviewScreen = $("form[name=reviewScreen]");
                    
                    var formHeight = $reviewScreen.height() * 1.5;
                    var formWidth = $reviewScreen.width();
                    
                    formHeight = (winHeight>formHeight) ? ((formHeight < 200)? 200:formHeight) : winHeight;
                    formWidth = (winWidth>formWidth) ? formWidth : winWidth;
                    
                    $('#dialog-pending').dialog({height:formHeight,width: formWidth});
                    if($reviewScreen.find('input[name=showOk]').val()==1){
                        $('#dialog-pending').dialog({buttons : {
                                Ok: function() {
                                    $(this).dialog("close"); //closing on Ok click
                                }
                            }
                        });
                    }                   
                
                    zebraTable();
                    mergeAccounts();
                }
            });
        }
    });
}
